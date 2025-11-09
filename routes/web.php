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
use App\Http\Controllers\Member\Auth\LoginController as MemberLoginController;
use App\Http\Controllers\Member\Auth\RegisterController as MemberRegisterController;
use App\Http\Controllers\Member\Auth\GoogleController as MemberGoogleController;
use App\Http\Controllers\Member\Auth\EmailVerificationController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
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
  Route::group(['middleware' => 'guest', 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::get('login', [AuthAdminController::class, 'login'])->name('login');
    Route::post('login', [AuthAdminController::class, 'authenticate'])->name('authenticate');
  });

  Route::get('login', [MemberLoginController::class, 'index'])->name('login');
  Route::post('login', [MemberLoginController::class, 'login'])->name('login.submit');
  Route::get('register', [MemberRegisterController::class, 'showRegistrationForm'])->name('register');
  Route::post('register', [MemberRegisterController::class, 'register'])->name('register.submit');

  // Email Verification Routes
  Route::get('email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
  Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
  Route::post('email/verification-notification', [EmailVerificationController::class, 'resend'])->name('verification.send');

  // Google OAuth routes
  Route::get('google', [MemberGoogleController::class, 'redirectToGoogle'])->name('google.redirect');
  Route::get('google/callback', [MemberGoogleController::class, 'handleGoogleCallback'])->name('google.callback');
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

  Route::get('logout', [AuthAdminController::class, 'logout'])->name('logout');
});

// Member Authentication Routes
Route::group(['middleware' => ['auth:member', 'member.verified']], function () {
  Route::get('dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');

  // Profile routes
  Route::get('profile', [MemberProfileController::class, 'show'])->name('profile.show');
  Route::get('profile/edit', [MemberProfileController::class, 'edit'])->name('profile.edit');
  Route::put('profile', [MemberProfileController::class, 'update'])->name('profile.update');
  Route::get('profile/change-password', [MemberProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
  Route::put('profile/change-password', [MemberProfileController::class, 'updatePassword'])->name('profile.update-password');

  Route::get('logout', [MemberLoginController::class, 'logout'])->name('logout');
});
