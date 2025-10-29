<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthAdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('', function () {
  return redirect()->route('auth.admin.login');
});

Route::get('language/{locale}', LanguageController::class)->name('language.change');

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
  Route::get('admin/login', [AuthAdminController::class, 'login'])->middleware('admin.guest')->name('admin.login');
  Route::post('admin/login', [AuthAdminController::class, 'authenticate'])->middleware('admin.guest')->name('admin.authenticate');
  Route::get('admin/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
  Route::get('', HomeController::class)->name('home');
  Route::get('users/search', [UserController::class, 'search'])->name('users.search');
  Route::resource('users', UserController::class);
  Route::get('categories/search', [CategoryController::class, 'search'])->name('categories.search');
  Route::resource('categories', CategoryController::class);
  Route::get('classes/search', [ClassController::class, 'search'])->name('classes.search');
  Route::resource('classes', ClassController::class);
  Route::get('modules/search', [ModuleController::class, 'search'])->name('modules.search');
  Route::resource('modules', ModuleController::class);
  Route::get('lessons/search', [LessonController::class, 'search'])->name('lessons.search');
  Route::resource('lessons', LessonController::class);
});
