<?php

use App\Http\Controllers\ImageController;
use App\Livewire\PhotoEditor;
use Illuminate\Support\Facades\Route;




// Route::get('/', [ImageController::class, 'index'])->name('home');



// // Route::post('/generate-image', [ImageController::class, 'generateImage'])->name('generate');
// Route::post('/', [ImageController::class, 'saveImage'])->name('save.image');


Route::get('/', [ImageController::class, 'index'])->name('home');
Route::get('/gallery', [ImageController::class, 'showGallery'])->name('gallery');
Route::post('/save-image', [ImageController::class, 'saveImage'])->name('save.image');