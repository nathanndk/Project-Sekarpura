<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
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

// Landing page
Route::get('/', [EventController::class, 'index'])->name('dashboard');


// Event
Route::get('/events', [EventController::class, 'index'])->name('events.index');

Route::post('/events/create', [EventController::class, 'store'])->name('events.store');

Route::put('/events/{event}/edit', [EventController::class, 'update'])->name('events.update');

Route::delete('/delete/{event}', [EventController::class, 'destroy'])->name('events.destroy');

Route::put('/drag-event', [EventController::class, 'dragEvent'])->name('events.drag');


// Attachment
Route::post('/attachments', [AttachmentController::class, 'store'])->name('attachments.store');

Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');


// Forum
Route::get('/threads', [ThreadController::class, 'index'])->middleware(['auth'])->name('forum');

Route::resource('threads', ThreadController::class)->except(['index', 'create'])->middleware(['auth']);

Route::resource('threads', ThreadController::class)->only(['show']);

Route::get('/submit-thread', [ThreadController::class, 'getCategory'])->name('threads.category');


// Category
Route::get('/categories-sorting', [ThreadCategoryController::class, 'CategorySorting'])->name('categories.sorting');

Route::get('/threads-sorting', [ThreadCategoryController::class, 'search'])->name('threads.sorting');

Route::post('/categories/search', [ThreadCategoryController::class, 'search'])->name('thread-categories.search');


// Comment
Route::resource('threads.comments', CommentController::class)->only(['store'])->middleware(['auth', 'AnggotaPengurus']);


// User
Route::resource('users', UserController::class)->only(['show', 'edit', 'update'])->middleware(['auth']);

Route::get('profile', [UserController::class, 'profile'])->name('profile')->middleware(['auth']);


// Like/unlike
Route::post('threads/{thread}/like', [ThreadUserController::class, 'store'])->name('threads.like')->middleware(['auth', 'AnggotaPengurus']);

Route::post('threads/{thread}/unlike', [ThreadUserController::class, 'delete'])->name('threads.unlike')->middleware(['auth', 'AnggotaPengurus']);

// Notification
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications')->middleware(['auth']);

Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show')->middleware(['auth']);

Route::put('/notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update')->middleware(['auth']);

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
