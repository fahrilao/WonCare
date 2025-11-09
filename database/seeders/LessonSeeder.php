<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessons = [
            // JavaScript Fundamentals Module
            'JavaScript Fundamentals' => [
                [
                    'title' => 'Variables and Data Types',
                    'content' => 'Learn about JavaScript variables, let, const, and different data types.',
                    'youtube_url' => 'https://www.youtube.com/embed/W6NZfCO5SIk',
                    'duration' => 8,
                    'position' => 1,
                ],
                [
                    'title' => 'Operators in JavaScript',
                    'content' => 'Master arithmetic, comparison, and logical operators.',
                    'youtube_url' => 'https://www.youtube.com/embed/FZzyij43A8c',
                    'duration' => 6,
                    'position' => 2,
                ],
                [
                    'title' => 'Control Structures',
                    'content' => 'Learn if statements, loops, and switch cases.',
                    'youtube_url' => 'https://www.youtube.com/embed/IsG4Xd6LlsM',
                    'duration' => 10,
                    'position' => 3,
                ],
                [
                    'title' => 'Arrays and Objects',
                    'content' => 'Work with JavaScript arrays and objects.',
                    'youtube_url' => 'https://www.youtube.com/embed/R8rmfD9Y5-c',
                    'duration' => 12,
                    'position' => 4,
                ],
            ],

            // Functions and Scope Module
            'Functions and Scope' => [
                [
                    'title' => 'Function Declaration',
                    'content' => 'Learn how to declare and call functions in JavaScript.',
                    'youtube_url' => 'https://www.youtube.com/embed/N8ap4k_1QEQ',
                    'duration' => 7,
                    'position' => 1,
                ],
                [
                    'title' => 'Arrow Functions',
                    'content' => 'Master ES6 arrow functions and their syntax.',
                    'youtube_url' => 'https://www.youtube.com/embed/h33Srr5J9nY',
                    'duration' => 5,
                    'position' => 2,
                ],
                [
                    'title' => 'Scope and Closures',
                    'content' => 'Understand JavaScript scope and closure concepts.',
                    'youtube_url' => 'https://www.youtube.com/embed/3a0I8ICR1Vg',
                    'duration' => 9,
                    'position' => 3,
                ],
            ],

            // DOM Manipulation Module
            'DOM Manipulation' => [
                [
                    'title' => 'Selecting Elements',
                    'content' => 'Learn how to select HTML elements with JavaScript.',
                    'youtube_url' => 'https://www.youtube.com/embed/y17RuWkWdn8',
                    'duration' => 8,
                    'position' => 1,
                ],
                [
                    'title' => 'Modifying Elements',
                    'content' => 'Change element content, attributes, and styles.',
                    'youtube_url' => 'https://www.youtube.com/embed/5fb2aPlgoys',
                    'duration' => 10,
                    'position' => 2,
                ],
                [
                    'title' => 'Event Handling',
                    'content' => 'Handle user interactions with event listeners.',
                    'youtube_url' => 'https://www.youtube.com/embed/XF1_MlZ5l6M',
                    'duration' => 11,
                    'position' => 3,
                ],
            ],

            // Asynchronous JavaScript Module
            'Asynchronous JavaScript' => [
                [
                    'title' => 'Promises Explained',
                    'content' => 'Understand JavaScript promises and how to use them.',
                    'youtube_url' => 'https://www.youtube.com/embed/DHvZLI7Db8E',
                    'duration' => 12,
                    'position' => 1,
                ],
                [
                    'title' => 'Async/Await Syntax',
                    'content' => 'Master modern async/await syntax for cleaner code.',
                    'youtube_url' => 'https://www.youtube.com/embed/V_Kr9OSfDeU',
                    'duration' => 9,
                    'position' => 2,
                ],
                [
                    'title' => 'Fetch API',
                    'content' => 'Make HTTP requests using the Fetch API.',
                    'youtube_url' => 'https://www.youtube.com/embed/cuEtnrL9-H0',
                    'duration' => 15,
                    'position' => 3,
                ],
            ],

            // React Basics Module
            'React Basics' => [
                [
                    'title' => 'What is React?',
                    'content' => 'Introduction to React library and its benefits.',
                    'youtube_url' => 'https://www.youtube.com/embed/Tn6-PIqc4UM',
                    'duration' => 6,
                    'position' => 1,
                ],
                [
                    'title' => 'JSX Syntax',
                    'content' => 'Learn JSX syntax and how to write React components.',
                    'youtube_url' => 'https://www.youtube.com/embed/7fPXI_MnBOY',
                    'duration' => 8,
                    'position' => 2,
                ],
                [
                    'title' => 'Components and Props',
                    'content' => 'Create reusable components and pass data with props.',
                    'youtube_url' => 'https://www.youtube.com/embed/QFaFIcGhPoM',
                    'duration' => 10,
                    'position' => 3,
                ],
            ],

            // State Management Module
            'State Management' => [
                [
                    'title' => 'useState Hook',
                    'content' => 'Manage component state with the useState hook.',
                    'youtube_url' => 'https://www.youtube.com/embed/O6P86uwfdR0',
                    'duration' => 9,
                    'position' => 1,
                ],
                [
                    'title' => 'useEffect Hook',
                    'content' => 'Handle side effects with the useEffect hook.',
                    'youtube_url' => 'https://www.youtube.com/embed/0ZJgIjIuY7U',
                    'duration' => 11,
                    'position' => 2,
                ],
                [
                    'title' => 'Context API',
                    'content' => 'Share state across components with Context API.',
                    'youtube_url' => 'https://www.youtube.com/embed/35lXWvCuM8o',
                    'duration' => 13,
                    'position' => 3,
                ],
            ],

            // React Router Module
            'React Router' => [
                [
                    'title' => 'Setting up Router',
                    'content' => 'Install and configure React Router for navigation.',
                    'youtube_url' => 'https://www.youtube.com/embed/Law7wfdg_ls',
                    'duration' => 7,
                    'position' => 1,
                ],
                [
                    'title' => 'Route Parameters',
                    'content' => 'Handle dynamic routes and URL parameters.',
                    'youtube_url' => 'https://www.youtube.com/embed/Ul3y1LXxzdU',
                    'duration' => 8,
                    'position' => 2,
                ],
            ],

            // Python Basics Module
            'Python Basics' => [
                [
                    'title' => 'Python Syntax',
                    'content' => 'Learn Python syntax and basic programming concepts.',
                    'youtube_url' => 'https://www.youtube.com/embed/kqtD5dpn9C8',
                    'duration' => 10,
                    'position' => 1,
                ],
                [
                    'title' => 'Data Structures',
                    'content' => 'Work with lists, tuples, dictionaries, and sets.',
                    'youtube_url' => 'https://www.youtube.com/embed/W8KRzm-HUcc',
                    'duration' => 12,
                    'position' => 2,
                ],
                [
                    'title' => 'Functions in Python',
                    'content' => 'Create and use functions in Python.',
                    'youtube_url' => 'https://www.youtube.com/embed/9Os0o3wzS_I',
                    'duration' => 8,
                    'position' => 3,
                ],
            ],

            // NumPy and Pandas Module
            'NumPy and Pandas' => [
                [
                    'title' => 'NumPy Arrays',
                    'content' => 'Work with NumPy arrays for numerical computing.',
                    'youtube_url' => 'https://www.youtube.com/embed/QUT1VHiLmmI',
                    'duration' => 15,
                    'position' => 1,
                ],
                [
                    'title' => 'Pandas DataFrames',
                    'content' => 'Manipulate data with Pandas DataFrames.',
                    'youtube_url' => 'https://www.youtube.com/embed/vmEHCJofslg',
                    'duration' => 18,
                    'position' => 2,
                ],
                [
                    'title' => 'Data Cleaning',
                    'content' => 'Clean and prepare data for analysis.',
                    'youtube_url' => 'https://www.youtube.com/embed/bDhvCp3_lYw',
                    'duration' => 14,
                    'position' => 3,
                ],
            ],

            // Data Visualization Module
            'Data Visualization' => [
                [
                    'title' => 'Matplotlib Basics',
                    'content' => 'Create basic plots with Matplotlib.',
                    'youtube_url' => 'https://www.youtube.com/embed/UO98lJQ3QGI',
                    'duration' => 12,
                    'position' => 1,
                ],
                [
                    'title' => 'Seaborn Plots',
                    'content' => 'Create statistical visualizations with Seaborn.',
                    'youtube_url' => 'https://www.youtube.com/embed/6GUZXDef2U0',
                    'duration' => 10,
                    'position' => 2,
                ],
            ],

            // Flutter Setup Module
            'Flutter Setup' => [
                [
                    'title' => 'Install Flutter',
                    'content' => 'Download and install Flutter SDK on your system.',
                    'youtube_url' => 'https://www.youtube.com/embed/CD1Y2DmL5JM',
                    'duration' => 8,
                    'position' => 1,
                ],
                [
                    'title' => 'First Flutter App',
                    'content' => 'Create your first Flutter application.',
                    'youtube_url' => 'https://www.youtube.com/embed/1gDhl4leEzA',
                    'duration' => 12,
                    'position' => 2,
                ],
            ],

            // Widgets and Layouts Module
            'Widgets and Layouts' => [
                [
                    'title' => 'Basic Widgets',
                    'content' => 'Learn about Text, Container, and Image widgets.',
                    'youtube_url' => 'https://www.youtube.com/embed/b_sQ9bMltGU',
                    'duration' => 10,
                    'position' => 1,
                ],
                [
                    'title' => 'Layout Widgets',
                    'content' => 'Master Row, Column, and Stack layouts.',
                    'youtube_url' => 'https://www.youtube.com/embed/RJEnTRBxaSg',
                    'duration' => 14,
                    'position' => 2,
                ],
                [
                    'title' => 'Responsive Design',
                    'content' => 'Build responsive UIs for different screen sizes.',
                    'youtube_url' => 'https://www.youtube.com/embed/0_C5cMzB8SI',
                    'duration' => 16,
                    'position' => 3,
                ],
            ],
        ];

        foreach ($lessons as $moduleName => $lessonList) {
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
