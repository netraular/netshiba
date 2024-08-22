<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;

Auth::routes();

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create')->middleware('auth');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store')->middleware('auth');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit')->middleware('auth');
Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update')->middleware('auth');

Route::get('/projects/{project}/notes/create', [NoteController::class, 'create'])->name('notes.create')->middleware('auth');
Route::post('/projects/{project}/notes', [NoteController::class, 'store'])->name('notes.store')->middleware('auth');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware('auth');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store')->middleware('auth');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('auth');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware('auth');

Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/tags/create', [TagController::class, 'create'])->name('tags.create')->middleware('auth');
Route::post('/tags', [TagController::class, 'store'])->name('tags.store')->middleware('auth');
Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit')->middleware('auth');
Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update')->middleware('auth');

Route::get('/', function () {    return view('landingPage'); });
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
