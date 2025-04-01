<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReservationCRUDController extends Controller
{
    public function edit($id)
    {
        // Fetch the reservation
        $reservation = Reservation::with(['table','user'])->findOrFail($id);
    
        // Return an Inertia page named "EditReservation" with the reservation prop
        return Inertia::render('EditReservation', [
            'reservation' => $reservation,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
    
        // Validate input (example)
        $validatedData = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'phone_number' => 'required|string',
            'Occasion' => 'nullable|string',
            'status' => 'required|string',
            // etc...
        ]);
    
        $reservation->update($validatedData);
    
        return redirect()->refresh();
    }
    
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
    
        return redirect()->back()->with('success', 'Reservation deleted successfully.');
    }
}
