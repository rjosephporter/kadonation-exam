<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthResourcesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function canRegister()
    {
        $data = [
            'name' => 'Richard Joseph Porter',
            'email' => 'richard@testing.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->postJson(route('api.register'), $data);

        $response->assertCreated();
        $response->assertJsonFragment([
            'name' => 'Richard Joseph Porter',
            'email' => 'richard@testing.com',
        ]);
    }

    /** @test */
    public function cannotRegisterWithExistingEmail()
    {
        User::factory()->create(['email' => 'richard@testing.com']);

        $data = [
            'name' => 'Richard Joseph Porter',
            'email' => 'richard@testing.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson(route('api.register'), $data);

        $response->assertStatus(422);
        $response->assertSeeText('The email has already been taken.');
    }

    /** @test */
    public function canLogin()
    {
        $data = [
            'email' => 'richard@testing.com',
            'password' => 'password',
        ];
        User::factory()->create($data);

        $response = $this->postJson(route('api.login'), $data);

        $response->assertOk();
        $response->assertSeeText('token');
    }

    /** @test */
    public function cannotLoginWithInvalidCredentials()
    {
        $data = [
            'email' => 'richard@testing.com',
            'password' => 'password',
        ];
        User::factory()->create($data);

        $data['password'] = 'wrongpassword';

        $response = $this->postJson(route('api.login'), $data);

        $response->assertStatus(422);
        $response->assertSeeText('The provided credentials are incorrect.');
    }
}
