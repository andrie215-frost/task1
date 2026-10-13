<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\JobFeedController;
use App\Http\Controllers\Admin\AdminJobPostController;
use App\Http\Controllers\Admin\AdminFindingOptionController;
use App\Http\Controllers\Admin\AdminSkillController;
use App\Http\Controllers\ContactController;


Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');


Route::middleware('guest')->group(function () {

    Route::get(
        '/register',
        [AuthController::class, 'showRegister']
    )->name('register');


    Route::post(
        '/register',
        [AuthController::class, 'register']
    )->name('register.store');


    Route::get(
        '/login',
        [AuthController::class, 'showLogin']
    )->name('login');


    Route::post(
        '/login',
        [AuthController::class, 'login']
    )->name('login.store');

});



Route::middleware([
    'auth',
    'prevent-back-history',
])->group(function () {


    Route::post(
        '/jobs/{jobPost}/contact',
        [ContactController::class, 'sendToCompany']
    )->name('jobs.contact');


    Route::post(
        '/people/{user}/contact',
        [ContactController::class, 'sendToSkilledPerson']
    )->name('people.contact');


    Route::get(
        '/jobs',
        [JobFeedController::class, 'index']
    )->name('jobs.index');


    Route::get(
        '/jobs/{jobPost}',
        [JobFeedController::class, 'show']
    )->name('jobs.show');


    Route::get(
        '/job-posts',
        [JobPostController::class, 'index']
    )->name('job-posts.index');


    Route::get(
        '/job-posts/create',
        [JobPostController::class, 'create']
    )->name('job-posts.create');


    Route::post(
        '/job-posts',
        [JobPostController::class, 'store']
    )->name('job-posts.store');


    Route::get(
        '/job-posts/{jobPost}/edit',
        [JobPostController::class, 'edit']
    )->name('job-posts.edit');


    Route::patch(
        '/job-posts/{jobPost}',
        [JobPostController::class, 'update']
    )->name('job-posts.update');


    Route::delete(
        '/job-posts/{jobPost}',
        [JobPostController::class, 'destroy']
    )->name('job-posts.destroy');



    Route::get(
        '/account',
        [AccountController::class, 'edit']
    )->name('account.edit');


    Route::patch(
        '/account/profile-image',
        [AccountController::class, 'updateProfileImage']
    )->name('account.profile-image.update');


    Route::patch(
        '/account/email',
        [AccountController::class, 'updateEmail']
    )->name('account.email.update');


    Route::patch(
        '/account/password',
        [AccountController::class, 'updatePassword']
    )->name('account.password.update');



    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    Route::get(
        '/matches',
        [MatchController::class, 'index']
    )->name('matches.index');


    Route::post(
        '/matches/find',
        [MatchController::class, 'find']
    )->name('matches.find');


    Route::get(
        '/profile',
        [ProfileController::class, 'show']
    )->name('profile.show');


    Route::get(
        '/profile/edit',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    Route::get(
        '/people/{user}',
        [ProfileController::class, 'showSkilledPerson']
    )->name('people.show');


    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    )->name('logout');

});



Route::middleware([
    'auth',
    'admin',
    'prevent-back-history',
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


        Route::get(
            '/dashboard',
            [AdminDashboardController::class, 'index']
        )->name('dashboard');



        /*
        |--------------------------------------------------------------------------
        | USER MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/users',
            [AdminUserController::class, 'index']
        )->name('users.index');


        Route::get(
            '/users/{user}',
            [AdminUserController::class, 'show']
        )->name('users.show');


        Route::delete(
            '/users/{user}',
            [AdminUserController::class, 'destroy']
        )->name('users.destroy');



        /*
        |--------------------------------------------------------------------------
        | JOB POST MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/job-posts',
            [AdminJobPostController::class, 'index']
        )->name('job-posts.index');


        Route::get(
            '/job-posts/{jobPost}',
            [AdminJobPostController::class, 'show']
        )->name('job-posts.show');


        Route::delete(
            '/job-posts/{jobPost}',
            [AdminJobPostController::class, 'destroy']
        )->name('job-posts.destroy');



        /*
        |--------------------------------------------------------------------------
        | SKILLS MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/skills',
            [AdminSkillController::class, 'index']
        )->name('skills.index');


        Route::post(
            '/skills',
            [AdminSkillController::class, 'store']
        )->name('skills.store');


        Route::patch(
            '/skills/{skill}',
            [AdminSkillController::class, 'update']
        )->name('skills.update');


        Route::delete(
            '/skills/{skill}',
            [AdminSkillController::class, 'destroy']
        )->name('skills.destroy');



        /*
        |--------------------------------------------------------------------------
        | FINDING FORM OPTIONS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/finding-options',
            [AdminFindingOptionController::class, 'index']
        )->name('finding-options.index');


        Route::post(
            '/finding-options',
            [AdminFindingOptionController::class, 'store']
        )->name('finding-options.store');


        Route::patch(
            '/finding-options/{findingOption}',
            [AdminFindingOptionController::class, 'update']
        )->name('finding-options.update');


        Route::delete(
            '/finding-options/{findingOption}',
            [AdminFindingOptionController::class, 'destroy']
        )->name('finding-options.destroy');

    });