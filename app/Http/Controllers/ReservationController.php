<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReservationController extends Controller
{

    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('table')
            ->get();

        // Pass the reservations to the Inertia view
        return Inertia::render('ReservedTables', [
            'reservations' => $reservations,
        ]);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        // Ensure the reservation belongs to the authenticated user
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $reservation->delete();

        return redirect()->back()->with('success', 'Reservation canceled successfully.');
    }

    public function store(Request $request)
    {
        // Validate the incoming form data (without number_of_people)
        $validated = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'phone_number' => 'required|string',
            'Occasion' => 'nullable|string',
        ]);

        // Retrieve the table to get its capacity
        $table = Table::findOrFail($validated['table_id']);

        // Automatically set number_of_people to the table's capacity
        $validated['number_of_people'] = $table->capacity;

        // Add additional fields to the validated data
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'geboekt';


        Reservation::create($validated);

        return redirect()->route('reservedTables.index');
    }


}
