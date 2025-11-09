<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Programming',
                'slug' => 'programming',
            ],
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
            ],
            [
                'name' => 'Machine Learning',
                'slug' => 'machine-learning',
            ],
            [
                'name' => 'DevOps',
                'slug' => 'devops',
            ],
            [
                'name' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
            ],
            [
                'name' => 'Digital Marketing',
                'slug' => 'digital-marketing',
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
            ],
            [
                'name' => 'Personal Development',
                'slug' => 'personal-development',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
