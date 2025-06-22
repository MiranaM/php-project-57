<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('task_statuses', TaskStatusController::class)
    ->except(['show']); // гости смогут видеть только index

Route::resource('labels', LabelController::class)
    ->except(['show']); // гости смогут видеть только index
    
Route::resource('tasks', TaskController::class);

require __DIR__.'/auth.php';