<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'language' => 'en',
                'is_active' => true,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'language' => 'en',
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Rahman',
                'email' => 'ahmad@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'language' => 'id',
                'is_active' => true,
            ],
            [
                'name' => 'Kim Min-jun',
                'email' => 'kim@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'language' => 'ko',
                'is_active' => true,
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
