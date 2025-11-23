@extends('layouts.admin')

@section('title', __('Edit Project'))

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Project') }}</h2>
        <a href="{{ route('admin.projects.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 font-medium flex items-center transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            {{ __('Back') }}
        </a>
    </div>
    
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
        <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title_es" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Title') }} (ES)</label>
                    <input type="text" name="title_es" id="title_es" value="{{ $project->title['es'] ?? '' }}" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
                </div>
                <div>
                    <label for="title_en" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Title') }} (EN)</label>
                    <input type="text" name="title_en" id="title_en" value="{{ $project->title['en'] ?? '' }}" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="description_es" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Description') }} (ES)</label>
                    <textarea name="description_es" id="description_es" rows="4" maxlength="1000" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>{{ $project->description['es'] ?? '' }}</textarea>
                </div>
                <div>
                    <label for="description_en" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Description') }} (EN)</label>
                    <textarea name="description_en" id="description_en" rows="4" maxlength="1000" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>{{ $project->description['en'] ?? '' }}</textarea>
                </div>
            </div>

            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Image') }}</label>
                @if($project->image_url)
                    <div class="mb-3">
                        <img src="{{ $project->image_url }}" alt="Current image" class="h-32 w-auto rounded-lg object-cover border border-gray-300 dark:border-gray-600">
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-700 focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Upload a new image to replace the current one (JPG, PNG, max 2MB).') }}</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Skills') }}</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($skills as $skill)
                        <label class="flex items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                            <input type="checkbox" name="skills[]" value="{{ $skill->id }}" {{ $project->skills->contains($skill->id) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $skill->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="github_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Github Link') }} (Optional)</label>
                    <input type="url" name="github_url" id="github_url" value="{{ $project->github_url }}" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors">
                </div>
                <div>
                    <label for="live_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Project Link') }} (Optional)</label>
                    <input type="url" name="live_url" id="live_url" value="{{ $project->live_url }}" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors">
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <a href="{{ route('admin.projects.index') }}" class="bg-white dark:bg-gray-700 py-2.5 px-6 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4 transition-colors">{{ __('Cancel') }}</a>
                <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-lg shadow-indigo-500/30 text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:scale-105">{{ __('Update') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
