<?php

use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/google90b3b15fa7d9c06a.html', function () {
    return response('google-site-verification: google90b3b15fa7d9c06a.html', 200)
        ->header('Content-Type', 'text/html');
});

Route::middleware('throttle:10,1')->group(function () {
    Auth::routes(['register' => false]);
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('projects', ProjectController::class);
    Route::resource('skills', SkillController::class);
    Route::resource('experiences', ExperienceController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/test-migrate', function () {
    Artisan::call('migrate', ['--force' => true]);

    return 'Migrations run successfully';
});
