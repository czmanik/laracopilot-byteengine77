<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PageController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/mista', [PlaceController::class, 'index'])->name('places.index');
Route::get('/mista/{slug}', [PlaceController::class, 'show'])->name('places.show');
Route::get('/program', [ProgramController::class, 'index'])->name('program.index');
Route::get('/o-nas', [PageController::class, 'about'])->name('about');
Route::get('/kontakt', [PageController::class, 'contact'])->name('contact');
Route::post('/kontakt', [PageController::class, 'contactSend'])->name('contact.send');