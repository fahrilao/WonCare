<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'language' => 'en'
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('en', $user->language);
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $fillable = ['name', 'email', 'password', 'language'];
        $user = new User();

        $this->assertEquals($fillable, $user->getFillable());
    }

    /** @test */
    public function it_hides_sensitive_attributes()
    {
        $hidden = ['password', 'remember_token'];
        $user = new User();

        $this->assertEquals($hidden, $user->getHidden());
    }

    /** @test */
    public function it_casts_email_verified_at_to_datetime()
    {
        $user = new User();
        $casts = $user->getCasts();

        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
    }

    /** @test */
    public function it_can_update_language_preference()
    {
        $user = User::factory()->create(['language' => 'en']);

        $user->update(['language' => 'id']);

        $this->assertEquals('id', $user->fresh()->language);
    }

    /** @test */
    public function it_stores_valid_language_codes()
    {
        $validLanguages = ['en', 'id', 'ko'];

        foreach ($validLanguages as $language) {
            $user = User::factory()->create(['language' => $language]);
            $this->assertEquals($language, $user->language);
        }
    }

    /** @test */
    public function it_hashes_password_when_creating_user()
    {
        $plainPassword = 'password123';
        $user = User::factory()->create([
            'password' => Hash::make($plainPassword)
        ]);

        $this->assertTrue(Hash::check($plainPassword, $user->password));
        $this->assertNotEquals($plainPassword, $user->password);
    }

    /** @test */
    public function it_has_unique_email()
    {
        User::factory()->create(['email' => 'test@example.com']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        User::factory()->create(['email' => 'test@example.com']);
    }

    /** @test */
    public function it_can_be_converted_to_array()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'language' => 'en'
        ]);

        $userArray = $user->toArray();

        $this->assertIsArray($userArray);
        $this->assertArrayHasKey('name', $userArray);
        $this->assertArrayHasKey('email', $userArray);
        $this->assertArrayHasKey('language', $userArray);
        $this->assertArrayNotHasKey('password', $userArray); // Should be hidden
    }

    /** @test */
    public function it_can_be_converted_to_json()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'language' => 'en'
        ]);

        $userJson = $user->toJson();
        $decodedJson = json_decode($userJson, true);

        $this->assertIsString($userJson);
        $this->assertIsArray($decodedJson);
        $this->assertEquals('Test User', $decodedJson['name']);
        $this->assertEquals('test@example.com', $decodedJson['email']);
        $this->assertEquals('en', $decodedJson['language']);
    }

    /** @test */
    public function it_uses_correct_table_name()
    {
        $user = new User();
        $this->assertEquals('users', $user->getTable());
    }

    /** @test */
    public function it_has_correct_primary_key()
    {
        $user = new User();
        $this->assertEquals('id', $user->getKeyName());
    }

    /** @test */
    public function it_uses_timestamps()
    {
        $user = new User();
        $this->assertTrue($user->usesTimestamps());
    }
}
