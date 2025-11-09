<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
        ]);

        // Seed e-course data
        $this->call([
            CategorySeeder::class,
            ClassSeeder::class,
            ModuleSeeder::class,
            LessonSeeder::class,
            AdditionalLessonSeeder::class,
            MemberSeeder::class,
            PaymentGatewaySeeder::class,
        ]);
    }
}
