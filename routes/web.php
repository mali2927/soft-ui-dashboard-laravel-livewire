<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\{
    Auth\ForgotPassword,
    Auth\ResetPassword,
    Auth\SignUp,
    Auth\Login,
    Dashboard,
    Billing,
    Profile,
    Tables,
    StaticSignIn,
    StaticSignUp,
    Rtl,
    EmployeeIndex,
    EmployeeCreate,
    EmployeeEdit,
    LaravelExamples\UserProfile,
    LaravelExamples\UserManagement,
    LeaveTypeManager,
    LeaveRequestManager,
    LeaveBalanceManager
};
use App\Http\Livewire\Shift\{Create as ShiftCreate, Edit as ShiftEdit, Index as ShiftIndex};
use App\Http\Livewire\MonthlyLeaveAllocation\{Index as AllocationIndex, Create as AllocationCreate, Edit as AllocationEdit};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::redirect('/', '/login');
    Route::get('/sign-up', SignUp::class)->name('sign-up');
    Route::get('/login', Login::class)->name('login');
    Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');
    Route::get('/reset-password/{id}', ResetPassword::class)
        ->name('reset-password')
        ->middleware('signed');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard and profile
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile');
    
    // Billing and tables
    Route::get('/billing', Billing::class)->name('billing');
    Route::get('/tables', Tables::class)->name('tables');
    
    // Static pages
    Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
    Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('/rtl', Rtl::class)->name('rtl');
    
    // User management
    Route::get('/laravel-user-profile', UserProfile::class)->name('user-profile');
    Route::get('/laravel-user-management', UserManagement::class)->name('user-management');
    
    // Employee routes
    Route::prefix('employees')->name('employee.')->group(function () {
        Route::get('/', EmployeeIndex::class)->name('index');
        Route::get('/create', EmployeeCreate::class)->name('create');
        Route::get('/{id}/edit', EmployeeEdit::class)->name('edit');
    });
    
    // Shift routes
    Route::prefix('shifts')->name('shifts.')->group(function () {
        Route::get('/', ShiftIndex::class)->name('index');
        Route::get('/create', ShiftCreate::class)->name('create');
        Route::get('/{id}/edit', ShiftEdit::class)->name('edit');
    });
    
    // Leave management
    Route::get('/leave-types', LeaveTypeManager::class)->name('leave-types');
    Route::get('/leave-requests', LeaveRequestManager::class)->name('leave-requests');
    Route::get('/leave-balances', LeaveBalanceManager::class)->name('leave-balances');
    
    // Leave allocations
    Route::prefix('leave-allocations')->name('leave-allocations.')->group(function() {
        Route::get('/', AllocationIndex::class)->name('index');
        Route::get('/create', AllocationCreate::class)->name('create');
        Route::get('/{allocation}/edit', AllocationEdit::class)->name('edit');
    });
});