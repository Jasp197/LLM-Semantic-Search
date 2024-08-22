<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'home']);
Route::get('/search', [HomeController::class, 'search']);
Route::get('/feedback_search', [HomeController::class, 'feedbackSearch']);
