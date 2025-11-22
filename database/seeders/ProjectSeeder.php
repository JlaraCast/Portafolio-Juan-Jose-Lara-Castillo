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
        $portfolio = \App\Models\Project::create([
            'title' => ['es' => 'Portafolio Personal', 'en' => 'Personal Portfolio'],
            'description' => [
                'es' => 'Mi portafolio profesional desarrollado con Laravel y Tailwind CSS. Incluye soporte para múltiples idiomas (i18n), modo oscuro y un panel administrativo para gestionar el contenido.',
                'en' => 'My professional portfolio developed with Laravel and Tailwind CSS. Includes multi-language support (i18n), dark mode, and an administrative panel to manage content.'
            ],
            'image_url' => '/images/porfolioJJ.png',
            'github_url' => 'https://github.com/JlaraCast/Portafolio-Juan-Jose-Lara-Castillo.git',
            'live_url' => null,
        ]);

        // Attach skills: Laravel, PHP, HTML5, CSS3, JavaScript
        $skills = \App\Models\Skill::whereIn('name', ['Laravel', 'PHP', 'HTML5', 'CSS3', 'JavaScript'])->get();
        $portfolio->skills()->attach($skills);
    }
}
