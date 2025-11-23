@extends('layouts.admin')

@section('title', __('Edit Experience'))

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Experience') }}</h2>
        <a href="{{ route('admin.experiences.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 font-medium flex items-center transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            {{ __('Back') }}
        </a>
    </div>
    
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
        <form action="{{ route('admin.experiences.update', $experience) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Spanish Fields -->
            <div class="border-b border-gray-100 dark:border-gray-700 pb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center mr-3 text-xs font-bold">ES</span>
                    Español
                </h3>
                <div class="grid grid-cols-1 gap-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="company_es" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Company / Institution (ES)') }}</label>
                            <input type="text" name="company[es]" id="company_es" value="{{ $experience->company['es'] ?? '' }}" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
                        </div>
                        <div>
                            <label for="role_es" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Role / Degree (ES)') }}</label>
                            <input type="text" name="role[es]" id="role_es" value="{{ $experience->role['es'] ?? '' }}" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="period_es" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Period (ES)') }}</label>
                            <input type="text" name="period[es]" id="period_es" value="{{ $experience->period['es'] ?? '' }}" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
                        </div>
                        <div>
                            <label for="location_es" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Location (ES)') }}</label>
                            <input type="text" name="location[es]" id="location_es" value="{{ $experience->location['es'] ?? '' }}" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
                        </div>
                    </div>
                    <div>
                        <label for="description_es" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Description (ES)') }}</label>
                        <textarea name="description[es]" id="description_es" rows="3" maxlength="1000" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>{{ $experience->description['es'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- English Fields -->
            <div class="border-b border-gray-100 dark:border-gray-700 pb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mr-3 text-xs font-bold">EN</span>
                    English
                </h3>
                <div class="grid grid-cols-1 gap-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="company_en" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Company / Institution (EN)') }}</label>
                            <input type="text" name="company[en]" id="company_en" value="{{ $experience->company['en'] ?? '' }}" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
                        </div>
                        <div>
                            <label for="role_en" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Role / Degree (EN)') }}</label>
                            <input type="text" name="role[en]" id="role_en" value="{{ $experience->role['en'] ?? '' }}" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="period_en" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Period (EN)') }}</label>
                            <input type="text" name="period[en]" id="period_en" value="{{ $experience->period['en'] ?? '' }}" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
                        </div>
                        <div>
                            <label for="location_en" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Location (EN)') }}</label>
                            <input type="text" name="location[en]" id="location_en" value="{{ $experience->location['en'] ?? '' }}" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
                        </div>
                    </div>
                    <div>
                        <label for="description_en" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Description (EN)') }}</label>
                        <textarea name="description[en]" id="description_en" rows="3" maxlength="1000" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>{{ $experience->description['en'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Skills') }}</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($skills as $skill)
                        <label class="flex items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                            <input type="checkbox" name="skills[]" value="{{ $skill->id }}" {{ $experience->skills->contains($skill->id) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-purple-600 focus:ring-purple-500 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $skill->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="logo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Logo') }}</label>
                    @if($experience->logo)
                        <div class="mb-2">
                            <img src="{{ $experience->logo }}" alt="Current Logo" class="h-16 w-16 object-contain bg-gray-50 dark:bg-gray-700 rounded-lg p-1">
                        </div>
                    @endif
                    <input type="file" name="logo" id="logo" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-900/30 dark:file:text-purple-300 transition-colors">
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Upload an image (JPG, PNG, max 2MB).') }}</p>
                </div>

                <div>
                    <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Type') }}</label>
                    <select name="type" id="type" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors">
                        <option value="work" {{ $experience->type === 'work' ? 'selected' : '' }}>{{ __('Work') }}</option>
                        <option value="education" {{ $experience->type === 'education' ? 'selected' : '' }}>{{ __('Education') }}</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <a href="{{ route('admin.experiences.index') }}" class="bg-white dark:bg-gray-700 py-2.5 px-6 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 mr-4 transition-colors">{{ __('Cancel') }}</a>
                <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-lg shadow-purple-500/30 text-sm font-medium rounded-xl text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all hover:scale-105">{{ __('Update') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
