@extends('layouts.admin')

@section('title', __('Edit Profile'))

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Profile') }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6 loading-form">
            @csrf
            @method('PUT')

            <!-- Account Information -->
            <div class="border-b border-gray-100 dark:border-gray-700 pb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('Account Information') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" maxlength="255" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="border-b border-gray-100 dark:border-gray-700 pb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('Change Password') }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ __('Leave blank to keep current password') }}</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('New Password') }}</label>
                        <input type="password" name="password" id="password" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('Min 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character') }}</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 transition-colors">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-lg shadow-indigo-500/30 text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:scale-105">{{ __('Update') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
