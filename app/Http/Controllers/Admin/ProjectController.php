<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $skills = \App\Models\Skill::all();
        return view('admin.projects.create', compact('skills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_es' => 'required',
            'title_en' => 'required',
            'description_es' => 'required',
            'description_en' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'skills' => 'nullable|array',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
            $imagePath = '/storage/' . $imagePath;
        }

        $project = Project::create([
            'title' => ['es' => $validated['title_es'], 'en' => $validated['title_en']],
            'description' => ['es' => $validated['description_es'], 'en' => $validated['description_en']],
            'image_url' => $imagePath,
            'github_url' => $validated['github_url'] ?? null,
            'live_url' => $validated['live_url'] ?? null,
        ]);

        // Attach skills if provided
        if (!empty($validated['skills'])) {
            $project->skills()->attach($validated['skills']);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $skills = \App\Models\Skill::all();
        return view('admin.projects.edit', compact('project', 'skills'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title_es' => 'required',
            'title_en' => 'required',
            'description_es' => 'required',
            'description_en' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'skills' => 'nullable|array',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
            $imagePath = '/storage/' . $imagePath;
        } else {
            $imagePath = $project->image_url; // Keep existing image
        }

        $project->update([
            'title' => ['es' => $validated['title_es'], 'en' => $validated['title_en']],
            'description' => ['es' => $validated['description_es'], 'en' => $validated['description_en']],
            'image_url' => $imagePath,
            'github_url' => $validated['github_url'] ?? null,
            'live_url' => $validated['live_url'] ?? null,
        ]);

        // Sync skills
        if (isset($validated['skills'])) {
            $project->skills()->sync($validated['skills']);
        } else {
            $project->skills()->detach();
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
