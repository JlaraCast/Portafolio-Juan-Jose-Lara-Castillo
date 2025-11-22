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
            <a href="#contact" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-indigo-600 dark:hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 transition-transform hover:scale-105 shadow-lg shadow-emerald-500/30 dark:shadow-indigo-500/30">
                <span data-translate="hero.contact">Contáctame</span>
            </a>
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
                <div class="bg-white dark:bg-gray-800 px-6 py-4 rounded-full shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 group hover:scale-105">
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
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row gap-6 items-start">
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
                <div class="bg-white dark:bg-purple-900/50 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-purple-700 flex flex-col h-full">
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
                            @foreach($project->technologies as $tech)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 dark:bg-indigo-900/30 text-emerald-700 dark:text-indigo-300 border border-emerald-100 dark:border-indigo-800">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-emerald-600 dark:bg-indigo-800 rounded-3xl text-white text-center relative overflow-hidden shadow-2xl mx-4 sm:mx-0">
        <div class="absolute inset-0 opacity-10 pattern-dots"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-extrabold mb-4" data-translate="contact.title">¿Listo para colaborar?</h2>
            <p class="text-xl mb-8 text-emerald-100 dark:text-indigo-100 max-w-2xl mx-auto" data-translate="contact.subtitle">Actualmente trabajo part-time como desarrollador backend en el equipo de I+D de la Universidad de Costa Rica.</p>
            <a href="mailto:contact@example.com" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-full text-emerald-600 dark:text-indigo-600 bg-white hover:bg-gray-50 transition-all hover:shadow-lg transform hover:-translate-y-1">
                <span data-translate="contact.button">Hablemos</span>
            </a>
        </div>
    </section>
</div>
@endsection
