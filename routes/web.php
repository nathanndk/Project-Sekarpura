<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ThreadUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThreadCategoryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Before login dashboard
Route::get('/', [EventController::class, 'dashboard'])->name('dashboard');

// Dashboard Admin
Route::get('/dashboard', [EventController::class, 'dashboard'])->name('dashboard');

// Create Event
Route::post('/create-event', [EventController::class, 'createEvent']);

// Update Event
Route::put('/update-event', [EventController::class, 'updateEvent']);

// Delete Event
Route::delete('/delete-event/{id}', [EventController::class, 'deleteEvent']);

// Drag Event
Route::put('/drag-event', [EventController::class, 'dragEvent']);

// Delete Attachment
Route::delete('/delete-attachment/{id}', [AttachmentController::class, 'deleteAttachment']);

// Add Attachment
Route::post('/upload-attachment', [AttachmentController::class, 'uploadAttachment']);

//menampilkan forum
Route::get('/forum', [ThreadController::class, 'index'])->name('forum');

// Route::group(['prefix' => 'threads', 'as' => 'threads.', 'middleware' => ['auth']], function () {

//     Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('show');

//     Route::group(['middleware' => ['auth']], function () {

//         Route::post('', [ThreadController::class, 'store'])->name('store');

//         Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('edit');

//         Route::put('/threads/{thread}/edit', [ThreadController::class, 'update'])->name('update');

//         Route::delete('/{thread}', [ThreadController::class, 'destroy'])->name('destroy');

//         Route::post('/{thread}/comments', [CommentController::class, 'store'])->name('comments.store');
//     });
// });

Route::resource('threads', ThreadController::class)->except(['index', 'create'])->middleware(['auth']);

Route::resource('threads', ThreadController::class)->only(['show']);

//kategori
Route::get('/kategori', [ThreadCategoryController::class, 'kategori'])->name('category');

Route::get('/searchThreads', [ThreadCategoryController::class, 'search'])->name('searchThreads');

Route::post('/thread-categories/search', [ThreadCategoryController::class, 'search'])->name('thread-categories.search');

//submit thread
Route::get('/submit_thread', [ThreadController::class, 'getCategory'])->name('threads.category');

//komen
Route::resource('threads.comments', CommentController::class)->only(['store'])->middleware(['auth', 'AnggotaPengurus']);

//user
Route::resource('users', UserController::class)->only(['show', 'edit', 'update'])->middleware(['auth']);

Route::get('profile', [UserController::class, 'profile'])->name('profile')->middleware(['auth']);

//like/unlike
Route::post('threads/{thread}/like', [ThreadUserController::class, 'store'])->name('threads.like')->middleware(['auth', 'AnggotaPengurus']);

Route::post('threads/{thread}/unlike', [ThreadUserController::class, 'delete'])->name('threads.unlike')->middleware(['auth', 'AnggotaPengurus']);

// Route::get('/terms', function () {
//     return view('forum.shared.terms');
// })->name('terms');

// Route::middleware(['auth', 'AnggotaPengurus'])->group(function () {
//     Route::get('/submit_thread', function () {
//         return view('threads.shared.submit_thread');
//     });
// });

// ********** Anggota Routes *********

// ********** Pengurus Routes *********

// ********** Admin Routes *********
