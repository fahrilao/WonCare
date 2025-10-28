<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestHelper
{
    /**
     * Create a test user with specific attributes
     */
    public static function createTestUser(array $attributes = []): User
    {
        $defaultAttributes = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'language' => 'en'
        ];

        return User::factory()->create(array_merge($defaultAttributes, $attributes));
    }

    /**
     * Create an admin user for testing
     */
    public static function createAdminUser(array $attributes = []): User
    {
        $defaultAttributes = [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'language' => 'en'
        ];

        return User::factory()->create(array_merge($defaultAttributes, $attributes));
    }

    /**
     * Get valid language codes for testing
     */
    public static function getValidLanguageCodes(): array
    {
        return ['en', 'id', 'ko'];
    }

    /**
     * Get invalid language codes for testing
     */
    public static function getInvalidLanguageCodes(): array
    {
        return ['fr', 'de', 'es', 'invalid', 'test'];
    }

    /**
     * Create test data for language switching tests
     */
    public static function getLanguageTestData(): array
    {
        return [
            'en' => [
                'code' => 'en',
                'name' => 'English',
                'direction' => 'ltr'
            ],
            'id' => [
                'code' => 'id',
                'name' => 'Bahasa Indonesia',
                'direction' => 'ltr'
            ],
            'ko' => [
                'code' => 'ko',
                'name' => '한국어',
                'direction' => 'ltr'
            ]
        ];
    }

    /**
     * Assert that a user has the correct language preference
     */
    public static function assertUserHasLanguage(User $user, string $expectedLanguage): void
    {
        $freshUser = $user->fresh();
        if ($freshUser->language !== $expectedLanguage) {
            throw new \PHPUnit\Framework\AssertionFailedError(
                "Expected user language to be '{$expectedLanguage}', but got '{$freshUser->language}'"
            );
        }
    }

    /**
     * Create test authentication data
     */
    public static function getAuthTestData(): array
    {
        return [
            'valid_credentials' => [
                'email' => 'test@example.com',
                'password' => 'password123'
            ],
            'invalid_credentials' => [
                'email' => 'test@example.com',
                'password' => 'wrongpassword'
            ],
            'missing_email' => [
                'password' => 'password123'
            ],
            'missing_password' => [
                'email' => 'test@example.com'
            ],
            'short_password' => [
                'email' => 'test@example.com',
                'password' => '123'
            ]
        ];
    }

    /**
     * Get common test routes
     */
    public static function getTestRoutes(): array
    {
        return [
            'login' => 'auth.admin.login',
            'authenticate' => 'auth.admin.authenticate',
            'logout' => 'auth.admin.logout',
            'language_change' => 'language.change',
            'admin_home' => 'admin.home'
        ];
    }

    /**
     * Clean up test data
     */
    public static function cleanupTestData(): void
    {
        // Clear any test-specific data
        User::where('email', 'like', '%@example.com')->delete();
        User::where('email', 'like', '%test.com')->delete();
    }
}
