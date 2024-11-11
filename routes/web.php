<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/summarize', [StatisticController::class, 'check'])->name('check');
