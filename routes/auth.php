<?php

use App\Http\Controllers\Auth\AccountDetailsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\InPersonVerificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UserDetailsController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\PlansController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController as AdminConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController as AdminEmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController as AdminEmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController as AdminNewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController as AdminPasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController as AdminRegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController as AdminVerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserCompanyController;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::post('ajax-verify-password', [RegisteredUserController::class, 'ajaxVerifyPassword'])->name('ajax-verify-password');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
});

Route::middleware(['auth', 'is_not_admin'])->group(function () {

    Route::get('verify-otp', [OtpVerificationController::class, 'create'])->name('verify.otp')->middleware('register_routes_prevention');

    Route::post('verify-otp', [OtpVerificationController::class, 'store']);

    Route::post('resend-otp', [OtpVerificationController::class, 'resendOtp'])->name('resend.otp');

    Route::get('user-details', [UserDetailsController::class, 'create'])->name('details.user')->middleware('register_routes_prevention');

    Route::post('user-details', [UserDetailsController::class, 'store']);

    Route::get('verify-in-person', [InPersonVerificationController::class, 'create'])->name('verify.in-person');

    Route::post('verify-in-person', [InPersonVerificationController::class, 'store']);
    
    Route::post('verify-in-person-photo', [InPersonVerificationController::class, 'storeIpvPhoto'])->name('store.ipv-photo');

    Route::get('user-ipv-screen', [InPersonVerificationController::class, 'userIpvScreen'])->name('user.ipv-screen');

    Route::post('ajax-generate-random-code', [InPersonVerificationController::class, 'ajaxGenerateRandomCode'])->name('ajax-generate-random-code');

    Route::get('user-congratulations', [UserCompanyController::class, 'UserCongratulationsPage'])->name('user.congratulations');
    
    Route::get('user-company-account', [UserCompanyController::class, 'create'])->name('user.company-account');

    Route::post('user-company-account', [UserCompanyController::class, 'store'])->name('user.store-company-account');

  /*   Route::get('account-details', [AccountDetailsController::class, 'create'])->name('details.account');

    Route::post('account-details', [AccountDetailsController::class, 'store']); */

    Route::get('user-plans', [PlansController::class, 'create'])->name('user.plans');

    Route::post('user-plans', [PlansController::class, 'store']);


    Route::get('landing', [AccountDetailsController::class, 'landing'])->name('landing');

    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});

Route::prefix('/myplatform-admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('register', [AdminRegisteredUserController::class, 'create'])
            ->name('register');

        Route::post('register', [AdminRegisteredUserController::class, 'store']);

        Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('login', [AdminAuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [AdminPasswordResetLinkController::class, 'create'])
            ->name('password.request');

        Route::post('forgot-password', [AdminPasswordResetLinkController::class, 'store'])
            ->name('password.email');

        Route::get('reset-password/{token}', [AdminNewPasswordController::class, 'create'])
            ->name('password.reset');

        Route::post('reset-password', [AdminNewPasswordController::class, 'store'])
            ->name('password.update');
    });

    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('verify-email', [AdminEmailVerificationPromptController::class, '__invoke'])
            ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', [AdminVerifyEmailController::class, '__invoke'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('email/verification-notification', [AdminEmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::get('confirm-password', [AdminConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

        Route::post('confirm-password', [AdminConfirmablePasswordController::class, 'store']);

        Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });
});
