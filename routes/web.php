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
use App\Http\Controllers\DonationTagController;
use App\Http\Controllers\DonationReportController;
use App\Http\Controllers\ChunkedUploadController;
use App\Http\Controllers\Admin\CommunityWhatsappGroupController;
use App\Http\Controllers\Admin\CommunityPostController;
use App\Http\Controllers\Admin\VolunteerRegistrationController;
use App\Http\Controllers\Admin\VolunteerEventController;
use App\Http\Controllers\Admin\MentorProfileController;
use App\Http\Controllers\Member\Auth\LoginController as MemberLoginController;
use App\Http\Controllers\Member\Auth\RegisterController as MemberRegisterController;
use App\Http\Controllers\Member\Auth\GoogleController as MemberGoogleController;
use App\Http\Controllers\Member\Auth\EmailVerificationController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Member\LessonProgressController;
use App\Http\Controllers\Member\DonateController;
use App\Http\Controllers\Member\PaymentCallbackController;
use App\Http\Controllers\Member\OnboardingController;
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
  return redirect()->route('auth.login');
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

  // Chunked upload route
  Route::post('upload/chunked', [ChunkedUploadController::class, 'upload'])->name('upload.chunked');

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
  Route::post('donation-campaigns/{donationCampaign}/upload-images', [DonationCampaignController::class, 'uploadImages'])->name('donation-campaigns.upload-images');
  Route::delete('donation-campaigns/{donationCampaign}/delete-image', [DonationCampaignController::class, 'deleteImage'])->name('donation-campaigns.delete-image');
  Route::post('donation-campaigns/{donationCampaign}/set-primary-image', [DonationCampaignController::class, 'setPrimaryImage'])->name('donation-campaigns.set-primary-image');
  Route::post('donation-campaigns/{donationCampaign}/update-tags', [DonationCampaignController::class, 'updateTags'])->name('donation-campaigns.update-tags');
  Route::delete('donation-campaigns/{donationCampaign}/remove-tag', [DonationCampaignController::class, 'removeTag'])->name('donation-campaigns.remove-tag');
  Route::resource('donation-campaigns', DonationCampaignController::class);

  // Payment Gateway routes
  Route::get('payment-gateways/search', [PaymentGatewayController::class, 'search'])->name('payment-gateways.search');
  Route::post('payment-gateways/{paymentGateway}/test-connection', [PaymentGatewayController::class, 'testConnection'])->name('payment-gateways.test-connection');
  Route::resource('payment-gateways', PaymentGatewayController::class);

  // Donation Tag routes
  Route::get('donation-tags/search', [DonationTagController::class, 'search'])->name('donation-tags.search');
  Route::resource('donation-tags', DonationTagController::class);

  // Donation Report routes
  Route::get('donation-reports/search', [DonationReportController::class, 'search'])->name('donation-reports.search');
  Route::post('donation-reports/{donationReport}/verify', [DonationReportController::class, 'verify'])->name('donation-reports.verify');
  Route::post('donation-reports/{donationReport}/reject', [DonationReportController::class, 'reject'])->name('donation-reports.reject');

  // Zakat Settings routes
  Route::resource('zakat-settings', \App\Http\Controllers\Admin\ZakatSettingController::class)->only(['index', 'edit', 'update']);

  // Currency Settings routes
  Route::resource('currency-settings', \App\Http\Controllers\Admin\CurrencySettingController::class)->only(['index', 'edit', 'update']);
  Route::post('donation-reports/{donationReport}/upload-images', [DonationReportController::class, 'uploadImages'])->name('donation-reports.upload-images');
  Route::delete('donation-reports/{donationReport}/images/{image}', [DonationReportController::class, 'deleteImage'])->name('donation-reports.delete-image');
  Route::post('donation-reports/{donationReport}/images/{image}/set-primary', [DonationReportController::class, 'setPrimaryImage'])->name('donation-reports.set-primary-image');
  Route::resource('donation-reports', DonationReportController::class);

  // Community & Volunteer routes
  Route::resource('community/whatsapp-groups', CommunityWhatsappGroupController::class)->names('community.whatsapp-groups');
  Route::resource('community/posts', CommunityPostController::class)->names('community.posts');
  Route::resource('community/volunteer-registrations', VolunteerRegistrationController::class)->names('community.volunteer-registrations');
  Route::resource('community/volunteer-events', VolunteerEventController::class)->names('community.volunteer-events');
  Route::resource('community/mentors', MentorProfileController::class)->names('community.mentors');

  Route::get('logout', [AuthAdminController::class, 'logout'])->name('logout');
});

