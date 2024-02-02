<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ThreadUserController;
use App\Http\Controllers\UserController;



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

Route::resource('threads', ThreadController::class)->except(['index', 'create'])->middleware(['auth', 'AnggotaPengurus']);

Route::resource('threads', ThreadController::class)->only(['show']);

// Route::post('/threads', [ThreadController::class, 'storeExternal'])->name('external');

Route::resource('threads.comments', CommentController::class)->only(['store'])->middleware(['auth', 'AnggotaPengurus']);

Route::resource('users', UserController::class)->only(['show', 'edit', 'update'])->middleware(['auth']);

Route::get('profile', [UserController::class, 'profile'])->name('profile')->middleware(['auth']);

Route::post('threads/{thread}/like', [ThreadUserController::class, 'store'])->name('threads.like')->middleware(['auth', 'AnggotaPengurus']);

Route::post('threads/{thread}/unlike', [ThreadUserController::class, 'delete'])->name('threads.unlike')->middleware(['auth', 'AnggotaPengurus']);

Route::get('/terms', function () {
    return view('forum.shared.terms');
})->name('terms');

Route::middleware(['auth', 'AnggotaPengurus'])->group(function () {
    Route::get('/submit_thread', function () {
        return view('threads.shared.submit_thread');
    });
});


// ********** Anggota Routes *********

// ********** Pengurus Routes *********

// ********** Admin Routes *********
