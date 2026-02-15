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

/*
|--------------------------------------------------------------------------
| 1. Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'))->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::get('/explore', [Customer\StudioExplorerController::class, 'index'])
    ->name('customer.explore.index');

Route::get('/explore/{studio}', [Customer\StudioExplorerController::class, 'show'])
    ->name('customer.explore.show');


/*
|--------------------------------------------------------------------------
| 2. ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // Reports
        Route::get('/reports', [Admin\DashboardController::class, 'report'])
            ->name('reports.index');

        // Studios
        Route::resource('studios', Admin\StudioController::class);

        // Equipments
        Route::resource('equipments', Admin\EquipmentController::class);
        Route::patch(
            'equipments/{equipment}/update-stock',
            [Admin\EquipmentController::class, 'updateStock']
        )
            ->name('equipments.update-stock');

        // Staff
        Route::resource('staff', Admin\StaffController::class);

        // Users
        Route::get('/users', [Admin\UserController::class, 'index'])
            ->name('users.index');

        Route::patch(
            '/users/{user}/update',
            [Admin\UserController::class, 'update']
        )
            ->name('users.update');

        Route::patch(
            '/users/{user}/toggle-status',
            [Admin\UserController::class, 'toggleStatus']
        )
            ->name('users.toggle-status');

        Route::delete(
            '/users/{user}',
            [Admin\UserController::class, 'destroy']
        )
            ->name('users.destroy');

        // Bookings
        Route::get(
            '/bookings',
            [Admin\BookingManagerController::class, 'index']
        )
            ->name('bookings.index');

        Route::get(
            '/bookings/{booking}',
            [Admin\BookingManagerController::class, 'show']
        )
            ->name('bookings.show');

        Route::patch(
            '/bookings/{id}/status',
            [Admin\BookingManagerController::class, 'updateStatus']
        )
            ->name('bookings.update-status');

        // Availability
        Route::get(
            '/availability',
            [Admin\AvailabilityController::class, 'index']
        )
            ->name('availability.index');

        Route::post(
            '/availability',
            [Admin\AvailabilityController::class, 'store']
        )
            ->name('availability.store');

        // 🔥 Payment Verification (ครบ flow แล้ว)
        Route::get(
            '/payments/verify',
            [Admin\PaymentVerificationController::class, 'pendingPayments']
        )
            ->name('payments.verify');

        Route::patch(
            '/payments/{payment}/approve',
            [Admin\PaymentVerificationController::class, 'approve']
        )
            ->name('payments.approve');

        Route::patch(
            '/payments/{payment}/reject',
            [Admin\PaymentVerificationController::class, 'reject']
        )
            ->name('payments.reject');

        // Reviews
        Route::get(
            '/reviews',
            [Admin\ReviewManagerController::class, 'index']
        )
            ->name('reviews.index');

        Route::delete(
            '/reviews/{review}',
            [Admin\ReviewManagerController::class, 'destroy']
        )
            ->name('reviews.destroy');

        // Notifications
        Route::get(
            '/notifications',
            [Admin\NotificationController::class, 'index']
        )
            ->name('notifications.index');

        Route::post(
            '/notifications/mark-all-read',
            [Admin\NotificationController::class, 'markAllAsRead']
        )
            ->name('notifications.mark-all-read');

        // Settings
        Route::get(
            '/settings',
            [Admin\SettingController::class, 'index']
        )
            ->name('settings.index');

        Route::post(
            '/settings',
            [Admin\SettingController::class, 'update']
        )
            ->name('settings.update');
    });


/*
|--------------------------------------------------------------------------
| 3. PROVIDER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'is_provider'])
    ->prefix('provider')
    ->name('provider.')
    ->group(function () {

        Route::get(
            '/dashboard',
            [Provider\DashboardController::class, 'index']
        )
            ->name('dashboard');

        Route::resource('studios', Provider\StudioController::class);
        Route::resource('equipments', Provider\EquipmentController::class);
        Route::resource('staffs', Provider\StaffController::class);

        Route::get(
            '/availability',
            [Provider\AvailabilityController::class, 'index']
        )
            ->name('availability.index');

        Route::post(
            '/availability',
            [Provider\AvailabilityController::class, 'store']
        )
            ->name('availability.store');

        Route::delete(
            '/availability/{id}',
            [Provider\AvailabilityController::class, 'destroy']
        )
            ->name('availability.destroy');

        Route::get(
            '/bookings',
            [Provider\BookingController::class, 'index']
        )
            ->name('bookings.index');

        Route::get(
            '/bookings/{booking}',
            [Provider\BookingController::class, 'show']
        )
            ->name('bookings.show');

        Route::patch(
            '/bookings/{booking}/status',
            [Provider\BookingController::class, 'updateStatus']
        )
            ->name('bookings.update-status');

        Route::get(
            '/payouts',
            [Provider\PayoutController::class, 'index']
        )
            ->name('payouts.index');

        Route::post(
            '/payouts/request',
            [Provider\PayoutController::class, 'requestPayout']
        )
            ->name('payouts.request');

        Route::get(
            '/reports',
            [Provider\ReportController::class, 'index']
        )
            ->name('reports.index');

        Route::get(
            '/reviews',
            [Provider\ReviewController::class, 'index']
        )
            ->name('reviews.index');

        Route::patch(
            '/reviews/{review}/reply',
            [Provider\ReviewController::class, 'update']
        )
            ->name('reviews.reply');

        Route::get(
            '/notifications',
            [Provider\NotificationController::class, 'index']
        )
            ->name('notifications.index');

        Route::post(
            '/notifications/mark-all-read',
            [Provider\NotificationController::class, 'markAllRead']
        )
            ->name('notifications.mark-all-read');
    });


/*
|--------------------------------------------------------------------------
| 4. CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'is_customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get(
            '/booking/create/{studio}',
            [Customer\BookingFlowController::class, 'create']
        )
            ->name('bookings.create');

        Route::post(
            '/booking/store',
            [Customer\BookingFlowController::class, 'store']
        )
            ->name('bookings.store');

        Route::get(
            '/my-bookings',
            [Customer\MyBookingController::class, 'index']
        )
            ->name('bookings.index');

        Route::get(
            '/my-bookings/{id}',
            [Customer\MyBookingController::class, 'show']
        )
            ->name('bookings.show');

        Route::post(
            '/my-bookings/{id}/cancel',
            [Customer\MyBookingController::class, 'cancel']
        )
            ->name('bookings.cancel');

        Route::get(
            '/payment/{booking}',
            [Customer\PaymentController::class, 'show']
        )
            ->name('payments.show');

        Route::post(
            '/payment/{booking}/store',
            [Customer\PaymentController::class, 'store']
        )
            ->name('payments.store');

        Route::get(
            '/profile',
            [Customer\ProfileController::class, 'edit']
        )
            ->name('profile.edit');

        Route::patch(
            '/profile/update',
            [Customer\ProfileController::class, 'update']
        )
            ->name('profile.update');

        Route::get(
            '/notifications',
            [Customer\NotificationController::class, 'index']
        )
            ->name('notifications.index');

        Route::get(
            '/reviews/create/{booking}',
            [Customer\ReviewController::class, 'create']
        )
            ->name('reviews.create');

        Route::post(
            '/reviews/store/{booking}',
            [Customer\ReviewController::class, 'store']
        )
            ->name('reviews.store');
    });
