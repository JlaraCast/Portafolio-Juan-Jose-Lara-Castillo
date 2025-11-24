@extends('layouts.admin')

@section('title', __('Manage Experiences'))

@section('content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ __('Experiences') }}</h2>
    <a href="{{ route('admin.experiences.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-full font-medium shadow-lg shadow-purple-500/30 transition-all hover:scale-105 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        {{ __('Add Experience') }}
    </a>
</div>

<div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700/50">
            <tr>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Company / Institution') }}</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Role / Degree') }}</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Period') }}</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Type') }}</th>
                <th scope="col" class="relative px-6 py-4">
                    <span class="sr-only">{{ __('Edit') }}</span>
                </th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($experiences as $experience)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        @if($experience->logo)
                        <div class="flex-shrink-0 h-12 w-12 relative group">
                            <img class="h-12 w-12 rounded-xl object-contain bg-white p-1 shadow-sm group-hover:scale-110 transition-transform duration-300" src="{{ $experience->logo }}" alt="{{ $experience->company['es'] ?? $experience->company['en'] ?? 'Company logo' }}">
                        </div>
                        @endif
                        <div class="ml-4">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $experience->company[app()->getLocale()] ?? $experience->company['en'] ?? 'N/A' }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900 dark:text-gray-300 font-medium">{{ $experience->role[app()->getLocale()] ?? $experience->role['en'] ?? 'N/A' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $experience->period[app()->getLocale()] ?? $experience->period['en'] ?? 'N/A' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $experience->type === 'work' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800' }}">
                        {{ __($experience->type === 'work' ? 'Work' : 'Education') }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.experiences.edit', $experience) }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300 mr-4 font-semibold">{{ __('Edit') }}</a>
                    <form action="{{ route('admin.experiences.destroy', $experience) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-semibold" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
