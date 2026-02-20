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

        // Seed e-course, members, payments and donation demo data
        $this->call([
            CategorySeeder::class,
            ClassSeeder::class,
            ModuleSeeder::class,
            LessonSeeder::class,
            AdditionalLessonSeeder::class,
            MemberSeeder::class,
            PaymentGatewaySeeder::class,
            DonationDemoSeeder::class,
            ZakatSettingSeeder::class,
            CurrencySettingSeeder::class,
            CommunityPostSeeder::class,
            CommunityWhatsappGroupSeeder::class,
            VolunteerEventSeeder::class,
            MentorProfileSeeder::class,
        ]);
    }
}
