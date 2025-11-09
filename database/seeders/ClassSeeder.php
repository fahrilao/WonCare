<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ClassModel;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                'title' => 'Complete JavaScript Mastery',
                'description' => 'Learn JavaScript from basics to advanced concepts with hands-on projects and real-world examples.',
                'thumbnail' => 'https://images.unsplash.com/photo-1627398242454-45a1465c2479?w=800&h=600&fit=crop',
                'status' => 'published',
                'categories' => ['Programming', 'Web Development'],
            ],
            [
                'title' => 'React.js Fundamentals',
                'description' => 'Master React.js with modern hooks, state management, and component architecture.',
                'thumbnail' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=800&h=600&fit=crop',
                'status' => 'published',
                'categories' => ['Programming', 'Web Development'],
            ],
            [
                'title' => 'Python for Data Science',
                'description' => 'Learn Python programming specifically for data analysis, visualization, and machine learning.',
                'thumbnail' => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?w=800&h=600&fit=crop',
                'status' => 'published',
                'categories' => ['Programming', 'Data Science'],
            ],
            [
                'title' => 'Mobile App Development with Flutter',
                'description' => 'Build cross-platform mobile applications using Flutter and Dart programming language.',
                'thumbnail' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&h=600&fit=crop',
                'status' => 'published',
                'categories' => ['Mobile Development', 'Programming'],
            ],
            [
                'title' => 'UI/UX Design Principles',
                'description' => 'Master the fundamentals of user interface and user experience design.',
                'thumbnail' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&h=600&fit=crop',
                'status' => 'published',
                'categories' => ['UI/UX Design'],
            ],
            [
                'title' => 'Digital Marketing Strategies',
                'description' => 'Learn effective digital marketing techniques including SEO, social media, and content marketing.',
                'thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop',
                'status' => 'published',
                'categories' => ['Digital Marketing', 'Business'],
            ],
            [
                'title' => 'Machine Learning Basics',
                'description' => 'Introduction to machine learning algorithms and practical applications.',
                'thumbnail' => 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=800&h=600&fit=crop',
                'status' => 'published',
                'categories' => ['Machine Learning', 'Data Science'],
            ],
            [
                'title' => 'DevOps and Cloud Computing',
                'description' => 'Learn DevOps practices, CI/CD, and cloud deployment strategies.',
                'thumbnail' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&h=600&fit=crop',
                'status' => 'published',
                'categories' => ['DevOps', 'Programming'],
            ],
        ];

        foreach ($classes as $classData) {
            $categories = $classData['categories'];
            unset($classData['categories']);

            $class = ClassModel::create($classData);

            // Attach categories
            $categoryIds = Category::whereIn('name', $categories)->pluck('id');
            $class->categories()->attach($categoryIds);
        }
    }
}
