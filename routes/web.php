<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationCRUDController;
use App\Http\Controllers\API\TableAvailabilityController;

/*
| Public (No Auth) Routes
*/

// Root (Welcome page)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

// Table availability (API-like endpoint, no auth required?)
Route::get('/tables/availability', [TableAvailabilityController::class, 'index']);

// If you want a /home route that checks role:
Route::get('/home', function () {
    $user = auth()->user();
    // Must be logged in for $user to exist
    if (! $user) {
        return redirect('/login');
    }

    if ($user->role === 'beheerder') {
        return redirect()->route('beheerder.home');
    } elseif ($user->role === 'klant') {
        return redirect()->route('reservations.index');
    }

    // Default fallback
    return redirect('/login');
})->name('home');


/*
| Beheerder (Admin) Routes
*/

// Dashboard
Route::get('/beheerder', function () {
    $user = auth()->user();
    if (! $user || $user->role !== 'beheerder') {
        return redirect('/login');
    }

    // Example of loading reservations
    $reservations = \App\Models\Reservation::with(['table', 'user'])
        ->latest()
        ->get();

    return Inertia::render('BeheerderDashboard', [
        'reservations' => $reservations,
    ]);
})->name('beheerder.home');

// Show list of all tables
Route::get('/beheerder/tables', function () {
    $user = auth()->user();
    if (! $user || $user->role !== 'beheerder') {
        return redirect('/login');
    }
    return app(TableController::class)->index();
})->name('beheerderTables.index');

// Create a new table
Route::post('/beheerder/tables', function () {
    $user = auth()->user();
    if (! $user || $user->role !== 'beheerder') {
        return redirect('/login');
    }
    return app(TableController::class)->store(request());
})->name('beheerderTables.store');

// Update an existing table
Route::match(['put', 'patch'], '/beheerder/tables/{table}', function (\App\Models\Table $table) {
    $user = auth()->user();
    if (! $user || $user->role !== 'beheerder') {
        return redirect('/login');
    }
    return app(TableController::class)->update(request(), $table->id);
})->name('beheerderTables.update');

// Delete a table
Route::delete('/beheerder/tables/{table}', function (\App\Models\Table $table) {
    $user = auth()->user();
    if (! $user || $user->role !== 'beheerder') {
        return redirect('/login');
    }
    return app(TableController::class)->destroy($table->id);
})->name('beheerderTables.destroy');

// Possibly an admin route for reservations list
Route::get('/beheerder/reservations', function () {
    $user = auth()->user();
    if (! $user || $user->role !== 'beheerder') {
        return redirect('/login');
    }
    return app(TableController::class)->adminIndex();
})->name('beheerderReservations.index');

// Example: Admin deleting reservations
Route::delete('/beheerder/reservations/{id}', function ($id) {
    $user = auth()->user();
    if (! $user || $user->role !== 'beheerder') {
        return redirect('/login');
    }
    return app(ReservationCRUDController::class)->destroy($id);
})->name('reservationsBeheer.destroy');


/*
| Klant (Customer) Routes
*/

Route::get('/reservations', function () {
    $user = auth()->user();
    if (! $user || $user->role !== 'klant') {
        return redirect('/login');
    }
    return Inertia::render('Reservations');
})->name('reservations.index');

// Book a specific table
Route::get('/book-table/{id}', function ($id) {
    $user = auth()->user();
    if (! $user || $user->role !== 'klant') {
        return redirect('/login');
    }

    $table = \App\Models\Table::findOrFail($id);
    $date = request()->query('date', date('Y-m-d'));
    $time = request()->query('time', '');

    return Inertia::render('BookTable', [
        'table'            => $table,
        'reservationDate'  => $date,
        'reservationTime'  => $time,
    ]);
})->name('book-table');

// Create/store a reservation
Route::post('/reservations', function () {
    $user = auth()->user();
    if (! $user || $user->role !== 'klant') {
        return redirect('/login');
    }
    return app(ReservationController::class)->store(request());
})->name('reservations.store');

// Show "reserved tables"
Route::get('/reserved-tables', function () {
    $user = auth()->user();
    if (! $user || $user->role !== 'klant') {
        return redirect('/login');
    }
    return app(ReservationController::class)->index();
})->name('reservedTables.index');

// Possibly delete a reservation (if klant can do that)
Route::delete('/reservations/{id}', function ($id) {
    $user = auth()->user();
    if (! $user || $user->role !== 'klant') {
        return redirect('/login');
    }
    return app(ReservationController::class)->destroy($id);
})->name('reservations.destroy');


/*
| Profile routes -
*/

Route::get('/profile', function () {
    if (! auth()->check()) {
        return redirect('/login');
    }
    return app(ProfileController::class)->edit(request());
})->name('profile.edit');

Route::patch('/profile', function () {
    if (! auth()->check()) {
        return redirect('/login');
    }
    return app(ProfileController::class)->update(request());
})->name('profile.update');

Route::delete('/profile', function () {
    if (! auth()->check()) {
        return redirect('/login');
    }
    return app(ProfileController::class)->destroy(request());
})->name('profile.destroy');


/*
|--------------------------------------------------------------------------
| Authentication routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
     ->middleware('guest')
     ->name('login');

require __DIR__ . '/auth.php';