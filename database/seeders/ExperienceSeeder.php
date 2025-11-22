<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Work Experience
        $exp1 = \App\Models\Experience::create([
            'company' => ['es' => 'Universidad de Costa Rica UCR', 'en' => 'University of Costa Rica UCR'],
            'role' => ['es' => 'Desarrollador Backend en el equipo de I+D', 'en' => 'Backend Developer on the I+D Team'],
            'period' => ['es' => 'ago. 2025 - actualidad', 'en' => 'Aug 2025 - Present'],
            'location' => ['es' => 'Puntarenas, Costa Rica · En remoto', 'en' => 'Puntarenas, Costa Rica · Remote'],
            'description' => [
                'es' => 'Trabajé como asistente estudiantil en desarrollo backend utilizando herramientas como Laravel, y también apoyé en el diseño y desarrollo de la base de datos.',
                'en' => 'I worked as a student assistant in backend development using tools such as Laravel, and I also supported the design and development of the database.'
            ],
            'logo' => '/images/ucr.png',
            'type' => 'work',
        ]);

        // Attach skills: Laravel, PHP, SQL
        $skills1 = \App\Models\Skill::whereIn('name', ['Laravel', 'PHP', 'SQL'])->get();
        $exp1->skills()->attach($skills1);

        // Education
        $exp2 = \App\Models\Experience::create([
            'company' => ['es' => 'Universidad de Costa Rica UCR', 'en' => 'University of Costa Rica UCR'],
            'role' => ['es' => 'Bachillerato en Informática Empresarial', 'en' => 'Bachelor’s Degree, Business Informatics'],
            'period' => ['es' => 'ene. 2022 - dic. 2026', 'en' => 'Jan 2022 - Dec 2026'],
            'location' => ['es' => 'Puntarenas, Costa Rica', 'en' => 'Puntarenas, Costa Rica'],
            'description' => [
                'es' => 'La carrera de Informática Empresarial me ha brindado una formación integral que une la tecnología con la estrategia de negocios. He desarrollado competencias en análisis de sistemas, gestión de proyectos TI y desarrollo de software, preparándome para crear soluciones tecnológicas que optimicen procesos y generen valor organizacional.',
                'en' => 'The Business Informatics degree has provided me with comprehensive training bridging technology and business strategy. I have developed competencies in systems analysis, IT project management, and software development, preparing me to create technological solutions that optimize processes and generate organizational value.'
            ],
            'logo' => '/images/ucr.png',
            'type' => 'education',
        ]);

        // Attach skills: Java, C#, PHP, HTML5, CSS3, JavaScript, SQL
        $skills2 = \App\Models\Skill::whereIn('name', ['Java', 'C#', 'PHP', 'HTML5', 'CSS3', 'JavaScript', 'SQL'])->get();
        $exp2->skills()->attach($skills2);
    }
}
