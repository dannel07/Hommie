<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PlatformAdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use App\Models\User;

// Landing Page
Route::get('/', [AuthController::class, 'landingpage'])->name('landingpage');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/login1', [AuthController::class, 'login'])->name('login1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email Verification
Route::get('/verify-email/{id}/{token}', function ($id, $token) {
    $user = User::find($id);

    if (!$user || $user->email_verified_at || !hash_equals(sha1($user->email), $token)) {
        return redirect('/login')->with('error', 'Link verifikasi tidak valid atau sudah digunakan.');
    }

    // Update status verifikasi
    $user->update(['email_verified_at' => Carbon::now()]);

    return redirect('/login')->with('success', 'Email berhasil diverifikasi, silakan login!');
})->name('email.verify');

Route::post('/resend-verification', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (!$user || $user->email_verified_at) {
        return back()->with('error', 'Email sudah diverifikasi atau tidak ditemukan.');
    }

    // Kirim ulang email verifikasi
    sendVerificationEmail($user);

    return back()->with('success', 'Email verifikasi telah dikirim ulang.');
})->name('email.resend');

// Registration
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register-insert', [AuthController::class, 'insertRegister'])->name('insertRegister');

// Detail Property
Route::get('/detail-property/{id}', [UserController::class, 'showDetailProperty'])->name('detail-property.show');

// User Type and Role
Route::post('/userType-insert', [AuthController::class, 'insertUserType'])->name('insertUserType');
Route::get('/userRole-insert', [AuthController::class, 'insertUserRole'])->name('insertUserRole');

// Admin Routes
Route::get('/dashboard-admin', [AdminController::class, 'showAdminpage'])->name('showAdminpage');

// Owner Routes
Route::prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'showOwnerpage'])->name('dashboard');
    Route::get('/property', [OwnerController::class, 'showPropertypage'])->name('property');
    Route::get('/add-property', [OwnerController::class, 'add_property'])->name('add-property');
    Route::post('/store-property', [OwnerController::class, 'store_property'])->name('store-property');
    Route::post('/delete-property', [OwnerController::class, 'delete_property'])->name('delete-property');
    Route::get('/property/edit/{id}', [OwnerController::class, 'edit_property'])->name('edit-property');
    Route::post('/property/update/{id}', [OwnerController::class, 'update_property'])->name('update-property');
});

// Location Routes
Route::prefix('location')->group(function () {
    Route::get('/provinces', [LocationController::class, 'getProvinces']);
    Route::get('/cities/{province_id}', [LocationController::class, 'getCities']);
    Route::get('/districts/{cities_id}', [LocationController::class, 'getDistricts']);
    Route::get('/subdistricts/{district_id}', [LocationController::class, 'getSubdistricts']);
});

// Super Admin Routes
Route::prefix('super-admin')->name('super_admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');


    // Route untuk melihat profil Super Admin
    Route::get('/profiles', [SuperAdminController::class, 'showProfile'])->name('profiles.index');

    // Route untuk memperbarui profil Super Admin
    Route::put('/profiles/update', [SuperAdminController::class, 'updateProfile'])->name('profiles.update');
    Route::get('/profiles/edit', [SuperAdminController::class, 'editProfile'])->name('profiles.edit'); // Route untuk edit profil

    // Manage Entrepreneurs
    Route::prefix('entrepreneurs')->name('entrepreneurs.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'manageEntrepreneurs'])->name('index');
        Route::get('/create', [SuperAdminController::class, 'addEntrepreneur'])->name('create');
        Route::post('/store', [SuperAdminController::class, 'storeEntrepreneur'])->name('store');
        Route::post('/delete', [SuperAdminController::class, 'deleteEntrepreneur'])->name('delete');
        Route::get('/edit/{id}', [SuperAdminController::class, 'editEntrepreneur'])->name('edit');
        Route::post('/update/{id}', [SuperAdminController::class, 'updateEntrepreneur'])->name('update');
        Route::get('/destroy/{id}', [SuperAdminController::class, 'destroyEntrepreneur'])->name('destroy');
    });

    // Manage Platform Admins
    Route::prefix('platform-admins')->name('platform_admins.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'managePlatformAdmins'])->name('index');
        Route::get('/create', [SuperAdminController::class, 'createPlatformAdmin'])->name('create');
        Route::post('/store', [SuperAdminController::class, 'storePlatformAdmin'])->name('store');
        Route::get('/edit/{id}', [SuperAdminController::class, 'editPlatformAdmin'])->name('edit');
        Route::put('/update/{id}', [SuperAdminController::class, 'updatePlatformAdmin'])->name('update');
        Route::delete('/delete/{id}', [SuperAdminController::class, 'deletePlatformAdmin'])->name('delete');
    });
});

// Platform Admin Routes
Route::prefix('platform-admin')->name('platform_admin.')->group(function () {
    Route::get('/dashboard', [PlatformAdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/', [PlatformAdminController::class, 'index'])->name('index');
    Route::post('/ban/{id}', [PlatformAdminController::class, 'ban'])->name('ban');
    Route::post('/unban/{id}', [PlatformAdminController::class, 'unban'])->name('unban');
});
