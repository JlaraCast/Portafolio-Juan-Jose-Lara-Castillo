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
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image_url' => 'required',
            'technologies' => 'required', // We will handle JSON conversion
        ]);

        // Simple handling for now, assuming technologies is comma separated string from input
        if (is_string($request->technologies)) {
            $validated['technologies'] = json_encode(array_map('trim', explode(',', $request->technologies)));
        }

        Project::create($validated);
        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        // Decode technologies for the form
        $project->technologies = implode(', ', json_decode($project->technologies, true) ?? []);
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image_url' => 'required',
            'technologies' => 'required',
        ]);

        if (is_string($request->technologies)) {
            $validated['technologies'] = json_encode(array_map('trim', explode(',', $request->technologies)));
        }

        $project->update($validated);
        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
