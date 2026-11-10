<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\LaundryStatusController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\ExpenseController;

use App\Http\Controllers\WelcomeController;

use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\OrderController as PelangganOrderController;
use App\Http\Controllers\Pelanggan\PaymentController as PelangganPaymentController;
use App\Http\Controllers\Pelanggan\HistoryController as PelangganHistoryController;
use App\Http\Controllers\Pelanggan\ProfileController as PelangganProfileController;

use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;
use App\Http\Controllers\Kasir\TransactionController as KasirTransactionController;
use App\Http\Controllers\Kasir\LaundryStatusController as KasirLaundryStatusController;
use App\Http\Controllers\Kasir\PaymentController as KasirPaymentController;

//Welcome Page

Route::get('/', [WelcomeController::class, 'index']) ->name('welcome');

/*
| -------------------------------------------------------------------------- |
| Authentication                                                             |
| -------------------------------------------------------------------------- |
*/

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [LoginController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.store');


    // Register
    Route::get('/register', [RegisterController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'register'])
        ->name('register.store');


    // Forgot Password
    Route::get('/forgot-password', [
        ForgotPasswordController::class,
        'showForgotPassword'
    ])->name('password.request');

    Route::post('/forgot-password', [
        ForgotPasswordController::class,
        'sendResetLink'
    ])->name('password.email');


    // Reset Password
    Route::get('/reset-password/{token}', [
        ResetPasswordController::class,
        'showResetPassword'
    ])->name('password.reset');

    Route::post('/reset-password', [
        ResetPasswordController::class,
        'resetPassword'
    ])->name('password.update');

});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


//ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // User
    Route::resource('users', UserController::class)
            ->except(['show']);

    // Paket Laundry
    Route::resource('packages', PackageController::class)
            ->except(['show']);

    //Pesanan
    Route::get('/pesanan', [PesananController::class, 'index'])
            ->name('pesanan.index');

    // Transaksi
    Route::resource('transactions', TransactionController::class)
            ->except([]);

    Route::get('/transactions/{transaction}/status', [LaundryStatusController::class, 'edit'])
            ->name('transactions.status.edit');

    Route::put('/transactions/{transaction}/status', [LaundryStatusController::class, 'update'])
            ->name('transactions.status.update');

    // Pembayaran
    Route::get('/payments', [
        PaymentController::class,
        'index'
    ])->name('payments.index');

    Route::get('/payments/{payment}', [
        PaymentController::class,
        'show'
    ])->name('payments.show');

    Route::get('/transactions/{transaction}/payment/cash', [PaymentController::class, 'createCash'])
        ->name('transactions.payment.cash');

    Route::post('/transactions/{transaction}/payment/cash', [PaymentController::class, 'storeCash'])
        ->name('transactions.payment.cash.store');

    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    // Pengeluaran
    Route::resource('expenses', ExpenseController::class)
        ->except(['show']);

    // Pengaturan
    Route::get('/settings', [SettingController::class, 'index'])
        ->name('settings.index');

    Route::put('/settings', [SettingController::class, 'update'])
        ->name('settings.update');

});

//KASIR
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')
    ->group(function () {

        // Dashboard
        Route::get('/', [KasirDashboardController::class, 'index'])
            ->name('dashboard');


        // Pesanan / Transaksi
        Route::resource('pesanan', KasirTransactionController::class)->parameters([
            'pesanan' => 'transaction',
        ])->names([
            'index' => 'transactions.index',
            'create' => 'transactions.create',
            'store' => 'transactions.store',
            'show' => 'transactions.show',
            'edit' => 'transactions.edit',
            'update' => 'transactions.update',
            'destroy' => 'transactions.destroy',
        ]);

        //update status laundry
        Route::get('/pesanan/{transaction}/status', [KasirLaundryStatusController::class, 'edit'])
            ->name('transactions.status.edit');

        Route::put('/pesanan/{transaction}/status', [KasirLaundryStatusController::class, 'update'])
            ->name('transactions.status.update');

        // Pembayaran
        Route::get('/pembayaran', [KasirPaymentController::class, 'index'])
            ->name('payments.index');

        Route::get('/pembayaran/{payment}', [KasirPaymentController::class, 'show'])
            ->name('payments.show');

        Route::get('/pembayaran/{payment}/cash', [KasirPaymentController::class, 'createCash'])
            ->name('payments.cash');

        Route::post('/pembayaran/{payment}/cash', [KasirPaymentController::class, 'storeCash'])
            ->name('payments.cash.store');

        // Profil
        Route::get('/profil', function () {
            return 'Halaman Profil Kasir';
        })->name('profile.index');

    });

//Pelanggan
Route::prefix('pelanggan')
    ->name('pelanggan.')
    ->middleware(['auth', 'role:pelanggan'])
    ->group(function () {

        // Dashboard
        Route::get('/', [PelangganDashboardController::class, 'index'])
            ->name('dashboard');

        // Pesanan
        Route::get('/pesanan', [PelangganOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/pesanan/buat', [PelangganOrderController::class, 'create'])
            ->name('orders.create');

        Route::post('/pesanan', [PelangganOrderController::class, 'store'])
            ->name('orders.store');

        Route::get('/pesanan/{transaction}', [PelangganOrderController::class, 'show'])
            ->name('orders.show');

        // Pembayaran
        Route::get('/pembayaran', [PelangganPaymentController::class, 'index'])
            ->name('payments.index');

        Route::get('/pembayaran/{payment}', [PelangganPaymentController::class, 'show'])
            ->name('payments.show');

        Route::get('/pembayaran/{payment}/cash', [PelangganPaymentController::class, 'cash'])
            ->name('payments.cash');

        Route::get('/pembayaran/{payment}/midtrans', [PelangganPaymentController::class, 'midtrans'])
            ->name('payments.midtrans');

        // Riwayat
        Route::get('/riwayat', [PelangganHistoryController::class, 'index'])
            ->name('history.index');

        // Profil
        Route::get('/profil', [PelangganProfileController::class, 'index'])
            ->name('profile.index');

    });
