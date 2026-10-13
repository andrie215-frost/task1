<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            [
                'name' => 'PHP',
                'category' => 'Software Development',
            ],
            [
                'name' => 'Laravel',
                'category' => 'Software Development',
            ],
            [
                'name' => 'JavaScript',
                'category' => 'Software Development',
            ],
            [
                'name' => 'HTML',
                'category' => 'Web Development',
            ],
            [
                'name' => 'CSS',
                'category' => 'Web Development',
            ],
            [
                'name' => 'MySQL',
                'category' => 'Database',
            ],
            [
                'name' => 'Graphic Design',
                'category' => 'Creative',
            ],
            [
                'name' => 'Video Editing',
                'category' => 'Creative',
            ],
            [
                'name' => 'Digital Marketing',
                'category' => 'Marketing',
            ],
            [
                'name' => 'Social Media Management',
                'category' => 'Marketing',
            ],
            [
                'name' => 'Accounting',
                'category' => 'Business',
            ],
            [
                'name' => 'Bookkeeping',
                'category' => 'Business',
            ],
            [
                'name' => 'Carpentry',
                'category' => 'Skilled Trade',
            ],
            [
                'name' => 'Electrical Installation',
                'category' => 'Skilled Trade',
            ],
            [
                'name' => 'Plumbing',
                'category' => 'Skilled Trade',
            ],
            [
                'name' => 'Welding',
                'category' => 'Skilled Trade',
            ],
            [
                'name' => 'Customer Service',
                'category' => 'Service',
            ],
            [
                'name' => 'Project Management',
                'category' => 'Management',
            ],
            [
                'name' => 'Data Entry',
                'category' => 'Administrative',
            ],
            [
                'name' => 'Microsoft Office',
                'category' => 'Administrative',
            ],
            [
                'name' => 'UI/UX Design',
                'category' => 'Creative',
            ],
            [
                'name' => 'Network Administrator',
                'category' => 'Network Administration',
            ],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                ['category' => $skill['category']]
            );
        }
    }
}