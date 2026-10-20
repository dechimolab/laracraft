<?php

namespace Tests\Feature\Auth;

use App\Models\LogLogin;
use App\Models\User;
use App\Models\WebauthnCredential;
use App\Services\WebauthnService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class WebauthnLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_login_screen_renders_biometric_button(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('btn-biometric-login');
        $response->assertSee('สแกนลายนิ้วมือ / Passkey (Windows Hello / Touch ID)');
        $response->assertSee('loginWithBiometrics()', false);
    }

    public function test_login_options_generates_challenge_for_guest(): void
    {
        $response = $this->postJson(route('webauthn.login.options'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'challenge',
                'rpId',
                'allowCredentials',
                'userVerification',
                'timeout',
            ]);

        $this->assertTrue(session()->has('webauthn.login.challenge'));
    }

    public function test_login_options_with_username_returns_user_credentials(): void
    {
        $user = User::factory()->create(['username' => 'somchai.sec']);
        $cred = WebauthnCredential::create([
            'user_id'       => $user->user_id,
            'credential_id' => 'mock_cred_somchai_abc',
            'public_key'    => '-----BEGIN PUBLIC KEY-----MOCK-----END PUBLIC KEY-----',
            'user_handle'   => (string) $user->user_id,
            'counter'       => 0,
            'device_name'   => 'MacBook Touch ID',
            'created_by'    => $user->username,
            'updated_by'    => $user->username,
        ]);

        $response = $this->postJson(route('webauthn.login.options'), [
            'username' => 'somchai.sec',
        ]);

        $response->assertStatus(200);
        $allowCredentials = $response->json('allowCredentials');
        $this->assertCount(1, $allowCredentials);
        $this->assertEquals('mock_cred_somchai_abc', $allowCredentials[0]['id']);
    }

    public function test_login_verify_with_invalid_payload_fails(): void
    {
        session(['webauthn.login.challenge' => 'dummy_challenge']);

        $response = $this->postJson(route('webauthn.login.verify'), [
            'id' => 'non_existent_key',
            'response' => [
                'clientDataJSON'    => WebauthnService::base64urlEncode(json_encode(['type' => 'webauthn.get', 'challenge' => 'dummy_challenge'])),
                'authenticatorData' => WebauthnService::base64urlEncode(str_repeat('A', 37)),
                'signature'         => WebauthnService::base64urlEncode('bad_sig'),
            ],
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'error' => 'ไม่พบข้อมูลลายนิ้วมือนี้ในระบบ กรุณาเข้าสู่ระบบด้วยรหัสผ่านแล้วไปลงทะเบียนที่หน้าโปรไฟล์ก่อน',
                'not_registered' => true,
            ]);
    }

    public function test_successful_webauthn_login_authenticates_user_and_records_to_log_login(): void
    {
        // 1. Generate real OpenSSL EC Keypair
        $ecKey = openssl_pkey_new([
            'curve_name' => 'prime256v1',
            'private_key_type' => OPENSSL_KEYTYPE_EC,
        ]);
        openssl_pkey_export($ecKey, $privateKeyPem);
        $details = openssl_pkey_get_details($ecKey);
        $publicKeyPem = $details['key'];

        // 2. Create User and Credential
        $user = User::factory()->create([
            'username' => 'passkey.user',
            'name'     => 'Passkey Tester',
            'email'    => 'passkey@buu.ac.th',
        ]);

        $credId = 'test_cred_id_' . bin2hex(random_bytes(16));
        $credential = WebauthnCredential::create([
            'user_id'       => $user->user_id,
            'credential_id' => $credId,
            'public_key'    => $publicKeyPem,
            'user_handle'   => (string) $user->user_id,
            'counter'       => 0,
            'device_name'   => 'Touch ID Hardware',
            'created_by'    => $user->username,
            'updated_by'    => $user->username,
        ]);

        // 3. Set Session Challenge
        $rawChallenge = random_bytes(32);
        $encodedChallenge = WebauthnService::base64urlEncode($rawChallenge);
        session(['webauthn.login.challenge' => $encodedChallenge]);

        // 4. Construct clientDataJSON and authenticatorData
        $clientDataArray = [
            'type'      => 'webauthn.get',
            'challenge' => $encodedChallenge,
            'origin'    => 'https://localhost',
        ];
        $rawClientData = json_encode($clientDataArray);
        $encodedClientData = WebauthnService::base64urlEncode($rawClientData);

        // authData: 32 bytes rpIdHash + 1 byte flag (UP = 0x01) + 4 bytes counter (e.g. 5)
        $rpIdHash = hash('sha256', 'localhost', true);
        $flags = chr(0x01); // UP flag set
        $counter = pack('N', 5);
        $rawAuthData = $rpIdHash . $flags . $counter;
        $encodedAuthData = WebauthnService::base64urlEncode($rawAuthData);

        // 5. Sign (authenticatorData || SHA-256(clientDataJSON)) using the private key
        $clientDataHash = hash('sha256', $rawClientData, true);
        $dataToSign = $rawAuthData . $clientDataHash;
        openssl_sign($dataToSign, $rawSignature, $privateKeyPem, OPENSSL_ALGO_SHA256);
        $encodedSignature = WebauthnService::base64urlEncode($rawSignature);

        // 6. Send POST to verify login
        $response = $this->postJson(route('webauthn.login.verify'), [
            'id'       => $credId,
            'rawId'    => $credId,
            'type'     => 'public-key',
            'response' => [
                'clientDataJSON'    => $encodedClientData,
                'authenticatorData' => $encodedAuthData,
                'signature'         => $encodedSignature,
            ],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'ยืนยันตัวตนสำเร็จ',
            ]);

        // 7. Assertions
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->user_id, Auth::id());

        // Credential counter must be updated to 5
        $this->assertEquals(5, $credential->fresh()->counter);
        $this->assertNotNull($credential->fresh()->last_used_at);

        // Assert record in log_login table
        $this->assertDatabaseHas('log_login', [
            'user_id'   => $user->user_id,
            'username'  => $user->username,
            'lg_action' => 'เข้าสู่ระบบสำเร็จด้วยลายนิ้วมือ (WebAuthn / Passkey)',
        ]);
    }

    public function test_login_verify_with_bad_signature_fails_and_records_failed_log_login(): void
    {
        $ecKey = openssl_pkey_new([
            'curve_name' => 'prime256v1',
            'private_key_type' => OPENSSL_KEYTYPE_EC,
        ]);
        $details = openssl_pkey_get_details($ecKey);
        $publicKeyPem = $details['key'];

        $user = User::factory()->create(['username' => 'victim.user']);
        $credId = 'test_cred_id_bad_sig';
        WebauthnCredential::create([
            'user_id'       => $user->user_id,
            'credential_id' => $credId,
            'public_key'    => $publicKeyPem,
            'user_handle'   => (string) $user->user_id,
            'counter'       => 0,
            'device_name'   => 'Touch ID',
            'created_by'    => $user->username,
            'updated_by'    => $user->username,
        ]);

        $encodedChallenge = WebauthnService::base64urlEncode(random_bytes(32));
        session(['webauthn.login.challenge' => $encodedChallenge]);

        $rawClientData = json_encode(['type' => 'webauthn.get', 'challenge' => $encodedChallenge]);
        $rawAuthData = hash('sha256', 'localhost', true) . chr(0x01) . pack('N', 1);

        // Intentionally invalid signature (bogus ASN.1 sequence)
        $bogusSignature = hex2bin('3006020101020101');

        $response = $this->postJson(route('webauthn.login.verify'), [
            'id'       => $credId,
            'rawId'    => $credId,
            'type'     => 'public-key',
            'response' => [
                'clientDataJSON'    => WebauthnService::base64urlEncode($rawClientData),
                'authenticatorData' => WebauthnService::base64urlEncode($rawAuthData),
                'signature'         => WebauthnService::base64urlEncode($bogusSignature),
            ],
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'error' => 'การยืนยันตัวตนด้วยลายนิ้วมือไม่ถูกต้องหรือไม่สำเร็จ',
            ]);

        $this->assertFalse(Auth::check());

        // Assert failed attempt logged in log_login
        $this->assertDatabaseHas('log_login', [
            'username' => 'webauthn_user',
        ]);
    }

    public function test_login_verify_with_replayed_counter_fails_to_prevent_replay_attacks(): void
    {
        $ecKey = openssl_pkey_new([
            'curve_name' => 'prime256v1',
            'private_key_type' => OPENSSL_KEYTYPE_EC,
        ]);
        openssl_pkey_export($ecKey, $privateKeyPem);
        $details = openssl_pkey_get_details($ecKey);
        $publicKeyPem = $details['key'];

        $user = User::factory()->create(['username' => 'replay.victim']);
        $credId = 'test_cred_id_replay';
        WebauthnCredential::create([
            'user_id'       => $user->user_id,
            'credential_id' => $credId,
            'public_key'    => $publicKeyPem,
            'user_handle'   => (string) $user->user_id,
            'counter'       => 10, // Stored counter is already 10
            'device_name'   => 'Hardware Key',
            'created_by'    => $user->username,
            'updated_by'    => $user->username,
        ]);

        $encodedChallenge = WebauthnService::base64urlEncode(random_bytes(32));
        session(['webauthn.login.challenge' => $encodedChallenge]);

        $rawClientData = json_encode(['type' => 'webauthn.get', 'challenge' => $encodedChallenge]);
        // Incoming counter is 5 (less than 10) => Replay attack!
        $rawAuthData = hash('sha256', 'localhost', true) . chr(0x01) . pack('N', 5);

        $clientDataHash = hash('sha256', $rawClientData, true);
        openssl_sign($rawAuthData . $clientDataHash, $rawSignature, $privateKeyPem, OPENSSL_ALGO_SHA256);

        $response = $this->postJson(route('webauthn.login.verify'), [
            'id'       => $credId,
            'rawId'    => $credId,
            'type'     => 'public-key',
            'response' => [
                'clientDataJSON'    => WebauthnService::base64urlEncode($rawClientData),
                'authenticatorData' => WebauthnService::base64urlEncode($rawAuthData),
                'signature'         => WebauthnService::base64urlEncode($rawSignature),
            ],
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'error' => 'การยืนยันตัวตนด้วยลายนิ้วมือไม่ถูกต้องหรือไม่สำเร็จ',
            ]);

        $this->assertFalse(Auth::check());
    }
}
