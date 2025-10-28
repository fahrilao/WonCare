<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LanguageControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'language' => 'en'
        ]);
    }

    /** @test */
    public function it_changes_language_to_valid_locale()
    {
        $response = $this->get(route('language.change', 'id'));

        $response->assertRedirect();
        $this->assertEquals('id', Session::get('locale'));
        $this->assertEquals('id', App::getLocale());
    }

    /** @test */
    public function it_updates_authenticated_user_language_preference()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('language.change', 'ko'));

        $response->assertRedirect();
        $this->assertEquals('ko', Session::get('locale'));
        $this->assertEquals('ko', $this->user->fresh()->language);
    }

    /** @test */
    public function it_works_for_guest_users()
    {
        $response = $this->get(route('language.change', 'ko'));

        $response->assertRedirect();
        $this->assertEquals('ko', Session::get('locale'));
        $this->assertGuest();
    }

    /** @test */
    public function it_rejects_invalid_locale()
    {
        $response = $this->get(route('language.change', 'invalid'));

        $response->assertStatus(400);
        $this->assertNull(Session::get('locale'));
    }

    /** @test */
    public function it_accepts_english_locale()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('language.change', 'en'));

        $response->assertRedirect();
        $this->assertEquals('en', Session::get('locale'));
        $this->assertEquals('en', $this->user->fresh()->language);
    }

    /** @test */
    public function it_accepts_indonesian_locale()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('language.change', 'id'));

        $response->assertRedirect();
        $this->assertEquals('id', Session::get('locale'));
        $this->assertEquals('id', $this->user->fresh()->language);
    }

    /** @test */
    public function it_accepts_korean_locale()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('language.change', 'ko'));

        $response->assertRedirect();
        $this->assertEquals('ko', Session::get('locale'));
        $this->assertEquals('ko', $this->user->fresh()->language);
    }

    /** @test */
    public function it_redirects_back_to_previous_page()
    {
        $previousUrl = route('admin.home');
        
        $response = $this->from($previousUrl)
                         ->get(route('language.change', 'id'));

        $response->assertRedirect($previousUrl);
    }

    /** @test */
    public function it_maintains_session_across_language_changes()
    {
        Session::put('test_data', 'test_value');
        
        $response = $this->get(route('language.change', 'ko'));

        $response->assertRedirect();
        $this->assertEquals('test_value', Session::get('test_data'));
        $this->assertEquals('ko', Session::get('locale'));
    }

    /** @test */
    public function it_overwrites_previous_language_preference()
    {
        $this->actingAs($this->user);
        
        // First change
        $this->get(route('language.change', 'id'));
        $this->assertEquals('id', $this->user->fresh()->language);
        
        // Second change
        $this->get(route('language.change', 'ko'));
        $this->assertEquals('ko', $this->user->fresh()->language);
    }

    /** @test */
    public function it_handles_case_sensitive_locales()
    {
        $response = $this->get(route('language.change', 'EN'));

        $response->assertStatus(400);
        $this->assertNull(Session::get('locale'));
    }
}
