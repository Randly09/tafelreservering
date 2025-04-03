<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{

    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('table')
            ->get();

        // Log the reservations for debugging
        Log::info('User Reservations:', [
            'user_id' => Auth::id(),
            'reservations' => $reservations,
        ]);
        return Inertia::render('ReservedTables', [
            'reservations' => $reservations,
        ]);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== Auth::id()) {
            // Log the unauthorized attempt
            Log::warning('Unauthorized Reservation Deletion Attempt:', [
                'reservation_id' => $reservation->id,
                'user_id' => Auth::id(),
            ]);
            abort(403, 'Unauthorized action.');
        }
        // Check if the reservation is in the past
        Log::info('Deleting Reservation:', [
            'reservation_id' => $reservation->id,
            'user_id' => Auth::id(),
        ]);

        $reservation->delete();

        return redirect()->back()->with('success', 'Reservation canceled successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'phone_number' => 'required|string',
            'Occasion' => 'nullable|string',
        ]);

        $table = Table::findOrFail($validated['table_id']);

        $validated['number_of_people'] = $table->capacity;

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'Booked';


        Reservation::create($validated);

        // Log the reservation creation
        Log::info('New Reservation Created:', [
            'user_id' => Auth::id(),
            'table_id' => $validated['table_id'],
            'date' => $validated['date'],
            'time' => $validated['time'],
        ]);

        return redirect()->route('reservedTables.index');
    }


}
