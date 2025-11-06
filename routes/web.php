<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthAdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DonationCampaignController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PaymentGatewayController;
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
  
  // Question management routes
  Route::post('lessons/{lesson}/questions', [LessonController::class, 'storeQuestion'])->name('lessons.questions.store');
  Route::put('questions/{question}', [LessonController::class, 'updateQuestion'])->name('questions.update');
  Route::delete('questions/{question}', [LessonController::class, 'destroyQuestion'])->name('questions.destroy');
  
  // Question option management routes
  Route::post('questions/{question}/options', [LessonController::class, 'storeOption'])->name('questions.options.store');
  Route::put('options/{option}', [LessonController::class, 'updateOption'])->name('options.update');
  Route::delete('options/{option}', [LessonController::class, 'destroyOption'])->name('options.destroy');
  Route::patch('options/{option}/correct', [LessonController::class, 'setCorrectOption'])->name('options.correct');
  
  // Donation Campaign routes
  Route::get('donation-campaigns/search', [DonationCampaignController::class, 'search'])->name('donation-campaigns.search');
  Route::resource('donation-campaigns', DonationCampaignController::class);
  
  // Payment Gateway routes
  Route::get('payment-gateways/search', [PaymentGatewayController::class, 'search'])->name('payment-gateways.search');
  Route::post('payment-gateways/{paymentGateway}/test-connection', [PaymentGatewayController::class, 'testConnection'])->name('payment-gateways.test-connection');
  Route::resource('payment-gateways', PaymentGatewayController::class);
});
