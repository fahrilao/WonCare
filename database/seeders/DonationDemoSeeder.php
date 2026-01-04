<?php

namespace Database\Seeders;

use App\Models\DonationCampaign;
use App\Models\DonationTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DonationDemoSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Create some demo tags if none exist
    if (DonationTag::count() === 0) {
      $tags = [
        ['name' => 'Education', 'color' => '#0d6efd'],
        ['name' => 'Health', 'color' => '#dc3545'],
        ['name' => 'Food', 'color' => '#198754'],
        ['name' => 'Emergency', 'color' => '#fd7e14'],
        ['name' => 'Orphanage', 'color' => '#6f42c1'],
      ];

      foreach ($tags as $index => $tag) {
        DonationTag::create([
          'name' => $tag['name'],
          'slug' => Str::slug($tag['name']),
          'description' => $tag['name'] . ' related donations',
          'color' => $tag['color'],
          'is_active' => true,
          'sort_order' => $index + 1,
          'created_by' => 1,
        ]);
      }
    }

    if (DonationCampaign::count() > 0) {
      return;
    }

    $now = now();

    $campaigns = [
      // Education campaigns
      [
        'title' => 'Support Children Education',
        'description' => 'Help provide school supplies, uniforms, and tuition support for underprivileged children.',
        'goal_amount' => 10000000,
        'collected_amount' => 3500000,
        'start_date' => $now->copy()->subDays(10),
        'end_date' => $now->copy()->addDays(5),
        'status' => 'active',
        'tag' => 'Education',
      ],
      [
        'title' => 'School Building Project',
        'description' => 'Construct new school facilities for remote areas.',
        'goal_amount' => 50000000,
        'collected_amount' => 15000000,
        'start_date' => $now->copy()->subDays(15),
        'end_date' => $now->copy()->addDays(21),
        'status' => 'active',
        'tag' => 'Education',
      ],
      [
        'title' => 'Digital Learning Initiative',
        'description' => 'Provide tablets and internet access for online learning in rural schools.',
        'goal_amount' => 30000000,
        'collected_amount' => 8000000,
        'start_date' => $now->copy()->subDays(7),
        'end_date' => $now->copy()->addDays(30),
        'status' => 'active',
        'tag' => 'Education',
      ],
      [
        'title' => 'Teacher Training Program',
        'description' => 'Fund professional development for teachers in underserved communities.',
        'goal_amount' => 15000000,
        'collected_amount' => 5000000,
        'start_date' => $now->copy()->subDays(12),
        'end_date' => $now->copy()->addDays(18),
        'status' => 'active',
        'tag' => 'Education',
      ],
      // Health campaigns
      [
        'title' => 'Emergency Medical Fund',
        'description' => 'Urgent medical support for families in critical condition.',
        'goal_amount' => 15000000,
        'collected_amount' => 9000000,
        'start_date' => $now->copy()->subDays(3),
        'end_date' => $now->copy()->addDays(2),
        'status' => 'active',
        'tag' => 'Health',
      ],
      [
        'title' => 'Clean Water Initiative',
        'description' => 'Build wells and provide clean water access to rural villages.',
        'goal_amount' => 12000000,
        'collected_amount' => 8500000,
        'start_date' => $now->copy()->subDays(20),
        'end_date' => $now->copy()->addDays(3),
        'status' => 'active',
        'tag' => 'Health',
      ],
      [
        'title' => 'Mobile Health Clinic',
        'description' => 'Fund mobile health clinics to reach remote communities.',
        'goal_amount' => 40000000,
        'collected_amount' => 12000000,
        'start_date' => $now->copy()->subDays(25),
        'end_date' => $now->copy()->addDays(35),
        'status' => 'active',
        'tag' => 'Health',
      ],
      [
        'title' => 'Vaccination Drive',
        'description' => 'Support vaccination programs for children in rural areas.',
        'goal_amount' => 20000000,
        'collected_amount' => 18000000,
        'start_date' => $now->copy()->subDays(8),
        'end_date' => $now->copy()->addDays(7),
        'status' => 'active',
        'tag' => 'Health',
      ],
      // Food campaigns
      [
        'title' => 'Food Package Ramadan',
        'description' => 'Distribute food packages during Ramadan for families in need.',
        'goal_amount' => 8000000,
        'collected_amount' => 7800000,
        'start_date' => $now->copy()->subDays(5),
        'end_date' => $now->copy()->addDays(1),
        'status' => 'active',
        'tag' => 'Food',
      ],
      [
        'title' => 'Ramadan Iftar Program',
        'description' => 'Provide iftar meals for those in need during Ramadan.',
        'goal_amount' => 10000000,
        'collected_amount' => 3000000,
        'start_date' => $now->copy()->subDays(2),
        'end_date' => $now->copy()->addDays(5),
        'status' => 'active',
        'tag' => 'Food',
      ],
      [
        'title' => 'School Lunch Program',
        'description' => 'Provide nutritious meals for students from low-income families.',
        'goal_amount' => 25000000,
        'collected_amount' => 10000000,
        'start_date' => $now->copy()->subDays(14),
        'end_date' => $now->copy()->addDays(45),
        'status' => 'active',
        'tag' => 'Food',
      ],
      [
        'title' => 'Community Kitchen Support',
        'description' => 'Help community kitchens serve meals to homeless and unemployed.',
        'goal_amount' => 15000000,
        'collected_amount' => 7500000,
        'start_date' => $now->copy()->subDays(10),
        'end_date' => $now->copy()->addDays(20),
        'status' => 'active',
        'tag' => 'Food',
      ],
      // Emergency campaigns
      [
        'title' => 'Disaster Relief Fund',
        'description' => 'Emergency response for natural disasters.',
        'goal_amount' => 25000000,
        'collected_amount' => 6000000,
        'start_date' => $now->copy()->subDays(2),
        'end_date' => $now->copy()->addDays(10),
        'status' => 'active',
        'tag' => 'Emergency',
      ],
      [
        'title' => 'Flood Victims Support',
        'description' => 'Immediate relief for families affected by recent flooding.',
        'goal_amount' => 30000000,
        'collected_amount' => 22000000,
        'start_date' => $now->copy()->subDays(5),
        'end_date' => $now->copy()->addDays(7),
        'status' => 'active',
        'tag' => 'Emergency',
      ],
      [
        'title' => 'Earthquake Recovery Fund',
        'description' => 'Help rebuild homes destroyed by the recent earthquake.',
        'goal_amount' => 100000000,
        'collected_amount' => 35000000,
        'start_date' => $now->copy()->subDays(30),
        'end_date' => $now->copy()->addDays(60),
        'status' => 'active',
        'tag' => 'Emergency',
      ],
      [
        'title' => 'Fire Victims Assistance',
        'description' => 'Support families who lost their homes to fire.',
        'goal_amount' => 20000000,
        'collected_amount' => 8000000,
        'start_date' => $now->copy()->subDays(4),
        'end_date' => $now->copy()->addDays(14),
        'status' => 'active',
        'tag' => 'Emergency',
      ],
      // Orphanage campaigns
      [
        'title' => 'Orphanage Support',
        'description' => 'Provide care and education for orphans in our community.',
        'goal_amount' => 20000000,
        'collected_amount' => 5000000,
        'start_date' => $now->copy()->subDays(6),
        'end_date' => $now->copy()->addDays(14),
        'status' => 'active',
        'tag' => 'Orphanage',
      ],
      [
        'title' => 'Orphanage Building Renovation',
        'description' => 'Renovate aging orphanage facilities to provide better living conditions.',
        'goal_amount' => 45000000,
        'collected_amount' => 15000000,
        'start_date' => $now->copy()->subDays(20),
        'end_date' => $now->copy()->addDays(40),
        'status' => 'active',
        'tag' => 'Orphanage',
      ],
      [
        'title' => 'Orphan Scholarship Fund',
        'description' => 'Provide scholarships for orphans to continue higher education.',
        'goal_amount' => 35000000,
        'collected_amount' => 20000000,
        'start_date' => $now->copy()->subDays(15),
        'end_date' => $now->copy()->addDays(25),
        'status' => 'active',
        'tag' => 'Orphanage',
      ],
      [
        'title' => 'Orphanage Monthly Needs',
        'description' => 'Cover monthly operational costs including food, utilities, and supplies.',
        'goal_amount' => 12000000,
        'collected_amount' => 4000000,
        'start_date' => $now->copy()->subDays(1),
        'end_date' => $now->copy()->addDays(30),
        'status' => 'active',
        'tag' => 'Orphanage',
      ],
    ];

    // Get tags by name for proper assignment
    $tagsByName = DonationTag::pluck('id', 'name')->all();

    foreach ($campaigns as $data) {
      $tagName = $data['tag'] ?? null;
      unset($data['tag']); // Remove tag from data before creating campaign

      $campaign = DonationCampaign::create(array_merge($data, [
        'image_url' => null,
        'created_by' => 1,
      ]));

      // Assign specific tag based on campaign data
      if ($tagName && isset($tagsByName[$tagName])) {
        $campaign->tags()->sync([$tagsByName[$tagName]]);
      }
    }
  }
}
