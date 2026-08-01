<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portfolio = Project::create([
            'title' => ['es' => 'Portafolio Personal', 'en' => 'Personal Portfolio'],
            'description' => [
                'es' => 'Mi portafolio profesional desarrollado con Laravel y Tailwind CSS. Incluye soporte para múltiples idiomas (i18n), modo oscuro y un panel administrativo para gestionar el contenido.',
                'en' => 'My professional portfolio developed with Laravel and Tailwind CSS. Includes multi-language support (i18n), dark mode, and an administrative panel to manage content.',
            ],
            'image_url' => '/images/porfolioJJ.png',
            'github_url' => 'https://github.com/JlaraCast/Portafolio-Juan-Jose-Lara-Castillo.git',
            'live_url' => null,
        ]);

        // Attach skills: Laravel, PHP, HTML5, CSS3, JavaScript
        $skills = Skill::whereIn('name', ['Laravel', 'PHP', 'HTML5', 'CSS3', 'JavaScript'])->get();
        $portfolio->skills()->attach($skills);
    }
}
