<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $adminUser;
    protected User $testUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user for authentication
        $this->adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        
        // Create a test user for CRUD operations
        $this->testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'language' => 'en',
        ]);
    }

    /** @test */
    public function it_displays_users_index_page()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
    }

    /** @test */
    public function it_returns_datatables_data_for_ajax_requests()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.users.index'), [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'language',
                    'email_verified_at',
                    'created_at',
                    'email_verified',
                    'action'
                ]
            ]
        ]);
    }

    /** @test */
    public function it_displays_create_user_form()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.users.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.create');
    }

    /** @test */
    public function it_stores_a_new_user_with_valid_data()
    {
        $this->actingAs($this->adminUser);

        $userData = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'language' => 'en',
        ];

        $response = $this->post(route('admin.users.store'), $userData);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'User created successfully.');
        
        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'language' => 'en',
        ]);
        
        // Verify password is hashed
        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /** @test */
    public function it_validates_required_fields_when_storing_user()
    {
        $this->actingAs($this->adminUser);

        $response = $this->post(route('admin.users.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function it_validates_unique_email_when_storing_user()
    {
        $this->actingAs($this->adminUser);

        $userData = [
            'name' => 'Another User',
            'email' => $this->testUser->email, // Using existing email
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('admin.users.store'), $userData);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function it_validates_password_confirmation_when_storing_user()
    {
        $this->actingAs($this->adminUser);

        $userData = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ];

        $response = $this->post(route('admin.users.store'), $userData);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function it_displays_user_details()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.users.show', $this->testUser));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.show');
        $response->assertViewHas('user', $this->testUser);
    }

    /** @test */
    public function it_displays_edit_user_form()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.users.edit', $this->testUser));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.edit');
        $response->assertViewHas('user', $this->testUser);
    }

    /** @test */
    public function it_updates_user_with_valid_data()
    {
        $this->actingAs($this->adminUser);

        $updateData = [
            'name' => 'Updated User Name',
            'email' => 'updated@example.com',
            'language' => 'ko',
        ];

        $response = $this->put(route('admin.users.update', $this->testUser), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'User updated successfully.');
        
        $this->assertDatabaseHas('users', [
            'id' => $this->testUser->id,
            'name' => 'Updated User Name',
            'email' => 'updated@example.com',
            'language' => 'ko',
        ]);
    }

    /** @test */
    public function it_updates_user_password_when_provided()
    {
        $this->actingAs($this->adminUser);

        $updateData = [
            'name' => $this->testUser->name,
            'email' => $this->testUser->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->put(route('admin.users.update', $this->testUser), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        
        $updatedUser = $this->testUser->fresh();
        $this->assertTrue(Hash::check('newpassword123', $updatedUser->password));
    }

    /** @test */
    public function it_does_not_update_password_when_not_provided()
    {
        $this->actingAs($this->adminUser);
        $originalPassword = $this->testUser->password;

        $updateData = [
            'name' => 'Updated Name',
            'email' => $this->testUser->email,
        ];

        $response = $this->put(route('admin.users.update', $this->testUser), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        
        $updatedUser = $this->testUser->fresh();
        $this->assertEquals($originalPassword, $updatedUser->password);
    }

    /** @test */
    public function it_validates_unique_email_when_updating_user_except_current()
    {
        $this->actingAs($this->adminUser);
        $anotherUser = User::factory()->create(['email' => 'another@example.com']);

        $updateData = [
            'name' => $this->testUser->name,
            'email' => $anotherUser->email, // Using another user's email
        ];

        $response = $this->put(route('admin.users.update', $this->testUser), $updateData);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function it_allows_keeping_same_email_when_updating_user()
    {
        $this->actingAs($this->adminUser);

        $updateData = [
            'name' => 'Updated Name',
            'email' => $this->testUser->email, // Keeping same email
        ];

        $response = $this->put(route('admin.users.update', $this->testUser), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function it_deletes_user()
    {
        $this->actingAs($this->adminUser);

        $response = $this->delete(route('admin.users.destroy', $this->testUser));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'User deleted successfully.');
        
        $this->assertDatabaseMissing('users', [
            'id' => $this->testUser->id,
        ]);
    }

    /** @test */
    public function it_requires_authentication_for_all_user_routes()
    {
        // Test index
        $response = $this->get(route('admin.users.index'));
        $response->assertRedirect(route('auth.admin.login'));

        // Test create
        $response = $this->get(route('admin.users.create'));
        $response->assertRedirect(route('auth.admin.login'));

        // Test store
        $response = $this->post(route('admin.users.store'), []);
        $response->assertRedirect(route('auth.admin.login'));

        // Test show
        $response = $this->get(route('admin.users.show', $this->testUser));
        $response->assertRedirect(route('auth.admin.login'));

        // Test edit
        $response = $this->get(route('admin.users.edit', $this->testUser));
        $response->assertRedirect(route('auth.admin.login'));

        // Test update
        $response = $this->put(route('admin.users.update', $this->testUser), []);
        $response->assertRedirect(route('auth.admin.login'));

        // Test destroy
        $response = $this->delete(route('admin.users.destroy', $this->testUser));
        $response->assertRedirect(route('auth.admin.login'));
    }

    /** @test */
    public function it_searches_users_for_select2()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.users.search', ['q' => 'Test']));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'results' => [
                '*' => [
                    'id',
                    'text',
                    'name',
                    'email'
                ]
            ],
            'pagination' => [
                'more'
            ]
        ]);
    }

    /** @test */
    public function it_returns_paginated_search_results()
    {
        $this->actingAs($this->adminUser);

        // Create more users for pagination test
        User::factory()->count(15)->create();

        $response = $this->get(route('admin.users.search', ['page' => 1]));

        $response->assertStatus(200);
        $data = $response->json();
        
        $this->assertCount(10, $data['results']); // Should return 10 per page
        $this->assertTrue($data['pagination']['more']); // Should have more pages
    }

    /** @test */
    public function it_filters_search_results_by_query()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('admin.users.search', ['q' => $this->testUser->name]));

        $response->assertStatus(200);
        $data = $response->json();
        
        $this->assertGreaterThan(0, count($data['results']));
        $this->assertStringContainsString($this->testUser->name, $data['results'][0]['text']);
    }

    /** @test */
    public function it_requires_authentication_for_search_endpoint()
    {
        $response = $this->get(route('admin.users.search'));
        $response->assertRedirect(route('auth.admin.login'));
    }
}
