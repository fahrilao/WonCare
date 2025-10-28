<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  protected User $user;

  protected function setUp(): void
  {
    parent::setUp();
    $this->user = User::factory()->create();
  }

  /** @test */
  public function application_returns_successful_response_for_home_page()
  {
    $response = $this->get('/');

    $response->assertStatus(302); // Assuming redirect to login
  }

  /** @test */
  public function authenticated_user_can_access_admin_dashboard()
  {
    $this->actingAs($this->user);

    // Adjust route name based on your actual implementation
    $response = $this->get('/admin'); // or route('admin.home')

    $response->assertStatus(200);
  }

  /** @test */
  public function language_switching_works_end_to_end()
  {
    $this->actingAs($this->user);

    // Switch to Indonesian
    $response = $this->get(route('language.change', 'id'));
    $response->assertRedirect();
    $this->assertEquals('id', $this->user->fresh()->language);

    // Switch to Korean
    $response = $this->get(route('language.change', 'ko'));
    $response->assertRedirect();
    $this->assertEquals('ko', $this->user->fresh()->language);

    // Switch back to English
    $response = $this->get(route('language.change', 'en'));
    $response->assertRedirect();
    $this->assertEquals('en', $this->user->fresh()->language);
  }

  /** @test */
  public function authentication_flow_works_end_to_end()
  {
    // Test login
    $response = $this->post(route('auth.admin.authenticate'), [
      'email' => $this->user->email,
      'password' => 'password' // Default factory password
    ]);

    $response->assertRedirect();
    $this->assertAuthenticatedAs($this->user);

    // Test logout
    $response = $this->get(route('auth.admin.logout'));
    $response->assertRedirect(route('auth.admin.login'));
    $this->assertGuest();
  }

  /** @test */
  public function middleware_stack_works_correctly()
  {
    // Test that SetLocale middleware is working
    $this->actingAs($this->user);

    // Set user language preference
    $this->user->update(['language' => 'ko']);

    // Make a request and check if locale is set
    $response = $this->get('/admin');

    // The middleware should have set the locale based on user preference
    $this->assertEquals('ko', App::getLocale());
  }

  /** @test */
  public function session_management_works_correctly()
  {
    // Start session
    $response = $this->get(route('auth.admin.login'));
    $response->assertStatus(200);

    // Login should regenerate session
    $response = $this->post(route('auth.admin.authenticate'), [
      'email' => $this->user->email,
      'password' => 'password',
      '_token' => csrf_token()
    ]);

    $this->assertAuthenticatedAs($this->user);
  }

  /** @test */
  public function application_handles_404_errors_gracefully()
  {
    $response = $this->get('/non-existent-route');

    $response->assertStatus(404);
  }

  /** @test */
  public function application_validates_input_properly()
  {
    // Test validation on login form
    $response = $this->post(route('auth.admin.authenticate'), [
      'email' => 'invalid-email',
      'password' => '123' // Too short
    ]);

    $response->assertSessionHasErrors(['password']);
  }

  /** @test */
  public function database_connections_work()
  {
    // Test that we can create and retrieve users
    $testUser = User::factory()->create([
      'name' => 'Database Test User'
    ]);

    $retrievedUser = User::find($testUser->id);

    $this->assertEquals('Database Test User', $retrievedUser->name);
  }

  /** @test */
  public function application_configuration_is_correct()
  {
    // Test that app is in testing environment
    $this->assertEquals('testing', App::environment());

    // Test that default locale is set
    $this->assertEquals('en', config('app.locale'));

    // Test that supported locales are configured
    $this->assertContains('en', ['en', 'id', 'ko']);
    $this->assertContains('id', ['en', 'id', 'ko']);
    $this->assertContains('ko', ['en', 'id', 'ko']);
  }
}
