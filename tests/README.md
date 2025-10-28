# WonCare Testing Suite

This directory contains comprehensive tests for the WonCare application.

## Test Structure

### Feature Tests
Located in `tests/Feature/` - These test the application's features from a user's perspective.

- **`Auth/AuthAdminControllerTest.php`** - Tests for admin authentication
  - Login functionality
  - Logout functionality
  - Validation
  - Session management
  - Remember me functionality

- **`LanguageControllerTest.php`** - Tests for language switching
  - Language change functionality
  - Session persistence
  - User preference updates
  - Invalid locale handling

- **`BarberServicePricingTest.php`** - Tests for barber service pricing system
  - Custom pricing display
  - Service overview tables
  - Visual indicators
  - Access control

- **`ApplicationTest.php`** - End-to-end application tests
  - Overall application flow
  - Middleware integration
  - Configuration validation

### Unit Tests
Located in `tests/Unit/` - These test individual components in isolation.

- **`Middleware/SetLocaleTest.php`** - Tests for SetLocale middleware
  - Locale setting logic
  - Priority handling (Session > User > Default)
  - Invalid locale handling
  - Guest user support

- **`Models/UserTest.php`** - Tests for User model
  - Model attributes and relationships
  - Data validation
  - Fillable and hidden attributes
  - Type casting

## Running Tests

### Run All Tests
```bash
php artisan test
```

### Run Specific Test Categories
```bash
# Feature tests only
php artisan test --testsuite=Feature

# Unit tests only
php artisan test --testsuite=Unit
```

### Run Specific Test Files
```bash
# Authentication tests
php artisan test tests/Feature/Auth/AuthAdminControllerTest.php

# Language switching tests
php artisan test tests/Feature/LanguageControllerTest.php

# Middleware tests
php artisan test tests/Unit/Middleware/SetLocaleTest.php
```

### Run Tests with Coverage
```bash
php artisan test --coverage
```

## Test Database

Tests use a separate testing database configured in your `.env.testing` file. Make sure to set up your testing environment:

```env
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

Or use a separate testing database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=woncare_testing
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## Test Helper

The `TestHelper.php` class provides utility methods for creating test data and assertions:

```php
// Create test users
$user = TestHelper::createTestUser();
$admin = TestHelper::createAdminUser();

// Get test data
$languages = TestHelper::getValidLanguageCodes();
$authData = TestHelper::getAuthTestData();

// Custom assertions
TestHelper::assertUserHasLanguage($user, 'en');
```

## Test Coverage

The test suite covers:

- ✅ Authentication (login/logout)
- ✅ Language switching functionality
- ✅ Middleware behavior
- ✅ Model functionality
- ✅ Session management
- ✅ Input validation
- ✅ Error handling
- ✅ Access control
- ✅ Database operations

## Best Practices

1. **Use RefreshDatabase trait** for tests that modify the database
2. **Create test-specific data** in setUp() methods
3. **Use descriptive test names** that explain what is being tested
4. **Test both success and failure scenarios**
5. **Mock external dependencies** when appropriate
6. **Keep tests isolated** - each test should be independent

## Adding New Tests

When adding new features, make sure to:

1. Add feature tests for user-facing functionality
2. Add unit tests for individual components
3. Update this README if new test categories are added
4. Follow the existing naming conventions
5. Use the TestHelper class for common operations

## Continuous Integration

These tests are designed to run in CI/CD pipelines. Make sure your CI environment:

1. Has PHP and required extensions installed
2. Has access to a test database
3. Runs `composer install` before testing
4. Sets up the proper environment variables
5. Runs database migrations before tests
