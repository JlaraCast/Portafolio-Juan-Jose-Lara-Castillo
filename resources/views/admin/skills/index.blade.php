@extends('layouts.admin')

@section('title', __('Manage Skills'))

@section('content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ __('Skills') }}</h2>
    <a href="{{ route('admin.skills.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-full font-medium shadow-lg shadow-emerald-500/30 transition-all hover:scale-105 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        {{ __('Add Skill') }}
    </a>
</div>

<div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700/50">
            <tr>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Name') }}</th>

                <th scope="col" class="relative px-6 py-4">
                    <span class="sr-only">{{ __('Edit') }}</span>
                </th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($skills as $skill)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        @if($skill->icon)
                            <div class="flex-shrink-0 h-12 w-12 rounded-xl bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-2xl text-gray-700 dark:text-gray-200">
                                {!! $skill->icon !!}
                            </div>
                        @endif
                        <div class="ml-4">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $skill->name }}</div>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.skills.edit', $skill) }}" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-900 dark:hover:text-emerald-300 mr-4 font-semibold">{{ __('Edit') }}</a>
                    <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" data-confirm-delete="{{ __('Are you sure you want to delete this skill? This action cannot be undone.') }}" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-semibold">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
