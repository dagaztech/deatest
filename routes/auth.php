<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\RegisteredAdminController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

Route::middleware(['guest', 'Setting', 'xss' ,'Upload'])->group(function () {
    Route::get('register/{lang?}', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::get('register-admin/{lang?}', [RegisteredAdminController::class, 'create'])
        ->name('register-admin');    

    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::post('register-admin', [RegisteredAdminController::class, 'store']);

    Route::get('login/{lang?}', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password/{lang?}', [PasswordResetLinkController::class, 'create'])->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}/{lang?}', [NewPasswordController::class, 'create'])->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');


});

Route::middleware(['auth'])->group(function () {
    Route::get('verify-email/{lang?}', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password/{lang?}', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    //Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
       // ->name('logout');
});
