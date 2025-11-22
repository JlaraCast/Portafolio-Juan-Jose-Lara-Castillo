<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Project::create([
            'title' => ['es' => 'Sistema de Gestión de Inventario', 'en' => 'Inventory Management System'],
            'description' => ['es' => 'Una aplicación web completa para gestionar inventario, ventas y proveedores.', 'en' => 'A complete web application to manage inventory, sales, and suppliers.'],
            'image_url' => 'https://via.placeholder.com/600x400',
            'github_url' => 'https://github.com/example/inventory',
            'live_url' => 'https://inventory.example.com',
            'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS'],
        ]);

        \App\Models\Project::create([
            'title' => ['es' => 'Plataforma E-learning', 'en' => 'E-learning Platform'],
            'description' => ['es' => 'Plataforma educativa con cursos en video, cuestionarios y seguimiento de progreso.', 'en' => 'Educational platform with video courses, quizzes, and progress tracking.'],
            'image_url' => 'https://via.placeholder.com/600x400',
            'github_url' => 'https://github.com/example/elearning',
            'live_url' => 'https://elearning.example.com',
            'technologies' => ['Laravel', 'React', 'PostgreSQL'],
        ]);
    }
}
