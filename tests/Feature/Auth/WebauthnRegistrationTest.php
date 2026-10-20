<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\WebauthnCredential;
use App\Services\WebauthnService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebauthnRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_unauthenticated_users_cannot_access_register_options(): void
    {
        $response = $this->postJson(route('webauthn.register.options'));
        $response->assertStatus(401);
    }

    public function test_authenticated_users_can_request_registration_options(): void
    {
        $user = User::factory()->create([
            'username' => 'krisada.dev',
            'name'     => 'Krisada Dev',
            'email'    => 'krisada@buu.ac.th',
        ]);

        $response = $this->actingAs($user)
            ->postJson(route('webauthn.register.options'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'challenge',
                'rp' => ['name', 'id'],
                'user' => ['id', 'name', 'displayName'],
                'pubKeyCredParams',
                'authenticatorSelection',
                'timeout',
                'attestation',
                'excludeCredentials',
            ]);

        $this->assertEquals($user->username, $response->json('user.name'));
        $this->assertTrue(session()->has('webauthn.register.challenge'));
        $this->assertEquals($user->user_id, session('webauthn.register.user_id'));
    }

    public function test_authenticated_user_can_list_registered_credentials(): void
    {
        $user = User::factory()->create([
            'username' => 'somchai.sec',
            'name'     => 'Somchai Security',
            'email'    => 'somchai@buu.ac.th',
        ]);

        $cred = WebauthnCredential::create([
            'user_id'       => $user->user_id,
            'credential_id' => 'mock_cred_base64_id_123',
            'public_key'    => '-----BEGIN PUBLIC KEY-----MOCK-----END PUBLIC KEY-----',
            'user_handle'   => (string) $user->user_id,
            'counter'       => 0,
            'device_name'   => 'MacBook Pro Touch ID',
            'created_by'    => $user->username,
            'updated_by'    => $user->username,
        ]);

        $response = $this->actingAs($user)
            ->getJson(route('webauthn.credentials.list'));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'cred_id'     => $cred->cred_id,
                'device_name' => 'MacBook Pro Touch ID',
            ]);
    }

    public function test_authenticated_user_can_delete_own_credential(): void
    {
        $user = User::factory()->create([
            'username' => 'somchai.sec',
            'name'     => 'Somchai Security',
            'email'    => 'somchai@buu.ac.th',
        ]);

        $cred = WebauthnCredential::create([
            'user_id'       => $user->user_id,
            'credential_id' => 'mock_cred_to_delete',
            'public_key'    => '-----BEGIN PUBLIC KEY-----MOCK-----END PUBLIC KEY-----',
            'user_handle'   => (string) $user->user_id,
            'counter'       => 0,
            'device_name'   => 'Old YubiKey 5',
            'created_by'    => $user->username,
            'updated_by'    => $user->username,
        ]);

        $response = $this->actingAs($user)
            ->deleteJson(route('webauthn.credentials.delete', ['id' => $cred->cred_id]));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseMissing('webauthn_credentials', [
            'cred_id' => $cred->cred_id,
        ]);
    }

    public function test_user_cannot_delete_another_users_credential(): void
    {
        $user1 = User::factory()->create(['username' => 'user1', 'email' => 'u1@buu.ac.th']);
        $user2 = User::factory()->create(['username' => 'user2', 'email' => 'u2@buu.ac.th']);

        $cred2 = WebauthnCredential::create([
            'user_id'       => $user2->user_id,
            'credential_id' => 'mock_user2_cred',
            'public_key'    => '-----BEGIN PUBLIC KEY-----MOCK-----END PUBLIC KEY-----',
            'user_handle'   => (string) $user2->user_id,
            'counter'       => 0,
            'device_name'   => 'User2 Windows Hello',
            'created_by'    => $user2->username,
            'updated_by'    => $user2->username,
        ]);

        $response = $this->actingAs($user1)
            ->deleteJson(route('webauthn.credentials.delete', ['id' => $cred2->cred_id]));

        $response->assertStatus(404);

        $this->assertDatabaseHas('webauthn_credentials', [
            'cred_id' => $cred2->cred_id,
        ]);
    }

    public function test_profile_page_renders_webauthn_biometric_section(): void
    {
        $user = User::factory()->create([
            'username' => 'somchai.sec',
            'name'     => 'Somchai Security',
            'email'    => 'somchai@buu.ac.th',
        ]);

        WebauthnCredential::create([
            'user_id'       => $user->user_id,
            'credential_id' => 'mock_cred_somchai',
            'public_key'    => '-----BEGIN PUBLIC KEY-----MOCK-----END PUBLIC KEY-----',
            'user_handle'   => (string) $user->user_id,
            'counter'       => 1,
            'device_name'   => 'ThinkPad Windows Hello',
            'created_by'    => $user->username,
            'updated_by'    => $user->username,
        ]);

        $response = $this->actingAs($user)
            ->get(route('profile'));

        $response->assertStatus(200);
        $response->assertSee('สแกนลายนิ้วมือ &amp; Passkey', false);
        $response->assertSee('ThinkPad Windows Hello');
        $response->assertSee('1 อุปกรณ์พร้อมใช้');
    }

    public function test_registration_verify_with_invalid_challenge_fails(): void
    {
        $user = User::factory()->create(['username' => 'test.user']);
        session([
            'webauthn.register.challenge' => 'correct_challenge',
            'webauthn.register.user_id'   => $user->user_id,
        ]);

        $response = $this->actingAs($user)
            ->postJson(route('webauthn.register.verify'), [
                'id' => 'abc',
                'response' => [
                    'clientDataJSON'    => WebauthnService::base64urlEncode(json_encode(['type' => 'webauthn.create', 'challenge' => 'wrong_challenge'])),
                    'attestationObject' => WebauthnService::base64urlEncode('dummy'),
                ],
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'error' => 'Challenge ไม่ถูกต้องหรือไม่ตรงกับเซสชัน',
            ]);
    }

    public function test_authenticated_user_can_verify_registration_and_save_credential(): void
    {
        $user = User::factory()->create([
            'username' => 'krisada.dev',
            'name'     => 'Krisada Dev',
            'email'    => 'krisada@buu.ac.th',
        ]);

        $rawChallenge = random_bytes(32);
        $encodedChallenge = WebauthnService::base64urlEncode($rawChallenge);
        session([
            'webauthn.register.challenge' => $encodedChallenge,
            'webauthn.register.user_id'   => $user->user_id,
        ]);

        // 1. Generate EC Key for COSE public key
        $ecKey = openssl_pkey_new([
            'curve_name' => 'prime256v1',
            'private_key_type' => OPENSSL_KEYTYPE_EC,
        ]);
        $details = openssl_pkey_get_details($ecKey);
        $x = $details['ec']['x'];
        $y = $details['ec']['y'];

        // 2. Build COSE key CBOR Map
        $cborCose = \CBOR\MapObject::create();
        $cborCose->add(\CBOR\UnsignedIntegerObject::create(1), \CBOR\UnsignedIntegerObject::create(2));
        $cborCose->add(\CBOR\UnsignedIntegerObject::create(3), \CBOR\NegativeIntegerObject::create(-7));
        $cborCose->add(\CBOR\NegativeIntegerObject::create(-1), \CBOR\UnsignedIntegerObject::create(1));
        $cborCose->add(\CBOR\NegativeIntegerObject::create(-2), \CBOR\ByteStringObject::create($x));
        $cborCose->add(\CBOR\NegativeIntegerObject::create(-3), \CBOR\ByteStringObject::create($y));
        $cborCoseBytes = (string) $cborCose;

        $credIdRaw = random_bytes(16);
        $encodedCredId = WebauthnService::base64urlEncode($credIdRaw);

        // 3. authData with AT flag (0x45)
        $rpIdHash = hash('sha256', 'localhost', true);
        $flags = chr(0x45); // UP (0x01) | UV (0x04) | AT (0x40)
        $signCount = pack('N', 0);
        $aaguid = str_repeat("\x00", 16);
        $credIdLen = pack('n', strlen($credIdRaw));

        $authData = $rpIdHash . $flags . $signCount . $aaguid . $credIdLen . $credIdRaw . $cborCoseBytes;

        // 4. Attestation Object CBOR Map
        $attMap = \CBOR\MapObject::create();
        $attMap->add(\CBOR\TextStringObject::create('fmt'), \CBOR\TextStringObject::create('none'));
        $attMap->add(\CBOR\TextStringObject::create('attStmt'), \CBOR\MapObject::create());
        $attMap->add(\CBOR\TextStringObject::create('authData'), \CBOR\ByteStringObject::create($authData));
        $rawAttestation = (string) $attMap;

        $rawClientData = json_encode([
            'type'      => 'webauthn.create',
            'challenge' => $encodedChallenge,
            'origin'    => 'https://localhost',
        ]);

        $response = $this->actingAs($user)
            ->postJson(route('webauthn.register.verify'), [
                'id'         => $encodedCredId,
                'rawId'      => $encodedCredId,
                'type'       => 'public-key',
                'deviceName' => 'My MacBook Touch ID',
                'response'   => [
                    'clientDataJSON'    => WebauthnService::base64urlEncode($rawClientData),
                    'attestationObject' => WebauthnService::base64urlEncode($rawAttestation),
                    'transports'        => ['internal'],
                ],
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'ลงทะเบียนลายนิ้วมือสำเร็จเรียบร้อยแล้ว',
            ]);

        $this->assertDatabaseHas('webauthn_credentials', [
            'user_id'       => $user->user_id,
            'credential_id' => $encodedCredId,
            'device_name'   => 'My MacBook Touch ID',
        ]);
    }
}