// Member Onboarding Routes (authenticated but no verification required)
Route::group(['middleware' => 'auth:member'], function () {
  Route::prefix('onboarding')->name('onboarding.')->group(function () {
    Route::get('/step1', [OnboardingController::class, 'step1'])->name('step1');
    Route::post('/step1', [OnboardingController::class, 'storeStep1'])->name('step1.store');
    Route::get('/step2', [OnboardingController::class, 'step2'])->name('step2');
    Route::post('/step2', [OnboardingController::class, 'storeStep2'])->name('step2.store');
    Route::get('/step3', [OnboardingController::class, 'step3'])->name('step3');
    Route::post('/step3', [OnboardingController::class, 'storeStep3'])->name('step3.store');
    Route::get('/step4', [OnboardingController::class, 'step4'])->name('step4');
    Route::post('/step4', [OnboardingController::class, 'storeStep4'])->name('step4.store');
    Route::get('/step5', [OnboardingController::class, 'step5'])->name('step5');
    Route::post('/complete', [OnboardingController::class, 'complete'])->name('complete');
  });
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

  // E-Course routes
  Route::prefix('courses')->name('member.courses.')->group(function () {
    Route::get('/', [LessonProgressController::class, 'index'])->name('index');
    Route::get('/progress', [LessonProgressController::class, 'getProgress'])->name('progress');
    Route::post('/{class}/join', [LessonProgressController::class, 'enroll'])->name('join');
    Route::get('/{class}', [LessonProgressController::class, 'show'])->name('show');
    Route::get('/{class}/{module}/{lesson}', [LessonProgressController::class, 'showLesson'])->name('lesson');
    Route::post('/{class}/{module}/{lesson}/complete', [LessonProgressController::class, 'completeLesson'])->name('lesson.complete');
  });

  // Member donate page
  Route::prefix('donate')->name('member.donate.')->group(function () {
    Route::get('/', [DonateController::class, 'index'])->name('index');
    Route::get('/api/campaigns', [DonateController::class, 'apiCampaigns'])->name('api.campaigns');
    Route::get('/history', [DonateController::class, 'history'])->name('history');
    Route::get('/{campaign}', [DonateController::class, 'show'])->name('show');
    Route::get('/{campaign}/checkout', [DonateController::class, 'checkout'])->name('checkout');
    Route::post('/{campaign}', [DonateController::class, 'store'])->name('store');
  });

  // Member zakat calculator and payment
  Route::prefix('zakat')->name('member.zakat.')->group(function () {
    Route::get('/calculator', [\App\Http\Controllers\Member\ZakatCalculatorController::class, 'index'])->name('calculator');
    Route::get('/checkout', [\App\Http\Controllers\Member\ZakatPaymentController::class, 'checkout'])->name('checkout');
    Route::post('/process', [\App\Http\Controllers\Member\ZakatPaymentController::class, 'process'])->name('process');
  });

  Route::get('logout', [MemberLoginController::class, 'logout'])->name('logout');
});

// Payment Webhooks (no auth required)
Route::prefix('payment/callback')->name('payment.callback.')->group(function () {
  // Midtrans
  Route::post('midtrans/webhook', [PaymentCallbackController::class, 'midtransWebhook'])->name('midtrans.webhook');
  Route::get('midtrans/webhook-test', [PaymentCallbackController::class, 'midtransWebhook'])->name('midtrans.webhook.test'); // For testing
  Route::get('midtrans/finish', [PaymentCallbackController::class, 'midtransFinish'])->name('midtrans.finish');

  // Stripe
  Route::post('stripe/webhook', [PaymentCallbackController::class, 'stripeWebhook'])->name('stripe.webhook');
  Route::get('stripe/success', [PaymentCallbackController::class, 'stripeSuccess'])->name('stripe.success');
  Route::get('stripe/cancel', [PaymentCallbackController::class, 'stripeCancel'])->name('stripe.cancel');

  // Toss
  Route::post('toss/webhook', [PaymentCallbackController::class, 'tossWebhook'])->name('toss.webhook');
  Route::get('toss/success', [PaymentCallbackController::class, 'tossSuccess'])->name('toss.success');
  Route::get('toss/fail', [PaymentCallbackController::class, 'tossFail'])->name('toss.fail');
});
