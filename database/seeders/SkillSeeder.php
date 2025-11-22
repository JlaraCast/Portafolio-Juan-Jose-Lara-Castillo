<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Languages
            ['name' => 'Java', 'proficiency' => 85, 'icon' => '<i class="devicon-java-plain"></i>'],
            ['name' => 'C#', 'proficiency' => 80, 'icon' => '<i class="devicon-csharp-plain"></i>'],
            ['name' => 'PHP', 'proficiency' => 90, 'icon' => '<i class="devicon-php-plain"></i>'],
            ['name' => 'JavaScript', 'proficiency' => 80, 'icon' => '<i class="devicon-javascript-plain"></i>'],
            
            // Web Technologies
            ['name' => 'HTML5', 'proficiency' => 95, 'icon' => '<i class="devicon-html5-plain"></i>'],
            ['name' => 'CSS3', 'proficiency' => 85, 'icon' => '<i class="devicon-css3-plain"></i>'],
            ['name' => 'Bootstrap', 'proficiency' => 85, 'icon' => '<i class="devicon-bootstrap-plain"></i>'],
            ['name' => 'Laravel', 'proficiency' => 85, 'icon' => '<i class="devicon-laravel-original"></i>'],

            // Database
            ['name' => 'SQL', 'proficiency' => 80, 'icon' => '<i class="devicon-mysql-plain"></i>'], // Using MySQL icon for SQL generic

            // Tools & Cloud
            ['name' => 'Docker', 'proficiency' => 70, 'icon' => '<i class="devicon-docker-plain"></i>'],
            ['name' => 'Linux', 'proficiency' => 75, 'icon' => '<i class="devicon-linux-plain"></i>'],
            ['name' => 'AWS', 'proficiency' => 60, 'icon' => '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M14.09 10.85c-.55.2-1.02.27-1.42.27-1.68 0-2.56-.83-2.56-2.42 0-1.55.93-2.38 2.68-2.38.95 0 1.68.22 2.18.65l-.55 1.38c-.35-.3-.85-.48-1.45-.48-.85 0-1.18.38-1.18 1.02 0 .68.42 1.02 1.28 1.02.35 0 .68-.05.95-.15l.07 1.09zm-5.85.15l-1.9-6.15h1.65l1.08 4.15 1.1-4.15h1.6l-1.92 6.15h-1.61zm-4.55 0l-1.9-6.15h1.65l1.08 4.15 1.1-4.15h1.6l-1.92 6.15h-1.61zm14.56-3.65c0 1.88-1.25 3.05-3.25 3.05-.85 0-1.58-.2-2.15-.58l.52-1.3c.45.3.98.48 1.55.48 1.05 0 1.65-.55 1.65-1.55v-.22c-.45.55-1.12.85-1.95.85-1.52 0-2.55-1.05-2.55-2.65 0-1.65 1.1-2.75 2.65-2.75.85 0 1.5.3 1.92.82v-.7h1.58v4.55h-.02zm-1.62-1.75c0-.88-.5-1.45-1.28-1.45-.82 0-1.35.6-1.35 1.5 0 .92.52 1.52 1.35 1.52.78 0 1.28-.58 1.28-1.58z"/></svg>'],
            
            // Certifications / Others
            ['name' => 'IoT', 'proficiency' => 70, 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>'],
            ['name' => 'CCNA', 'proficiency' => 75, 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>'],
        ];

        foreach ($skills as $skill) {
            \App\Models\Skill::create($skill);
        }
    }
}
