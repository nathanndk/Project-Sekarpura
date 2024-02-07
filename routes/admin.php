<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ThreadCategoryController;
use App\Http\Controllers\ThreadController;

//tampilkan dashboard admin
Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'Admin']);

//tampilkan semua user
Route::get('/users', [RoleController::class, 'users'])->name('admin.users')->middleware(['auth', 'Admin']);

//update role user
Route::get('/manage-role', [RoleController::class, 'manageRole'])->name('manageRole')->middleware(['auth', 'Admin']);

Route::post('/update-role', [RoleController::class, 'updateRole'])->name('updateRole')->middleware(['auth', 'Admin']);

//tampilkan semua thread yang perlu di approve
// Route::get('/approval', [ThreadController::class, 'loadApproval'])->name('approval')->middleware(['auth', 'Admin']);

//approve thread
Route::put('threads/{thread}/approve', [DashboardController::class, 'approve'])->name('threads.approve')->middleware(['auth', 'Admin']);

//reject thread
Route::put('threads/{thread}/reject', [DashboardController::class, 'reject'])->name('threads.reject')->middleware(['auth', 'Admin']);

Route::get('/category', [ThreadCategoryController::class, 'index'])->name('cluster');

Route::resource('category', ThreadCategoryController::class)->except(['index', 'create'])->middleware(['auth', 'Admin']);

// Route::get('/cluster', [ThreadCategoryController::class, 'index'])->name('admin.cluster')->middleware(['auth', 'Admin']);


