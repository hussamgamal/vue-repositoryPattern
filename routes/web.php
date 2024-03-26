<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FactoryController;
use App\Http\Controllers\FakerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('social-login', SocialLoginController::class);
Route::get('seeder/{type}', [FakerController::class, 'index'])
    ->whereIn('type', ['posts']);

Route::get('change-locale/{locale?}', [HomeController::class, 'changeLocale'])->name('change-locale');

Route::middleware('locale')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::middleware('auth')->group(function () {
        Route::resource('posts', PostController::class);
        Route::get('posts/{id}/like', [PostController::class, 'like'])->name('posts.like');
        Route::post('posts/{id}/comment', [CommentController::class, 'comment'])->name('posts.comment');
        Route::post('posts/{id}/delete_comments', [CommentController::class, 'delete_comments'])->name('posts.delete_comments');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__ . '/auth.php';
});
