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
      [
        'title' => 'Support Children Education',
        'description' => 'Help provide school supplies, uniforms, and tuition support for underprivileged children.',
        'goal_amount' => 10000000,
        'collected_amount' => 3500000,
        'start_date' => $now->copy()->subDays(10),
        'end_date' => $now->copy()->addDays(5),
        'status' => 'active',
      ],
      [
        'title' => 'Emergency Medical Fund',
        'description' => 'Urgent medical support for families in critical condition.',
        'goal_amount' => 15000000,
        'collected_amount' => 9000000,
        'start_date' => $now->copy()->subDays(3),
        'end_date' => $now->copy()->addDays(2),
        'status' => 'active',
      ],
      [
        'title' => 'Clean Water for Villages',
        'description' => 'Build clean water facilities for remote villages.',
        'goal_amount' => 20000000,
        'collected_amount' => 4500000,
        'start_date' => $now->copy()->subDays(20),
        'end_date' => $now->copy()->addDays(15),
        'status' => 'active',
      ],
      [
        'title' => 'Food Package Ramadan',
        'description' => 'Distribute food packages during Ramadan for families in need.',
        'goal_amount' => 8000000,
        'collected_amount' => 7800000,
        'start_date' => $now->copy()->subDays(5),
        'end_date' => $now->copy()->addDays(1),
        'status' => 'active',
      ],
      [
        'title' => 'Orphanage Monthly Support',
        'description' => 'Monthly operational support for local orphanages.',
        'goal_amount' => 12000000,
        'collected_amount' => 12000000,
        'start_date' => $now->copy()->subDays(30),
        'end_date' => $now->copy()->subDays(1),
        'status' => 'completed',
      ],
      [
        'title' => 'Disaster Relief Fund',
        'description' => 'Emergency response for natural disasters.',
        'goal_amount' => 25000000,
        'collected_amount' => 6000000,
        'start_date' => $now->copy()->subDays(2),
        'end_date' => $now->copy()->addDays(10),
        'status' => 'active',
      ],
    ];

    $tagIds = DonationTag::pluck('id')->all();

    foreach ($campaigns as $data) {
      $campaign = DonationCampaign::create(array_merge($data, [
        'image_url' => null,
        'created_by' => 1,
      ]));

      if (!empty($tagIds)) {
        shuffle($tagIds);
        $campaign->tags()->sync(array_slice($tagIds, 0, rand(1, min(3, count($tagIds)))));
      }
    }
  }
}
