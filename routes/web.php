<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PasswordResetLinkSendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('blogs', fn () => config('app.name'))->name('blogs');

    // Route::get('permissions', function () {
    //     $user = auth()->user();
    //     return $user?->roles->flatMap(fn ($role) => $role->permissions->pluck('name'))->unique() ?? [];
    // });

    Route::resource('roles', RoleController::class);

    Route::get('languages/translation/{language}', [LanguageController::class, 'translation'])->name('languages.translation');
    Route::post('languages/translation/{language}', [LanguageController::class, 'translationUpdate']);
    Route::post('languages/status/{language}', [LanguageController::class, 'statusUpdate'])->name('languages.status');
    Route::resource('languages', LanguageController::class);

    Route::post('users/{user}/password-reset-link', PasswordResetLinkSendController::class)->name('password-reset-link.send');
    Route::resource('users', UserController::class)->except(['create', 'edit']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'store'])->name('settings.store');

    Route::patch('currencies/status/{currency}', [CurrencyController::class, 'statusUpdate'])->name('currencies.status');
    Route::resource('currencies', CurrencyController::class)->except(['create', 'edit']);
});

require __DIR__.'/auth.php';
