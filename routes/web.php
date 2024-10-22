<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Animal routes
        Route::resource('animals', AnimalController::class);
    
        // Customer routes
        Route::resource('customers', CustomerController::class);
    
        // Sale routes
        Route::resource('sales', SaleController::class);
    
        // Supplier routes
        Route::resource('suppliers', SupplierController::class);

        // User routes
        Route::resource('users', UserController::class);

        // Role routes
        Route::resource('roles', RoleController::class);

        Route::resource('payments', PaymentController::class)->parameters([
            'payments' => 'payment',
        ]);
        
        // Custom routes for the show, edit, update, and destroy actions
        Route::get('payments/{paymentType}/{payment}', [PaymentController::class, 'show'])->name('payments.customShow'); // Updated name
        Route::get('payments/{id}/edit', [PaymentController::class, 'edit'])->name('payments.customEdit');
        Route::put('payments/{payment}', [PaymentController::class, 'update'])->name('payments.customUpdate'); // Removed paymentType
        Route::delete('payments/{paymentType}/{payment}', [PaymentController::class, 'destroy'])->name('payments.customDestroy');

});

Route::get('/unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');

require __DIR__.'/auth.php';
