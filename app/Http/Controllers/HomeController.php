<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use App\Services\ImageUploadService;

class HomeController extends Controller
{
    public function __construct(protected ImageUploadService $imageService) {}

    public function index()
    {
        $user = User::first();
        $projects = Project::with('skills')->get();
        $skills = Skill::all();
        $experiences = Experience::with('skills')->get();
        $imageService = $this->imageService;

        return view('home', compact('user', 'projects', 'skills', 'experiences', 'imageService'));
    }
}
