<?php

use App\Http\Controllers\Pengurus\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/pengurus', [DashboardController::class, 'dashboard'])->name('pengurus.dashboard')->middleware(['auth', 'isPengurus']);;
