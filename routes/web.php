<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\Table;
use App\Http\Controllers\ReservationController;
use Inertia\Inertia;
use App\Http\Controllers\API\TableAvailabilityController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Root route (Welcome page)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Custom home route that checks user role after login
Route::get('/home', function () {
    $user = auth()->user();
    if ($user->role === 'beheerder') {
        return redirect()->route('beheerder.home');
    }
    return redirect()->route('reservations.index');
})->middleware(['auth'])->name('home');


Route::get('/tables/availability', [TableAvailabilityController::class, 'index']);

// Routes for authenticated users
Route::middleware('auth')->group(function () {

    // Beheerder dashboard route
    Route::get('/beheerder', function () {
        return Inertia::render('BeheerderDashboard');
    })->name('beheerder.home');

    // Klant reservations page route
    Route::get('/reservations', function () {
        return Inertia::render('Reservations');
    })->name('reservations.index');
    Route::get('/book-table/{id}', function ($id) {
        $table = App\Models\Table::findOrFail($id);
        $date = request()->query('date', date('Y-m-d'));
        $time = request()->query('time', '');
        return Inertia::render('BookTable', [
            'table' => $table,
            'reservationDate' => $date,
            'reservationTime' => $time,
        ]);
    })->name('book-table')->middleware('auth');
    Route::middleware('auth')->group(function () {
        Route::post('/reservations', [ReservationController::class, 'store'])
             ->name('reservations.store');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

require __DIR__ . '/auth.php';
