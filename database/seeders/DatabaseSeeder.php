<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Juan José',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'subtitle' => [
                'es' => 'Estudiante de Informática Empresarial | Desarrollador Backend | Apasionado por la Innovación Tecnológica | C#, PHP, HTML, Java, JavaScript',
                'en' => 'Business Informatics Student | Backend Developer | Passionate About Technological Innovation | C#, PHP, HTML, Java, JavaScript'
            ],
            'description' => [
                'es' => '',
                'en' => ''
            ],
            'hero_image' => null, // Removed as requested
        ]);

        $this->call([
            ProjectSeeder::class,
            SkillSeeder::class,
            ExperienceSeeder::class,
        ]);
    }
}
