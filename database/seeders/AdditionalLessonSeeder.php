<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class AdditionalLessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder adds more lessons with YouTube Short videos for testing.
     */
    public function run(): void
    {
        $additionalLessons = [
            // Design Fundamentals Module
            'Design Fundamentals' => [
                [
                    'title' => 'Color Theory Basics',
                    'content' => 'Learn the fundamentals of color theory in design.',
                    'youtube_url' => 'https://www.youtube.com/embed/AvgCkHrcj90',
                    'duration' => 5,
                    'position' => 1,
                ],
                [
                    'title' => 'Typography Rules',
                    'content' => 'Master typography principles for better design.',
                    'youtube_url' => 'https://www.youtube.com/embed/QrNi9FmdlxY',
                    'duration' => 7,
                    'position' => 2,
                ],
                [
                    'title' => 'Visual Hierarchy',
                    'content' => 'Create effective visual hierarchy in your designs.',
                    'youtube_url' => 'https://www.youtube.com/embed/qZWDJqY27bw',
                    'duration' => 6,
                    'position' => 3,
                ],
            ],

            // User Research Module
            'User Research' => [
                [
                    'title' => 'User Interviews',
                    'content' => 'Conduct effective user interviews for insights.',
                    'youtube_url' => 'https://www.youtube.com/embed/Qq3OiHQ-HCU',
                    'duration' => 8,
                    'position' => 1,
                ],
                [
                    'title' => 'Survey Design',
                    'content' => 'Create surveys that get meaningful responses.',
                    'youtube_url' => 'https://www.youtube.com/embed/jhcn1_qsYmg',
                    'duration' => 6,
                    'position' => 2,
                ],
            ],

            // Prototyping Module
            'Prototyping' => [
                [
                    'title' => 'Wireframing Basics',
                    'content' => 'Create effective wireframes for your designs.',
                    'youtube_url' => 'https://www.youtube.com/embed/PmmQjLqJQlY',
                    'duration' => 9,
                    'position' => 1,
                ],
                [
                    'title' => 'Interactive Prototypes',
                    'content' => 'Build interactive prototypes with Figma.',
                    'youtube_url' => 'https://www.youtube.com/embed/X5qiBwqptek',
                    'duration' => 12,
                    'position' => 2,
                ],
            ],

            // SEO Basics Module
            'SEO Basics' => [
                [
                    'title' => 'Keyword Research',
                    'content' => 'Find the right keywords for your content.',
                    'youtube_url' => 'https://www.youtube.com/embed/hLvLlVgU4-g',
                    'duration' => 10,
                    'position' => 1,
                ],
                [
                    'title' => 'On-Page SEO',
                    'content' => 'Optimize your web pages for search engines.',
                    'youtube_url' => 'https://www.youtube.com/embed/DvwS7cV9GmQ',
                    'duration' => 8,
                    'position' => 2,
                ],
                [
                    'title' => 'Link Building',
                    'content' => 'Build quality backlinks to improve rankings.',
                    'youtube_url' => 'https://www.youtube.com/embed/l8VnZCcl9J4',
                    'duration' => 7,
                    'position' => 3,
                ],
            ],

            // Social Media Marketing Module
            'Social Media Marketing' => [
                [
                    'title' => 'Instagram Strategy',
                    'content' => 'Build an effective Instagram marketing strategy.',
                    'youtube_url' => 'https://www.youtube.com/embed/IGcwFV2u2qk',
                    'duration' => 9,
                    'position' => 1,
                ],
                [
                    'title' => 'TikTok Marketing',
                    'content' => 'Leverage TikTok for business growth.',
                    'youtube_url' => 'https://www.youtube.com/embed/ttjn2gB6l1A',
                    'duration' => 6,
                    'position' => 2,
                ],
                [
                    'title' => 'LinkedIn for Business',
                    'content' => 'Use LinkedIn effectively for B2B marketing.',
                    'youtube_url' => 'https://www.youtube.com/embed/UC3xf6PJGP0',
                    'duration' => 8,
                    'position' => 3,
                ],
            ],

            // Content Marketing Module
            'Content Marketing' => [
                [
                    'title' => 'Content Strategy',
                    'content' => 'Develop a winning content marketing strategy.',
                    'youtube_url' => 'https://www.youtube.com/embed/8w4qPUSG17Y',
                    'duration' => 11,
                    'position' => 1,
                ],
                [
                    'title' => 'Blog Writing Tips',
                    'content' => 'Write engaging blog posts that convert.',
                    'youtube_url' => 'https://www.youtube.com/embed/1ZIOme5Mh5E',
                    'duration' => 7,
                    'position' => 2,
                ],
            ],

            // ML Fundamentals Module
            'ML Fundamentals' => [
                [
                    'title' => 'What is Machine Learning?',
                    'content' => 'Introduction to machine learning concepts.',
                    'youtube_url' => 'https://www.youtube.com/embed/ukzFI9rgwfU',
                    'duration' => 8,
                    'position' => 1,
                ],
                [
                    'title' => 'Types of ML',
                    'content' => 'Learn about supervised, unsupervised, and reinforcement learning.',
                    'youtube_url' => 'https://www.youtube.com/embed/f_uwKZIAeM0',
                    'duration' => 10,
                    'position' => 2,
                ],
            ],

            // Supervised Learning Module
            'Supervised Learning' => [
                [
                    'title' => 'Linear Regression',
                    'content' => 'Understand linear regression algorithm.',
                    'youtube_url' => 'https://www.youtube.com/embed/nk2CQITm_eo',
                    'duration' => 12,
                    'position' => 1,
                ],
                [
                    'title' => 'Decision Trees',
                    'content' => 'Learn how decision trees work.',
                    'youtube_url' => 'https://www.youtube.com/embed/7VeUPuFGJHk',
                    'duration' => 9,
                    'position' => 2,
                ],
            ],

            // Model Evaluation Module
            'Model Evaluation' => [
                [
                    'title' => 'Cross Validation',
                    'content' => 'Evaluate models using cross-validation.',
                    'youtube_url' => 'https://www.youtube.com/embed/fSytzGwwBVw',
                    'duration' => 8,
                    'position' => 1,
                ],
                [
                    'title' => 'Metrics Explained',
                    'content' => 'Understand accuracy, precision, recall, and F1-score.',
                    'youtube_url' => 'https://www.youtube.com/embed/Kdsp6soqA7o',
                    'duration' => 10,
                    'position' => 2,
                ],
            ],

            // DevOps Introduction Module
            'DevOps Introduction' => [
                [
                    'title' => 'DevOps Culture',
                    'content' => 'Understand DevOps culture and principles.',
                    'youtube_url' => 'https://www.youtube.com/embed/0yWAtQ6wYNM',
                    'duration' => 7,
                    'position' => 1,
                ],
                [
                    'title' => 'DevOps Tools',
                    'content' => 'Overview of popular DevOps tools.',
                    'youtube_url' => 'https://www.youtube.com/embed/Xrgk023l4lI',
                    'duration' => 9,
                    'position' => 2,
                ],
            ],

            // CI/CD Pipelines Module
            'CI/CD Pipelines' => [
                [
                    'title' => 'What is CI/CD?',
                    'content' => 'Introduction to continuous integration and deployment.',
                    'youtube_url' => 'https://www.youtube.com/embed/1er2cjUq1UI',
                    'duration' => 8,
                    'position' => 1,
                ],
                [
                    'title' => 'GitHub Actions',
                    'content' => 'Build CI/CD pipelines with GitHub Actions.',
                    'youtube_url' => 'https://www.youtube.com/embed/R8_veQiYBjI',
                    'duration' => 12,
                    'position' => 2,
                ],
            ],

            // Cloud Deployment Module
            'Cloud Deployment' => [
                [
                    'title' => 'AWS Basics',
                    'content' => 'Introduction to Amazon Web Services.',
                    'youtube_url' => 'https://www.youtube.com/embed/ulprqHHWlng',
                    'duration' => 10,
                    'position' => 1,
                ],
                [
                    'title' => 'Docker Containers',
                    'content' => 'Containerize applications with Docker.',
                    'youtube_url' => 'https://www.youtube.com/embed/gAkwW2tuIqE',
                    'duration' => 11,
                    'position' => 2,
                ],
            ],

            // State Management (Flutter) Module
            'State Management' => [
                [
                    'title' => 'Provider Pattern',
                    'content' => 'Implement state management with Provider.',
                    'youtube_url' => 'https://www.youtube.com/embed/d_m5csmrf7I',
                    'duration' => 14,
                    'position' => 1,
                ],
                [
                    'title' => 'Bloc Pattern',
                    'content' => 'Advanced state management with Bloc.',
                    'youtube_url' => 'https://www.youtube.com/embed/THCkkQ-V1-8',
                    'duration' => 16,
                    'position' => 2,
                ],
            ],
        ];

        foreach ($additionalLessons as $moduleName => $lessonList) {
            $module = Module::where('title', $moduleName)->first();
            
            if ($module) {
                foreach ($lessonList as $lessonData) {
                    $lessonData['module_id'] = $module->id;
                    Lesson::create($lessonData);
                }
            }
        }
    }
}
