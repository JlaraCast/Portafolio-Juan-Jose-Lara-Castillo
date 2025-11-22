<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = \App\Models\User::first();
        $projects = \App\Models\Project::with('skills')->get();
        $skills = \App\Models\Skill::all();
        $experiences = \App\Models\Experience::with('skills')->get();
        return view('home', compact('user', 'projects', 'skills', 'experiences'));
    }
}
