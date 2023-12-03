<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\MedicalRecordsController;
use App\Http\Controllers\MedicinesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

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
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::middleware('admin')->group(function () {
        Route::resource('user-list', UsersController::class)->names([
            'index' => 'user-list',
            'create' => 'user-list.create',
            'store' => 'user-list.store',
            'show' => 'user-list.show',
            'edit' => 'user-list.edit',
            'update' => 'user-list.update',
            'destroy' => 'user-list.destroy',
        ]);
        Route::post('user-list', [UsersController::class, 'index'])->name('user-list.search');
        Route::resource('appointments', AppointmentsController::class)->names([
            'index' => 'appointments',
            'create' => 'appointments.create',
            'store' => 'appointments.store',
            'show' => 'appointments.show',
            'edit' => 'appointments.edit',
            'update' => 'appointments.update',
            'destroy' => 'appointments.destroy',
        ]);
    });

    Route::middleware('apoteker')->group(function () {
        Route::resource('medicines', MedicinesController::class)->names([
            'index' => 'medicines',
            'create' => 'medicines.create',
            'store' => 'medicines.store',
            'show' => 'medicines.show',
            'edit' => 'medicines.edit',
            'update' => 'medicines.update',
            'destroy' => 'medicines.destroy',
        ]);
        Route::post('medicines', [MedicinesController::class, 'index'])->name('medicines.search');
        Route::resource('orders', OrdersController::class)->names([
            'index' => 'orders',
            'create' => 'orders.create',
            'store' => 'orders.store',
            'show' => 'orders.show',
            'edit' => 'orders.edit',
            'update' => 'orders.update',
            'destroy' => 'orders.destroy',
        ]);
    });

    Route::middleware('dokter')->group(function () {
        Route::get('patient-list', [UsersController::class, 'index'])->name('patient-list');
        Route::post('patient-list', [UsersController::class, 'index'])->name('patient-list.search');
        // Route::get('patient-list/{id}', [UsersController::class, 'show'])->name('patient-list.show');
        Route::resource('medical-records', MedicalRecordsController::class)->names([
            'index' => 'medical-records',
            'create' => 'medical-records.create',
            'store' => 'medical-records.store',
            'show' => 'medical-records.show',
            'edit' => 'medical-records.edit',
            'update' => 'medical-records.update',
            'destroy' => 'medical-records.destroy',
        ]);
        Route::resource('doctor-appointments', AppointmentsController::class)->names([
            'index' => 'doctor-appointments',
            'create' => 'doctor-appointments.create',
            'store' => 'doctor-appointments.store',
            'show' => 'doctor-appointments.show',
            'edit' => 'doctor-appointments.edit',
            'update' => 'doctor-appointments.update',
            'destroy' => 'doctor-appointments.destroy',
        ]);

        Route::put('doctor/{id}', [UsersController::class, 'update'])->name('doctor');
    });

    Route::middleware('pasien')->group(function () {
        Route::resource('patient-medical-records', MedicalRecordsController::class)->names([
            'index' => 'patient-medical-records',
            'create' => 'patient-medical-records.create',
            'store' => 'patient-medical-records.store',
            'show' => 'patient-medical-records.show',
            'edit' => 'patient-medical-records.edit',
            'update' => 'patient-medical-records.update',
            'destroy' => 'patient-medical-records.destroy',
        ]);
        // Route::resource('patient-appointments', AppointmentsController::class)->names([
        //     'index' => 'patient-appointments',
        //     'create' => 'patient-appointments.create',
        //     'store' => 'patient-appointments.store',
        //     'show' => 'patient-appointments.show',
        //     'edit' => 'patient-appointments.edit',
        //     'update' => 'patient-appointments.update',
        //     'destroy' => 'patient-appointments.destroy',
        // ]);
    });
});
