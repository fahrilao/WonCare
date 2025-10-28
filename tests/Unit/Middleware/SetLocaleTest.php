<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\SetLocale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class SetLocaleTest extends TestCase
{
    use RefreshDatabase;

    protected SetLocale $middleware;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new SetLocale();
        $this->user = User::factory()->create([
            'language' => 'id'
        ]);
    }

    /** @test */
    public function it_sets_default_locale_when_no_preference_exists()
    {
        $request = Request::create('/test');

        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals('en', App::getLocale());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function it_sets_locale_from_authenticated_user_preference()
    {
        Auth::login($this->user);
        $request = Request::create('/test');

        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals('id', App::getLocale());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function it_prioritizes_session_locale_over_user_preference()
    {
        Auth::login($this->user);
        Session::put('locale', 'ko');
        $request = Request::create('/test');

        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals('ko', App::getLocale());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function it_ignores_invalid_session_locale()
    {
        Session::put('locale', 'invalid');
        $request = Request::create('/test');

        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals('en', App::getLocale());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function it_ignores_invalid_user_language_preference()
    {
        $userWithInvalidLang = User::factory()->create([
            'language' => 'invalid'
        ]);
        Auth::login($userWithInvalidLang);
        $request = Request::create('/test');

        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals('en', App::getLocale());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function it_accepts_all_valid_locales()
    {
        $validLocales = ['en', 'id', 'ko'];

        foreach ($validLocales as $locale) {
            Session::put('locale', $locale);
            $request = Request::create('/test');

            $response = $this->middleware->handle($request, function ($req) {
                return response('OK');
            });

            $this->assertEquals($locale, App::getLocale());
            $this->assertEquals(200, $response->getStatusCode());
        }
    }

    /** @test */
    public function it_works_with_guest_users()
    {
        Auth::logout();
        Session::put('locale', 'ko');
        $request = Request::create('/test');

        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals('ko', App::getLocale());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGuest();
    }

    /** @test */
    public function it_passes_request_to_next_middleware()
    {
        $request = Request::create('/test');
        $nextCalled = false;

        $response = $this->middleware->handle($request, function ($req) use (&$nextCalled) {
            $nextCalled = true;
            return response('Next middleware called');
        });

        $this->assertTrue($nextCalled);
        $this->assertEquals('Next middleware called', $response->getContent());
    }

    /** @test */
    public function it_maintains_request_integrity()
    {
        $request = Request::create('/test', 'POST', ['data' => 'test']);
        $request->headers->set('X-Test-Header', 'test-value');

        $response = $this->middleware->handle($request, function ($req) {
            return response()->json([
                'method' => $req->method(),
                'data' => $req->input('data'),
                'header' => $req->header('X-Test-Header')
            ]);
        });

        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('POST', $responseData['method']);
        $this->assertEquals('test', $responseData['data']);
        $this->assertEquals('test-value', $responseData['header']);
    }
}
