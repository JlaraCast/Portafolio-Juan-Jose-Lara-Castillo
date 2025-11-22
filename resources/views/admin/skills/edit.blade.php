@extends('layouts.app')

@section('title', 'Edit Skill')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Skill</h2>
    
    <div class="bg-white shadow sm:rounded-lg p-6">
        <form action="{{ route('admin.skills.update', $skill) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Skill Name</label>
                <input type="text" name="name" id="name" value="{{ $skill->name }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="proficiency" class="block text-sm font-medium text-gray-700">Proficiency (1-100)</label>
                <input type="number" name="proficiency" id="proficiency" value="{{ $skill->proficiency }}" min="1" max="100" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div class="mb-6">
                <label for="icon" class="block text-sm font-medium text-gray-700">Icon (SVG or FontAwesome HTML)</label>
                <textarea name="icon" id="icon" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="<i class='fab fa-php'></i>">{{ $skill->icon }}</textarea>
                <p class="mt-2 text-sm text-gray-500">Paste SVG code or icon HTML here.</p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.skills.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">Cancel</a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update Skill</button>
            </div>
        </form>
    </div>
</div>
@endsection
