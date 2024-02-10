<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ThreadCategoryController;

// Approval
Route::get('/approval', [DashboardController::class, 'index'])->name('admin.approval')->middleware(['auth', 'Admin']);


// Show all user
Route::get('/users', [RoleController::class, 'users'])->name('admin.users')->middleware(['auth', 'Admin']);


// Update User Role
Route::get('/manage-role', [RoleController::class, 'manageRole'])->name('manageRole')->middleware(['auth', 'Admin']);

Route::post('/update-role', [RoleController::class, 'updateRole'])->name('updateRole')->middleware(['auth', 'Admin']);


//Thread approval
Route::put('threads/{thread}/approve', [DashboardController::class, 'approve'])->name('threads.approve')->middleware(['auth', 'Admin']);

Route::put('threads/{thread}/reject', [DashboardController::class, 'reject'])->name('threads.reject')->middleware(['auth', 'Admin']);

// Clustering
Route::get('/cluster', [ThreadCategoryController::class, 'index'])->name('cluster');

Route::resource('categories', ThreadCategoryController::class)->except(['index', 'create'])->middleware(['auth', 'Admin']);

// Route::get('/categories/edit', [ThreadCategoryController::class, 'getCategoriesEdit'])->name('categories.edit')->middleware(['auth']);


