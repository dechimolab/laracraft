<?php

namespace App\Services;

use App\Models\User;
use App\Models\WebauthnCredential;
use CBOR\Decoder;
use CBOR\StringStream;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class WebauthnService
{
    /**
     * Encode string to Base64URL (RFC 4648).
     */
    public static function base64urlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Decode string from Base64URL (RFC 4648).
     */
    public static function base64urlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    /**
     * Generate registration options for navigator.credentials.create().
     */
    public function generateRegisterOptions(User $user, ?string $rpId = null): array
    {
        $challenge = random_bytes(32);
        $encodedChallenge = self::base64urlEncode($challenge);

        $host = $rpId ?: (parse_url(config('app.url'), PHP_URL_HOST) ?: request()->getHost());
        $host = preg_replace('/:\d+$/', '', $host);
        $userId = $user->getKey() ?? $user->user_id ?? $user->id;

        // Save challenge and user ID in session for verification
        session([
            'webauthn.register.challenge' => $encodedChallenge,
            'webauthn.register.user_id' => $userId,
        ]);

        // Exclude existing credentials to prevent duplicate registration
        $excludeCredentials = $user->webauthnCredentials ? $user->webauthnCredentials->map(function (WebauthnCredential $cred) {
            $item = [
                'id' => $cred->credential_id,
                'type' => 'public-key',
            ];
            $transports = is_array($cred->transports) ? $cred->transports : json_decode((string) $cred->transports, true);
            if (!empty($transports) && is_array($transports)) {
                $item['transports'] = array_values($transports);
            }
            return $item;
        })->values()->all() : [];

        return [
            'challenge' => $encodedChallenge,
            'rp' => [
                'name' => config('app.name', 'ArtisanCraft Engine'),
                'id' => $host,
            ],
            'user' => [
                'id' => self::base64urlEncode((string) $userId),
                'name' => $user->username ?: $user->email,
                'displayName' => $user->name ?: $user->username,
            ],
            'pubKeyCredParams' => [
                ['type' => 'public-key', 'alg' => -7],   // ES256 (ECDSA with SHA-256)
                ['type' => 'public-key', 'alg' => -257], // RS256 (RSA with SHA-256)
            ],
            'authenticatorSelection' => [
                'authenticatorAttachment' => null, // Support platform (Touch ID / Windows Hello) and cross-platform
                'userVerification' => 'preferred',
                'residentKey' => 'preferred',
            ],
            'timeout' => 60000,
            'attestation' => 'none',
            'excludeCredentials' => $excludeCredentials,
        ];
    }

    /**
     * Verify registration response and store credential in database.
     */
    public function verifyRegistration(User $user, array $data, ?string $expectedRpId = null): WebauthnCredential
    {
        $storedChallenge = session('webauthn.register.challenge');
        $storedUserId = session('webauthn.register.user_id');
        $userId = $user->getKey() ?? $user->user_id ?? $user->id;

        if (!$storedChallenge || (int) $storedUserId !== (int) $userId) {
            throw new InvalidArgumentException('Challenge การลงทะเบียนหมดอายุหรือไม่ตรงกับผู้ใช้ปัจจุบัน');
        }

        // 1. Verify clientDataJSON
        if (empty($data['response']['clientDataJSON']) || empty($data['response']['attestationObject'])) {
            throw new InvalidArgumentException('ข้อมูล Credential จากเบราว์เซอร์ไม่ครบถ้วน');
        }

        $rawClientData = self::base64urlDecode($data['response']['clientDataJSON']);
        $clientData = json_decode($rawClientData, true);

        if (!$clientData || ($clientData['type'] ?? '') !== 'webauthn.create') {
            throw new InvalidArgumentException('ประเภทการทำงาน (ClientData type) ไม่ถูกต้อง');
        }

        if (($clientData['challenge'] ?? '') !== $storedChallenge) {
            throw new InvalidArgumentException('Challenge ไม่ถูกต้องหรือไม่ตรงกับเซสชัน');
        }

        // 2. Decode attestationObject using CBOR
        $rawAttestation = self::base64urlDecode($data['response']['attestationObject']);
        $stream = StringStream::create($rawAttestation);
        $decoder = Decoder::create();
        $cborAttestation = $decoder->decode($stream);
        $attestationMap = $cborAttestation->normalize();

        if (empty($attestationMap['authData'])) {
            throw new InvalidArgumentException('ไม่พบ Authenticator Data ใน Attestation Object');
        }

        $authData = $attestationMap['authData'];
        if (strlen($authData) < 37) {
            throw new InvalidArgumentException('Authenticator Data มีขนาดสั้นเกินไป');
        }

        // Verify RP ID Hash
        $rpId = $expectedRpId ?: request()->getHost();
        $expectedRpHash = hash('sha256', $rpId, true);
        $rpIdHash = substr($authData, 0, 32);
        if (!hash_equals($expectedRpHash, $rpIdHash)) {
            Log::warning("WebAuthn RP ID mismatch: expected {$rpId}");
        }

        // Verify flags: UP (0x01) and AT (0x40)
        $flags = ord($authData[32]);
        if (($flags & 0x01) === 0) {
            throw new InvalidArgumentException('ผู้ใช้งานไม่ได้ทำการยืนยันตัวตนบนอุปกรณ์ (User Present flag is off)');
        }
        if (($flags & 0x40) === 0) {
            throw new InvalidArgumentException('ไม่พบข้อมูลกุญแจสาธารณะ (Attested credential data flag is off)');
        }

        // Sign count
        $signCount = unpack('N', substr($authData, 33, 4))[1];

        // Parse Attested Credential Data
        $aaguid = substr($authData, 37, 16);
        $credIdLen = unpack('n', substr($authData, 53, 2))[1];
        $credIdRaw = substr($authData, 55, $credIdLen);
        $cborKeyBytes = substr($authData, 55 + $credIdLen);

        // Decode COSE Public Key
        $keyStream = StringStream::create($cborKeyBytes);
        $keyDecoder = Decoder::create();
        $keyCbor = $keyDecoder->decode($keyStream);
        $coseKey = $keyCbor->normalize();

        $pemPublicKey = $this->coseToPem($coseKey);

        // Determine device name
        $deviceName = trim($data['deviceName'] ?? '');
        if (empty($deviceName)) {
            $deviceName = $this->detectDeviceName();
        }

        // Transports
        $transports = $data['response']['transports'] ?? null;
        if (is_array($transports)) {
            $transports = json_encode($transports);
        } elseif (is_string($transports)) {
            $transports = json_encode([$transports]);
        }

        // Create Credential Record
        $credential = WebauthnCredential::create([
            'user_id'       => $userId,
            'credential_id' => $data['id'],
            'public_key'    => $pemPublicKey,
            'user_handle'   => (string) $userId,
            'counter'       => $signCount,
            'device_name'   => $deviceName,
            'transports'    => $transports,
            'aaguid'        => bin2hex($aaguid),
            'last_used_at'  => now(),
            'created_by'    => $user->username ?: $user->name,
            'updated_by'    => $user->username ?: $user->name,
            'request_uri'   => request()->getRequestUri(),
        ]);

        // Clean up session
        session()->forget(['webauthn.register.challenge', 'webauthn.register.user_id']);

        return $credential;
    }

    /**
     * Generate login options for navigator.credentials.get().
     */
    public function generateLoginOptions(?User $user = null, ?string $rpId = null): array
    {
        $challenge = random_bytes(32);
        $encodedChallenge = self::base64urlEncode($challenge);

        $host = $rpId ?: (parse_url(config('app.url'), PHP_URL_HOST) ?: request()->getHost());
        $host = preg_replace('/:\d+$/', '', $host);

        session(['webauthn.login.challenge' => $encodedChallenge]);

        $allowCredentials = [];
        if ($user && $user->webauthnCredentials) {
            $allowCredentials = $user->webauthnCredentials->map(function (WebauthnCredential $cred) {
                $item = [
                    'id' => $cred->credential_id,
                    'type' => 'public-key',
                ];
                $transports = is_array($cred->transports) ? $cred->transports : json_decode((string) $cred->transports, true);
                if (!empty($transports) && is_array($transports)) {
                    $item['transports'] = array_values($transports);
                }
                return $item;
            })->values()->all();
        } elseif (!$user) {
            $allowCredentials = WebauthnCredential::latest('last_used_at')->take(20)->get()->map(function (WebauthnCredential $cred) {
                $item = [
                    'id' => $cred->credential_id,
                    'type' => 'public-key',
                ];
                $transports = is_array($cred->transports) ? $cred->transports : json_decode((string) $cred->transports, true);
                if (!empty($transports) && is_array($transports)) {
                    $item['transports'] = array_values($transports);
                }
                return $item;
            })->values()->all();
        }

        return [
            'challenge' => $encodedChallenge,
            'rpId' => $host,
            'allowCredentials' => $allowCredentials,
            'userVerification' => 'preferred',
            'timeout' => 60000,
        ];
    }

    /**
     * Verify login response and return matched WebauthnCredential.
     */
    public function verifyLogin(array $data, ?string $expectedRpId = null): WebauthnCredential
    {
        $storedChallenge = session('webauthn.login.challenge');
        if (!$storedChallenge) {
            throw new InvalidArgumentException('Challenge การเข้าสู่ระบบหมดอายุ');
        }

        if (empty($data['id']) || empty($data['response']['clientDataJSON']) || empty($data['response']['authenticatorData']) || empty($data['response']['signature'])) {
            throw new InvalidArgumentException('ข้อมูลการยืนยันตัวตนไม่ครบถ้วน');
        }

        // 1. Verify clientDataJSON
        $rawClientData = self::base64urlDecode($data['response']['clientDataJSON']);
        $clientData = json_decode($rawClientData, true);

        if (!$clientData || ($clientData['type'] ?? '') !== 'webauthn.get') {
            throw new InvalidArgumentException('ประเภทคำขอ (ClientData type) ไม่ถูกต้อง');
        }

        if (($clientData['challenge'] ?? '') !== $storedChallenge) {
            throw new InvalidArgumentException('Challenge ไม่ถูกต้องหรือไม่ตรงกับระบบ');
        }

        // 2. Find credential
        $credential = WebauthnCredential::where('credential_id', $data['id'])->first();
        if (!$credential) {
            throw new InvalidArgumentException('ไม่พบลายนิ้วมือหรือกุญแจนี้ในระบบ');
        }

        // 3. Verify Authenticator Data
        $authData = self::base64urlDecode($data['response']['authenticatorData']);
        $flags = ord($authData[32]);
        if (($flags & 0x01) === 0) {
            throw new InvalidArgumentException('ผู้ใช้งานไม่ได้แตะยืนยันตัวตนบนอุปกรณ์');
        }

        // Check counter (Replay attack detection)
        $signCount = unpack('N', substr($authData, 33, 4))[1];
        if ($signCount > 0 && $signCount <= $credential->counter) {
            Log::warning("WebAuthn replay attack suspected for cred_id={$credential->cred_id}");
            throw new InvalidArgumentException('ตรวจพบความเสี่ยงของการส่งคำขอซ้ำ (Replay Attack Detected)');
        }

        // 4. Verify Cryptographic Signature
        $clientDataHash = hash('sha256', $rawClientData, true);
        $signedData = $authData . $clientDataHash;
        $signature = self::base64urlDecode($data['response']['signature']);

        $verifyResult = openssl_verify($signedData, $signature, $credential->public_key, OPENSSL_ALGO_SHA256);
        if ($verifyResult !== 1) {
            throw new InvalidArgumentException('ลายเซ็นดิจิทัลของลายนิ้วมือไม่ถูกต้อง');
        }

        // Update counter & last_used_at
        $credential->update([
            'counter' => $signCount,
            'last_used_at' => now(),
        ]);

        session()->forget('webauthn.login.challenge');

        return $credential;
    }

    /**
     * Convert COSE public key map to PEM public key format.
     */
    protected function coseToPem(array $coseKey): string
    {
        $kty = $coseKey[1] ?? null;
        $alg = $coseKey[3] ?? null;

        // ES256: EC2 curve P-256
        if ((int) $kty === 2 && (int) $alg === -7) {
            $x = $coseKey[-2] ?? '';
            $y = $coseKey[-3] ?? '';

            if (strlen($x) !== 32 || strlen($y) !== 32) {
                throw new InvalidArgumentException('ขนาดพิกัดของ EC Public Key ไม่ถูกต้อง');
            }

            // ASN.1 DER Header for prime256v1 (secp256r1)
            $derHeader = hex2bin('3059301306072a8648ce3d020106082a8648ce3d03010703420004');
            $der = $derHeader . $x . $y;

            return "-----BEGIN PUBLIC KEY-----\n" . chunk_split(base64_encode($der), 64, "\n") . "-----END PUBLIC KEY-----\n";
        }

        // RS256: RSA
        if ((int) $kty === 3 && (int) $alg === -257) {
            $n = $coseKey[-1] ?? '';
            $e = $coseKey[-2] ?? '';

            // Build RSA Public Key DER
            $modulusDer = "\x02" . $this->encodeLength(strlen($n)) . $n;
            $exponentDer = "\x02" . $this->encodeLength(strlen($e)) . $e;
            $rsaSeq = "\x30" . $this->encodeLength(strlen($modulusDer) + strlen($exponentDer)) . $modulusDer . $exponentDer;
            $bitString = "\x03" . $this->encodeLength(strlen($rsaSeq) + 1) . "\x00" . $rsaSeq;
            $algSeq = hex2bin('300d06092a864886f70d0101010500');
            $der = "\x30" . $this->encodeLength(strlen($algSeq) + strlen($bitString)) . $algSeq . $bitString;

            return "-----BEGIN PUBLIC KEY-----\n" . chunk_split(base64_encode($der), 64, "\n") . "-----END PUBLIC KEY-----\n";
        }

        throw new InvalidArgumentException("ไม่รองรับอัลกอริทึม COSE kty={$kty}, alg={$alg}");
    }

    /**
     * ASN.1 DER length encoder.
     */
    protected function encodeLength(int $len): string
    {
        if ($len < 128) {
            return chr($len);
        }
        $lenBytes = '';
        while ($len > 0) {
            $lenBytes = chr($len & 0xff) . $lenBytes;
            $len >>= 8;
        }
        return chr(0x80 | strlen($lenBytes)) . $lenBytes;
    }

    /**
     * Detect device and platform name from User-Agent.
     */
    protected function detectDeviceName(): string
    {
        $ua = request()->header('User-Agent', '');
        $platform = 'Device';
        if (stripos($ua, 'Macintosh') !== false) {
            $platform = 'Mac (Touch ID)';
        } elseif (stripos($ua, 'Windows') !== false) {
            $platform = 'Windows (Hello)';
        } elseif (stripos($ua, 'iPhone') !== false || stripos($ua, 'iPad') !== false) {
            $platform = 'Apple Device (Face/Touch ID)';
        } elseif (stripos($ua, 'Android') !== false) {
            $platform = 'Android Biometric';
        } elseif (stripos($ua, 'Linux') !== false) {
            $platform = 'Linux Security Key';
        }

        return $platform . ' - ' . now()->format('d/m/Y H:i');
    }
}
