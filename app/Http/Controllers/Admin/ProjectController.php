<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Constructor to inject ImageUploadService.
     */
    public function __construct(
        protected ImageUploadService $imageService
    ) {}

    /**
     * Display a listing of all projects.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $projects = Project::with('skills')->get();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $skills = \App\Models\Skill::all();
        return view('admin.projects.create', compact('skills'));
    }

    /**
     * Store a newly created project in the database.
     *
     * @param \App\Http\Requests\StoreProjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        // Handle image upload using service
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->imageService->upload($request->file('image'), 'projects');
        } elseif (!empty($validated['image_url_input'])) {
            $imagePath = $validated['image_url_input'];
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

        return redirect()->route('admin.projects.index')->with('success', __('Project created successfully.'));
    }

    /**
     * Display the specified project.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\View\View
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\View\View
     */
    public function edit(Project $project)
    {
        $skills = \App\Models\Skill::all();
        return view('admin.projects.edit', compact('project', 'skills'));
    }

    /**
     * Update the specified project in the database.
     *
     * @param \App\Http\Requests\UpdateProjectRequest $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();

        // Handle image upload using service
        if ($request->hasFile('image')) {
            $imagePath = $this->imageService->upload(
                $request->file('image'), 
                'projects',
                $project->image_url
            );
        } elseif (!empty($validated['image_url_input'])) {
            $imagePath = $validated['image_url_input'];
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

        return redirect()->route('admin.projects.index')->with('success', __('Project updated successfully.'));
    }

    /**
     * Remove the specified project from the database.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        // Delete associated image
        if ($project->image_url) {
            $this->imageService->delete($project->image_url);
        }

        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', __('Project deleted successfully.'));
    }
}
