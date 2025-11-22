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
            ['name' => 'AWS', 'proficiency' => 60, 'icon' => '<i class="devicon-amazonwebservices-plain-wordmark" style="font-size: 3rem;"></i>'],
            
            // Certifications / Others
            ['name' => 'IoT', 'proficiency' => 70, 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>'],
            ['name' => 'CCNA', 'proficiency' => 75, 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>'],
        ];

        foreach ($skills as $skill) {
            \App\Models\Skill::create($skill);
        }
    }
}
