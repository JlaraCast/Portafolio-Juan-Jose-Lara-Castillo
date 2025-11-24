@extends('layouts.app')

@section('title', 'Juan José Lara Castillo - Portfolio')

@section('content')
<div class="space-y-24">
    <!-- Hero Section -->
    <section class="text-center py-20 relative overflow-hidden">
        <div class="absolute inset-0 -z-10 opacity-30 blur-3xl hidden dark:block">
            <div class="bg-indigo-500 w-96 h-96 rounded-full absolute top-0 left-1/4 mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="bg-purple-500 w-96 h-96 rounded-full absolute top-0 right-1/4 mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
        </div>
        
        <h1 class="text-5xl font-extrabold text-gray-900 dark:text-white sm:text-6xl md:text-7xl tracking-tight">
            <span data-translate="hero.title">Hola, soy</span> <span class="text-emerald-600 dark:bg-gradient-to-r dark:from-indigo-500 dark:to-purple-600 dark:bg-clip-text dark:text-transparent">{{ $user->name }}</span>
        </h1>
        <p class="mt-6 max-w-3xl mx-auto text-lg text-gray-700 dark:text-gray-300 sm:text-xl md:mt-8">
            <span data-translate-json="{{ json_encode($user->subtitle) }}">{{ $user->subtitle['es'] ?? '' }}</span>
        </p>
        <div class="mt-8 max-w-4xl mx-auto text-base text-gray-600 dark:text-gray-400 whitespace-pre-line">
            <span data-translate-json="{{ json_encode($user->description) }}">{{ $user->description['es'] ?? '' }}</span>
        </div>
        <div class="mt-10 max-w-md mx-auto sm:flex sm:justify-center gap-4">
            <button onclick="openContactModal()" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-indigo-600 dark:hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 transition-transform hover:scale-105 shadow-lg shadow-emerald-500/30 dark:shadow-indigo-500/30">
                <span data-translate="hero.contact">Contáctame</span>
            </button>
            <a href="#projects" class="w-full flex items-center justify-center px-8 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-full text-emerald-600 dark:text-indigo-400 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 md:py-4 md:text-lg md:px-10 transition-transform hover:scale-105">
                <span data-translate="hero.work">Ver Experiencia</span>
            </a>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-10 text-center" data-translate="skills.title">Habilidades Técnicas</h2>
        <div class="flex flex-wrap justify-center gap-4 max-w-4xl mx-auto">
            @foreach($skills as $skill)
                <div class="skill-card cursor-pointer bg-white dark:bg-gray-800 px-6 py-4 rounded-full shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 group hover:scale-105"
                     data-skill-id="{{ $skill->id }}"
                     onclick="filterBySkill({{ $skill->id }}, this)">
                    <div class="flex items-center gap-3">
                        @if($skill->icon)
                            <span class="w-12 h-12 text-4xl group-hover:scale-110 transition-transform duration-300 flex-shrink-0 flex items-center justify-center">{!! $skill->icon !!}</span>
                        @endif
                        <span class="font-semibold text-lg text-gray-800 dark:text-gray-200 whitespace-nowrap">{{ $skill->name }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Experience Section (Work & Education) -->
    <section id="experience" class="py-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-10 text-center" data-translate="projects.title">Experiencia</h2>
        <div class="max-w-4xl mx-auto space-y-8">
            @foreach($experiences as $experience)
                <div class="experience-card bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row gap-6 items-start"
                     data-skill-ids="{{ $experience->skills->pluck('id')->implode(',') }}">
                    @if($experience->logo)
                        <div class="flex-shrink-0 bg-white p-2 rounded-lg shadow-sm">
                            <img src="{{ $experience->logo }}" alt="{{ $experience->company['es'] ?? '' }}" class="w-16 h-16 object-contain">
                        </div>
                    @endif
                    <div class="flex-1 w-full">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-2">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white" data-translate-json="{{ json_encode($experience->role) }}">{{ $experience->role['es'] ?? '' }}</h3>
                                <p class="text-emerald-600 dark:text-indigo-400 font-medium" data-translate-json="{{ json_encode($experience->company) }}">{{ $experience->company['es'] ?? '' }}</p>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1 md:mt-0 text-right">
                                <p data-translate-json="{{ json_encode($experience->period) }}">{{ $experience->period['es'] ?? '' }}</p>
                                <p data-translate-json="{{ json_encode($experience->location) }}">{{ $experience->location['es'] ?? '' }}</p>
                            </div>
                        </div>
                        @if($experience->description)
                            <p class="text-gray-700 dark:text-gray-300 mt-3 text-sm leading-relaxed" data-translate-json="{{ json_encode($experience->description) }}">{{ $experience->description['es'] ?? '' }}</p>
                        @endif
                        <div class="flex flex-wrap gap-2 mt-4">
                            @foreach($experience->skills as $skill)
                                <span class="skill-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 dark:bg-indigo-900/30 text-emerald-700 dark:text-indigo-300 border border-emerald-100 dark:border-indigo-800 transition-colors duration-300" data-skill-id="{{ $skill->id }}">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Projects Section (Coding Projects) -->
    <section id="projects" class="py-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-10 text-center">Proyectos</h2>
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($projects as $project)
                <div class="project-card bg-white dark:bg-purple-900/50 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-purple-700 flex flex-col h-full"
                     data-skill-ids="{{ $project->skills->pluck('id')->implode(',') }}">
                    <div class="relative overflow-hidden group h-48 bg-gradient-to-br from-emerald-500 to-emerald-600 dark:from-indigo-600 dark:to-purple-700">
                        <img class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-500" src="{{ $project->image_url }}" alt="{{ $project->title['es'] ?? '' }}">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center space-x-4">
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" class="p-2 bg-white rounded-full text-gray-900 hover:text-emerald-600 transition-colors" title="View Code">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                </a>
                            @endif
                            @if($project->live_url)
                                <a href="{{ $project->live_url }}" target="_blank" class="p-2 bg-white rounded-full text-gray-900 hover:text-emerald-600 transition-colors" title="Live Demo">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" data-translate-json="{{ json_encode($project->title) }}">{{ $project->title['es'] ?? '' }}</h3>
                        <p class="text-gray-700 dark:text-gray-400 mb-4 flex-1" data-translate-json="{{ json_encode($project->description) }}">{{ $project->description['es'] ?? '' }}</p>
                        <div class="flex flex-wrap gap-2 mt-auto">
                            @foreach($project->skills as $skill)
                                <span class="skill-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 dark:bg-indigo-900/30 text-emerald-700 dark:text-indigo-300 border border-emerald-100 dark:border-indigo-800 transition-colors duration-300" data-skill-id="{{ $skill->id }}">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>


</div>

<!-- Contact Modal -->
<div id="contact-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeContactModal()"></div>

    <!-- Modal Container -->
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal Panel -->
            <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100 dark:border-gray-700">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title" data-translate="contact.title">
                                Contáctame
                            </h3>
                            <div class="mt-4 space-y-4">
                                <a href="mailto:jlaracast@gmail.com" class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-emerald-100 dark:bg-indigo-900/30 text-emerald-600 dark:text-indigo-400 group-hover:bg-emerald-200 dark:group-hover:bg-indigo-800 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Email</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">jlaracast@gmail.com</p>
                                    </div>
                                </a>
                                
                                <a href="tel:+50689259108" class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-emerald-100 dark:bg-indigo-900/30 text-emerald-600 dark:text-indigo-400 group-hover:bg-emerald-200 dark:group-hover:bg-indigo-800 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Teléfono</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">+506 8925 9108</p>
                                    </div>
                                </a>

                                <a href="https://www.linkedin.com/in/juan-josé-lara-castillo-053298355" target="_blank" class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-emerald-100 dark:bg-indigo-900/30 text-emerald-600 dark:text-indigo-400 group-hover:bg-emerald-200 dark:group-hover:bg-indigo-800 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">LinkedIn</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Ver perfil</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 dark:bg-indigo-600 text-base font-medium text-white hover:bg-emerald-700 dark:hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeContactModal()">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function openContactModal() {
        document.getElementById('contact-modal').classList.remove('hidden');
    }

    function closeContactModal() {
        document.getElementById('contact-modal').classList.add('hidden');
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeContactModal();
        }
    });
    
    let activeSkillIds = new Set();

    function filterBySkill(skillId, element) {
        const skills = document.querySelectorAll('.skill-card');
        const projects = document.querySelectorAll('.project-card');
        const experiences = document.querySelectorAll('.experience-card');
        const skillBadges = document.querySelectorAll('.skill-badge');

        // Toggle active state
        if (activeSkillIds.has(skillId)) {
            activeSkillIds.delete(skillId);
            element.classList.remove('ring-2', 'ring-emerald-500', 'dark:ring-indigo-500', 'bg-emerald-50', 'dark:bg-indigo-900/20');
        } else {
            activeSkillIds.add(skillId);
            element.classList.add('ring-2', 'ring-emerald-500', 'dark:ring-indigo-500', 'bg-emerald-50', 'dark:bg-indigo-900/20');
        }

        // Highlight badges
        skillBadges.forEach(badge => {
            const badgeId = parseInt(badge.getAttribute('data-skill-id'));
            if (activeSkillIds.has(badgeId)) {
                 badge.classList.remove('bg-emerald-50', 'dark:bg-indigo-900/30', 'text-emerald-700', 'dark:text-indigo-300', 'border-emerald-100', 'dark:border-indigo-800');
                 badge.classList.add('bg-emerald-600', 'dark:bg-indigo-600', 'text-white', 'border-transparent');
            } else {
                 badge.classList.add('bg-emerald-50', 'dark:bg-indigo-900/30', 'text-emerald-700', 'dark:text-indigo-300', 'border-emerald-100', 'dark:border-indigo-800');
                 badge.classList.remove('bg-emerald-600', 'dark:bg-indigo-600', 'text-white', 'border-transparent');
            }
        });

        // Filter items
        if (activeSkillIds.size === 0) {
            // Reset all items if no filter
            projects.forEach(el => el.style.display = 'flex');
            experiences.forEach(el => el.style.display = 'flex');
        } else {
            projects.forEach(el => {
                const ids = el.getAttribute('data-skill-ids').split(',').map(Number);
                // Check if item has ALL of the active skills
                const hasSkill = [...activeSkillIds].every(id => ids.includes(id));
                el.style.display = hasSkill ? 'flex' : 'none';
            });

            experiences.forEach(el => {
                const ids = el.getAttribute('data-skill-ids').split(',').map(Number);
                const hasSkill = [...activeSkillIds].every(id => ids.includes(id));
                el.style.display = hasSkill ? 'flex' : 'none';
            });
        }
    }
</script>
