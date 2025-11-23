<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') - Portfolio Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased transition-colors duration-300">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-72 bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl border-r border-gray-100 dark:border-gray-700 flex-shrink-0 hidden md:flex flex-col shadow-lg z-20">
            <div class="h-20 flex items-center px-8 border-b border-gray-100 dark:border-gray-700">
                <span class="text-2xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-indigo-400 dark:to-purple-500 bg-clip-text text-transparent">{{ __('Admin Panel') }}</span>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 dark:bg-indigo-900/20 text-emerald-600 dark:text-indigo-400 shadow-sm ring-1 ring-emerald-100 dark:ring-indigo-800' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-emerald-600 dark:hover:text-indigo-400' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-emerald-600 dark:text-indigo-400' : 'text-gray-400 dark:text-gray-500 group-hover:text-emerald-600 dark:group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    {{ __('Dashboard') }}
                </a>
                <a href="{{ route('admin.projects.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.projects.*') ? 'bg-indigo-50 dark:bg-purple-900/20 text-indigo-600 dark:text-purple-400 shadow-sm ring-1 ring-indigo-100 dark:ring-purple-800' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-indigo-600 dark:hover:text-purple-400' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.projects.*') ? 'text-indigo-600 dark:text-purple-400' : 'text-gray-400 dark:text-gray-500 group-hover:text-indigo-600 dark:group-hover:text-purple-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    {{ __('Projects') }}
                </a>
                <a href="{{ route('admin.skills.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.skills.*') ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 shadow-sm ring-1 ring-emerald-100 dark:ring-emerald-800' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-emerald-600 dark:hover:text-emerald-400' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.skills.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 dark:text-gray-500 group-hover:text-emerald-600 dark:group-hover:text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    {{ __('Skills') }}
                </a>
                <a href="{{ route('admin.experiences.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.experiences.*') ? 'bg-purple-50 dark:bg-pink-900/20 text-purple-600 dark:text-pink-400 shadow-sm ring-1 ring-purple-100 dark:ring-pink-800' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-purple-600 dark:hover:text-pink-400' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.experiences.*') ? 'text-purple-600 dark:text-pink-400' : 'text-gray-400 dark:text-gray-500 group-hover:text-purple-600 dark:group-hover:text-pink-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ __('Experiences') }}
                </a>
                <div class="pt-4 mt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.profile.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.profile.*') ? 'text-gray-900 dark:text-white' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ __('Profile') }}
                    </a>
                </div>
            </nav>
            <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-2xl transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50 dark:bg-gray-900">
            <!-- Top Header -->
            <header class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl shadow-sm border-b border-gray-100 dark:border-gray-700 h-20 flex items-center justify-between px-8 z-10 sticky top-0">
                <div class="flex items-center md:hidden">
                    <!-- Mobile menu button placeholder -->
                    <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <div class="flex items-center justify-end w-full space-x-6">
                    <a href="{{ route('home') }}" target="_blank" class="text-sm font-medium text-emerald-600 dark:text-indigo-400 hover:text-emerald-700 dark:hover:text-indigo-300 flex items-center transition-colors">
                        {{ __('View Portfolio') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>

                    <!-- Language Toggle -->
                    <a href="{{ route('lang.switch', app()->getLocale() == 'es' ? 'en' : 'es') }}" class="text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm px-3 py-2 font-medium transition-colors">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-xl text-sm p-2.5 transition-colors">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </button>

                    <div class="flex items-center pl-4 border-l border-gray-200 dark:border-gray-700">
                        <div class="h-9 w-9 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 dark:from-indigo-500 dark:to-purple-600 flex items-center justify-center text-white font-bold shadow-md">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-2xl relative mb-6 shadow-sm" role="alert">
                        <span class="block sm:inline font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    
    <!-- Translation variables for JavaScript -->
    <script>
        window.translations = {
            minCharacters: "{{ __('Min 8 characters') }}",
            lowercase: "{{ __('One lowercase letter') }}",
            uppercase: "{{ __('One uppercase letter') }}",
            number: "{{ __('One number') }}",
            specialChar: "{{ __('One special character') }}",
            passwordsMatch: "{{ __('Passwords match') }}",
            passwordsDontMatch: "{{ __('Passwords do not match') }}",
            characters: "{{ __('characters') }}"
        };
    </script>
    
    <!-- Form Validation Script -->
    <script src="{{ asset('js/form-validation.js') }}"></script>
</body>
</html>
