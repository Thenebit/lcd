<?php

use App\Http\Controllers\SlideshowController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SlideshowController::class, 'index'])->name('slideshow.index');

Route::get('/slideshow-data', [SlideshowController::class, 'getData'])->name('slideshow.data');

