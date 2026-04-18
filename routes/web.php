<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route for homepage
Route::view('/', 'welcome')
    ->name('home');
// Route for personal dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
// Route for personal settings area
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
// Route for new project blade
Route::view('/new-project', 'new-project')
    ->middleware(['auth', 'verified'])
    ->name('new-project');
//  Route for view personal projects blade
Route::view('/view-projects', 'view-projects')
    ->middleware(['auth', 'verified'])
    ->name('view-projects');
//  Route for viewing all user projects
Route::view('/search-project', 'search-project')
    ->middleware(['auth', 'verified'])
    ->name('search-project');
// Route for aboutus page
Route::view('aboutus', 'aboutus')
    ->name('aboutus');    
// Route for repository
Route::view('repository', 'repository')
    ->name('repository');
require __DIR__.'/auth.php';
