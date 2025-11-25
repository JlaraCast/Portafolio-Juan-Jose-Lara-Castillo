<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of all skills.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $skills = Skill::all();
        return view('admin.skills.index', compact('skills'));
    }

    /**
     * Show the form for creating a new skill.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.skills.create');
    }

    /**
     * Store a newly created skill in the database.
     *
     * @param \App\Http\Requests\StoreSkillRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreSkillRequest $request)
    {
        Skill::create($request->validated());
        return redirect()->route('admin.skills.index')->with('success', __('Skill created successfully.'));
    }

    public function show(Skill $skill)
    {
        return view('admin.skills.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified skill.
     *
     * @param \App\Models\Skill $skill
     * @return \Illuminate\View\View
     */
    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    /**
     * Update the specified skill in the database.
     *
     * @param \App\Http\Requests\UpdateSkillRequest $request
     * @param \App\Models\Skill $skill
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        $skill->update($request->validated());
        return redirect()->route('admin.skills.index')->with('success', __('Skill updated successfully.'));
    }

    /**
     * Remove the specified skill from the database.
     *
     * @param \App\Models\Skill $skill
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')->with('success', __('Skill deleted successfully.'));
    }
}
