<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthAdminControllerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  protected User $user;

  protected function setUp(): void
  {
    parent::setUp();
    // Create a test user
    $this->user = User::factory()->create([
      'email' => 'admin@test.com',
      'password' => Hash::make('password123'),
      'name' => 'Test Admin'
    ]);
  }

  /** @test */
  public function it_displays_login_page()
  {
    $response = $this->get(route('auth.admin.login'));

    $response->assertStatus(200);
    $response->assertViewIs('auth.login');
  }

  /** @test */
  public function it_authenticates_user_with_valid_credentials()
  {
    $response = $this->post(route('auth.admin.authenticate'), [
      'email' => 'admin@test.com',
      'password' => 'password123',
      'remember' => false
    ]);

    $response->assertRedirect(route('admin.home'));
    $response->assertSessionHas('success');
    $this->assertAuthenticatedAs($this->user);
  }

  /** @test */
  public function it_fails_authentication_with_invalid_credentials()
  {
    $response = $this->post(route('auth.admin.authenticate'), [
      'email' => 'admin@test.com',
      'password' => 'wrongpassword',
      'remember' => false
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors();
    $this->assertGuest();
  }

  /** @test */
  public function it_validates_required_fields()
  {
    $response = $this->post(route('auth.admin.authenticate'), []);

    $response->assertSessionHasErrors(['email', 'password']);
  }

  /** @test */
  public function it_validates_password_minimum_length()
  {
    $response = $this->post(route('auth.admin.authenticate'), [
      'email' => 'admin@test.com',
      'password' => '123'
    ]);

    $response->assertSessionHasErrors(['password']);
  }

  /** @test */
  public function it_remembers_user_when_remember_is_checked()
  {
    $response = $this->post(route('auth.admin.authenticate'), [
      'email' => 'admin@test.com',
      'password' => 'password123',
      'remember' => true
    ]);

    $response->assertRedirect(route('admin.home'));
    $this->assertAuthenticatedAs($this->user);
    // Check if remember token is set
    $this->assertNotNull($this->user->fresh()->remember_token);
  }

  /** @test */
  public function it_logs_out_authenticated_user()
  {
    $this->actingAs($this->user);

    $response = $this->get(route('auth.admin.logout'));

    $response->assertRedirect(route('auth.admin.login'));
    $response->assertSessionHas('success');
    $this->assertGuest();
  }

  /** @test */
  public function it_redirects_authenticated_user_from_login_page()
  {
    $this->actingAs($this->user);

    $response = $this->get(route('auth.admin.login'));

    // This test assumes you have middleware to redirect authenticated users
    // Adjust based on your actual implementation
    $response->assertStatus(302); // or assertRedirect if you have redirect middleware
  }

  /** @test */
  public function it_regenerates_session_on_successful_login()
  {
    $oldSessionId = session()->getId();

    $response = $this->post(route('auth.admin.authenticate'), [
      'email' => 'admin@test.com',
      'password' => 'password123'
    ]);

    $newSessionId = session()->getId();
    $this->assertNotEquals($oldSessionId, $newSessionId);
  }

  /** @test */
  public function it_invalidates_session_on_logout()
  {
    $this->actingAs($this->user);
    $oldSessionId = session()->getId();

    $response = $this->get(route('auth.admin.logout'));

    // Session should be invalidated
    $this->assertGuest();
  }
}
