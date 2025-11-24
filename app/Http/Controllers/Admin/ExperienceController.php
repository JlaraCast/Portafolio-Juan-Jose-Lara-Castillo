<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Models\Experience;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Constructor to inject ImageUploadService.
     */
    public function __construct(
        protected ImageUploadService $imageService
    ) {}

    /**
     * Display a listing of all experiences.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $experiences = Experience::all();
        return view('admin.experiences.index', compact('experiences'));
    }

    /**
     * Show the form for creating a new experience.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $skills = \App\Models\Skill::all();
        return view('admin.experiences.create', compact('skills'));
    }

    /**
     * Store a newly created experience in the database.
     *
     * @param \App\Http\Requests\StoreExperienceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreExperienceRequest $request)
    {
        $validated = $request->validated();

        // Handle logo upload using service
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $this->imageService->upload($request->file('logo'), 'experiences');
        }

        $experience = Experience::create([
            'company' => $request->company,
            'role' => $request->role,
            'period' => $request->period,
            'location' => $request->location,
            'description' => $request->description,
            'logo' => $logoPath,
            'type' => $request->type,
        ]);

        // Attach skills if provided
        if (!empty($validated['skills'])) {
            $experience->skills()->attach($validated['skills']);
        }

        return redirect()->route('admin.experiences.index')->with('success', 'Experience created successfully.');
    }

    /**
     * Show the form for editing the specified experience.
     *
     * @param \App\Models\Experience $experience
     * @return \Illuminate\View\View
     */
    public function edit(Experience $experience)
    {
        $skills = \App\Models\Skill::all();
        return view('admin.experiences.edit', compact('experience', 'skills'));
    }

    /**
     * Update the specified experience in the database.
     *
     * @param \App\Http\Requests\UpdateExperienceRequest $request
     * @param \App\Models\Experience $experience
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateExperienceRequest $request, Experience $experience)
    {
        $validated = $request->validated();

        $data = [
            'company' => $request->company,
            'role' => $request->role,
            'period' => $request->period,
            'location' => $request->location,
            'description' => $request->description,
            'type' => $request->type,
        ];

        // Handle logo upload using service
        if ($request->hasFile('logo')) {
            $data['logo'] = $this->imageService->upload(
                $request->file('logo'),
                'experiences',
                $experience->logo
            );
        }

        $experience->update($data);

        // Sync skills
        if (isset($validated['skills'])) {
            $experience->skills()->sync($validated['skills']);
        } else {
            $experience->skills()->detach();
        }

        return redirect()->route('admin.experiences.index')->with('success', 'Experience updated successfully.');
    }

    /**
     * Remove the specified experience from the database.
     *
     * @param \App\Models\Experience $experience
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Experience $experience)
    {
        // Delete associated logo
        if ($experience->logo) {
            $this->imageService->delete($experience->logo);
        }

        $experience->delete();
        return redirect()->route('admin.experiences.index')->with('success', 'Experience deleted successfully.');
    }
}
