<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post('/register', [
            'name' => 'Test',
            'lastName' => 'User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'name' => 'Test',
            'lastName' => 'User',
            'email' => 'test@example.com',
        ]);
        $response->assertRedirect(route('dashboard'));
    }
}
