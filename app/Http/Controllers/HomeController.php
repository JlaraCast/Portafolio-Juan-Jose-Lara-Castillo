<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::first();
        $projects = Project::with('skills')->get();
        $skills = Skill::all();
        $experiences = Experience::with('skills')->get();

        return view('home', compact('user', 'projects', 'skills', 'experiences'));
    }
}
