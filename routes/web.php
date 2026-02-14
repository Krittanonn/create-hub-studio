<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Provider;
use App\Http\Controllers\Customer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 2. Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 3. Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 4. Public Explore
Route::get('/explore', [Customer\StudioExplorerController::class, 'index'])->name('customer.explore.index');
Route::get('/explore/{studio}', [Customer\StudioExplorerController::class, 'show'])->name('customer.explore.show');


// --------------------------------------------------------------------------
// 5. ADMIN ROUTES (สิทธิ์เฉพาะ Admin)
// --------------------------------------------------------------------------
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard & Reports
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [Admin\DashboardController::class, 'report'])->name('reports.index'); // ปรับให้ตรงกับ Dashboard
    Route::get('/reports/revenue', [Admin\DashboardController::class, 'report'])->name('reports.revenue');

    // Resource Management
    Route::resource('studios', Admin\StudioController::class);
    Route::resource('equipments', Admin\EquipmentController::class);
    Route::patch('equipments/{equipment}/update-stock', [Admin\EquipmentController::class, 'updateStock'])->name('equipments.update-stock');
    Route::resource('staff', Admin\StaffController::class);

    // User Management
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/update', [Admin\UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle-status', [Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    // เพิ่ม column 'is_active' ในตาราง users เพื่อรองรับฟีเจอร์นี้
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Booking & Availability
    Route::get('/bookings', [Admin\BookingManagerController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [Admin\BookingManagerController::class, 'show'])->name('bookings.show'); 
    Route::patch('/bookings/{id}/status', [Admin\BookingManagerController::class, 'updateStatus'])->name('bookings.update-status');
    
    Route::get('/availability', [Admin\AvailabilityController::class, 'index'])->name('availability.index');
    Route::post('/availability', [Admin\AvailabilityController::class, 'store'])->name('availability.store');

    // Payment Verification
    Route::get('/payments/verify', [Admin\PaymentVerificationController::class, 'pendingPayments'])->name('payments.verify');
    Route::patch('/payments/{payment}/approve', [Admin\PaymentVerificationController::class, 'approve'])->name('payments.approve');

    // Reviews & Notifications
    Route::get('/reviews', [Admin\ReviewManagerController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [Admin\ReviewManagerController::class, 'destroy'])->name('reviews.destroy');
    
    Route::get('/notifications', [Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

    // Settings
    Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
});


// --------------------------------------------------------------------------
// 6. PROVIDER ROUTES (สิทธิ์เฉพาะเจ้าของสตูดิโอ)
// --------------------------------------------------------------------------
Route::middleware(['auth', 'is_provider'])->prefix('provider')->name('provider.')->group(function () {
    
    Route::get('/dashboard', [Provider\DashboardController::class, 'index'])->name('dashboard');

    // CRUD Resources
    Route::resource('studios', Provider\StudioController::class);
    Route::resource('equipments', Provider\EquipmentController::class);
    Route::resource('staffs', Provider\StaffController::class);

    // Business Logic
    Route::get('/availability', [Provider\AvailabilityController::class, 'index'])->name('availability.index');
    Route::post('/availability', [Provider\AvailabilityController::class, 'store'])->name('availability.store');
    Route::delete('/availability/{id}', [Provider\AvailabilityController::class, 'destroy'])->name('availability.destroy');

    Route::get('/bookings', [Provider\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [Provider\BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [Provider\BookingController::class, 'updateStatus'])->name('bookings.update-status');

    // Payouts & Reports
    Route::get('/payouts', [Provider\PayoutController::class, 'index'])->name('payouts.index');
    Route::post('/payouts/request', [Provider\PayoutController::class, 'requestPayout'])->name('payouts.request');
    Route::get('/reports', [Provider\ReportController::class, 'index'])->name('reports.index');

    // Reviews
    Route::get('/reviews', [Provider\ReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}/reply', [Provider\ReviewController::class, 'update'])->name('reviews.reply');

    // Notifications (เพิ่ม .index เพื่อแก้ Error RouteNotFound)
    Route::get('/notifications', [Provider\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [Provider\NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
});


// --------------------------------------------------------------------------
// 7. CUSTOMER ROUTES (สิทธิ์เฉพาะลูกค้า)
// --------------------------------------------------------------------------
Route::middleware(['auth', 'is_customer'])->prefix('customer')->name('customer.')->group(function () {
    
    // Booking Flow
    Route::get('/booking/create/{studio}', [Customer\BookingFlowController::class, 'create'])->name('bookings.create');
    Route::post('/booking/store', [Customer\BookingFlowController::class, 'store'])->name('bookings.store');

    // My Account
    Route::get('/my-bookings', [Customer\MyBookingController::class, 'index'])->name('bookings.index');
    Route::get('/my-bookings/{id}', [Customer\MyBookingController::class, 'show'])->name('bookings.show');
    Route::post('/my-bookings/{id}/cancel', [Customer\MyBookingController::class, 'cancel'])->name('bookings.cancel');

    // Payments & Profile
    Route::get('/payment/{booking}', [Customer\PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payment/{booking}/store', [Customer\PaymentController::class, 'store'])->name('payments.store');
    Route::get('/profile', [Customer\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [Customer\ProfileController::class, 'update'])->name('profile.update');

    // Reviews & Notifications
    Route::get('/notifications', [Customer\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/reviews/create/{booking}', [Customer\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/store/{booking}', [Customer\ReviewController::class, 'store'])->name('reviews.store');
});