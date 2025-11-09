<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            // JavaScript Course Modules
            'Complete JavaScript Mastery' => [
                [
                    'title' => 'JavaScript Fundamentals',
                    'position' => 1,
                ],
                [
                    'title' => 'Functions and Scope',
                    'position' => 2,
                ],
                [
                    'title' => 'DOM Manipulation',
                    'position' => 3,
                ],
                [
                    'title' => 'Asynchronous JavaScript',
                    'position' => 4,
                ],
            ],

            // React.js Course Modules
            'React.js Fundamentals' => [
                [
                    'title' => 'React Basics',
                    'position' => 1,
                ],
                [
                    'title' => 'State Management',
                    'position' => 2,
                ],
                [
                    'title' => 'React Router',
                    'position' => 3,
                ],
            ],

            // Python for Data Science Modules
            'Python for Data Science' => [
                [
                    'title' => 'Python Basics',
                    'position' => 1,
                ],
                [
                    'title' => 'NumPy and Pandas',
                    'position' => 2,
                ],
                [
                    'title' => 'Data Visualization',
                    'position' => 3,
                ],
            ],

            // Flutter Course Modules
            'Mobile App Development with Flutter' => [
                [
                    'title' => 'Flutter Setup',
                    'position' => 1,
                ],
                [
                    'title' => 'Widgets and Layouts',
                    'position' => 2,
                ],
                [
                    'title' => 'State Management',
                    'position' => 3,
                ],
            ],

            // UI/UX Design Modules
            'UI/UX Design Principles' => [
                [
                    'title' => 'Design Fundamentals',
                    'position' => 1,
                ],
                [
                    'title' => 'User Research',
                    'position' => 2,
                ],
                [
                    'title' => 'Prototyping',
                    'position' => 3,
                ],
            ],

            // Digital Marketing Modules
            'Digital Marketing Strategies' => [
                [
                    'title' => 'SEO Basics',
                    'position' => 1,
                ],
                [
                    'title' => 'Social Media Marketing',
                    'position' => 2,
                ],
                [
                    'title' => 'Content Marketing',
                    'position' => 3,
                ],
            ],

            // Machine Learning Modules
            'Machine Learning Basics' => [
                [
                    'title' => 'ML Fundamentals',
                    'position' => 1,
                ],
                [
                    'title' => 'Supervised Learning',
                    'position' => 2,
                ],
                [
                    'title' => 'Model Evaluation',
                    'position' => 3,
                ],
            ],

            // DevOps Modules
            'DevOps and Cloud Computing' => [
                [
                    'title' => 'DevOps Introduction',
                    'position' => 1,
                ],
                [
                    'title' => 'CI/CD Pipelines',
                    'position' => 2,
                ],
                [
                    'title' => 'Cloud Deployment',
                    'position' => 3,
                ],
            ],
        ];

        foreach ($modules as $className => $moduleList) {
            $class = ClassModel::where('title', $className)->first();
            
            if ($class) {
                foreach ($moduleList as $moduleData) {
                    $moduleData['class_id'] = $class->id;
                    Module::create($moduleData);
                }
            }
        }
    }
}
