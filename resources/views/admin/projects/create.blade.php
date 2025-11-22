@extends('layouts.app')

@section('title', 'Add Project')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Add New Project</h2>
    
    <div class="bg-white shadow sm:rounded-lg p-6">
        <form action="{{ route('admin.projects.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required></textarea>
            </div>

            <div class="mb-4">
                <label for="image_url" class="block text-sm font-medium text-gray-700">Image URL</label>
                <input type="url" name="image_url" id="image_url" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required placeholder="https://example.com/image.jpg">
            </div>

            <div class="mb-4">
                <label for="technologies" class="block text-sm font-medium text-gray-700">Technologies (comma separated)</label>
                <input type="text" name="technologies" id="technologies" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required placeholder="Laravel, Vue.js, TailwindCSS">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="github_url" class="block text-sm font-medium text-gray-700">GitHub URL (Optional)</label>
                    <input type="url" name="github_url" id="github_url" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="live_url" class="block text-sm font-medium text-gray-700">Live URL (Optional)</label>
                    <input type="url" name="live_url" id="live_url" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.projects.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">Cancel</a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save Project</button>
            </div>
        </form>
    </div>
</div>
@endsection
