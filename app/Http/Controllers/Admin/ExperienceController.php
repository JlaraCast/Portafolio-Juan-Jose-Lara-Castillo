<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::all();
        return view('admin.experiences.index', compact('experiences'));
    }

    public function create()
    {
        $skills = \App\Models\Skill::all();
        return view('admin.experiences.create', compact('skills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company.es' => 'required|string|max:255',
            'company.en' => 'required|string|max:255',
            'role.es' => 'required|string|max:255',
            'role.en' => 'required|string|max:255',
            'period.es' => 'required|string|max:255',
            'period.en' => 'required|string|max:255',
            'location.es' => 'required|string|max:255',
            'location.en' => 'required|string|max:255',
            'description.es' => 'required|string',
            'description.en' => 'required|string',
            'logo' => 'nullable|image|max:2048', // Max 2MB
            'type' => 'required|in:work,education',
            'skills' => 'nullable|array',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('experiences', 'public');
            $logoPath = '/storage/' . $path;
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

    public function edit(Experience $experience)
    {
        $skills = \App\Models\Skill::all();
        return view('admin.experiences.edit', compact('experience', 'skills'));
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'company.es' => 'required|string|max:255',
            'company.en' => 'required|string|max:255',
            'role.es' => 'required|string|max:255',
            'role.en' => 'required|string|max:255',
            'period.es' => 'required|string|max:255',
            'period.en' => 'required|string|max:255',
            'location.es' => 'required|string|max:255',
            'location.en' => 'required|string|max:255',
            'description.es' => 'required|string',
            'description.en' => 'required|string',
            'logo' => 'nullable|image|max:2048',
            'type' => 'required|in:work,education',
            'skills' => 'nullable|array',
        ]);

        $data = [
            'company' => $request->company,
            'role' => $request->role,
            'period' => $request->period,
            'location' => $request->location,
            'description' => $request->description,
            'type' => $request->type,
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('experiences', 'public');
            $data['logo'] = '/storage/' . $path;
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

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return redirect()->route('admin.experiences.index')->with('success', 'Experience deleted successfully.');
    }
}
