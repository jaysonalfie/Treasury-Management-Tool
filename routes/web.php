<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransferTransactionController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Models\TransferTransaction;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('accounts', [AccountController::class, 'index'])->name('accounts');
    Route::get('accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::get('accounts/edit/{id}', [AccountController::class, 'edit'])->name('accounts.edit');

    Route::get('transactions', [TransferTransactionController::class, 'index'])->name('transactions');
    Route::get('transactions/create', [TransferTransactionController::class, 'create'])->name('transactions.create');


});

require __DIR__.'/auth.php';
