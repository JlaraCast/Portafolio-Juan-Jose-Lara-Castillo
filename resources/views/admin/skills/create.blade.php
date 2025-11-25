@extends('layouts.admin')

@section('title', __('Add Skill'))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Add Skill') }}</h2>
        <a href="{{ route('admin.skills.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 font-medium flex items-center transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            {{ __('Back') }}
        </a>
    </div>
    
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
        <form action="{{ route('admin.skills.store') }}" method="POST" class="space-y-6 loading-form">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Skill Name') }}</label>
                <input type="text" name="name" id="name" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="icon" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Icon') }} (Devicon class)</label>
                    <button type="button" onclick="document.getElementById('icon').value = '<i class=\'devicon-php-plain\'></i>'" class="text-xs px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-lg hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-colors font-medium">
                        {{ __('Insert example') }}
                    </button>
                </div>
                <input type="text" name="icon" id="icon" maxlength="500" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" placeholder="<i class='devicon-php-plain'></i>" required>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Paste SVG code. Need icons? Check Devicon.') }}</p>
            </div>

            <div class="flex justify-end pt-4">
                <a href="{{ route('admin.skills.index') }}" class="bg-white dark:bg-gray-700 py-2.5 px-6 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 mr-4 transition-colors">{{ __('Cancel') }}</a>
                <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-lg shadow-emerald-500/30 text-sm font-medium rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all hover:scale-105">{{ __('Save') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
