<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ReservationCRUDController extends Controller
{
    public function edit($id)
    {
        $reservation = Reservation::with(['table','user'])->findOrFail($id);
        
        // Log the reservation details for debugging
        Log::info('Editing Reservation:', [
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'table_id' => $reservation->table_id,
            'date' => $reservation->date,
            'time' => $reservation->time,
        ]);

        return Inertia::render('EditReservation', [
            'reservation' => $reservation,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
    
        $validatedData = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'phone_number' => 'required|string',
            'Occasion' => 'nullable|string',
            'status' => 'required|string',
        ]);
        
        // Log the update attempt
        Log::info('Updating Reservation:', [
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'updated_data' => $validatedData,
        ]);
        $reservation->update($validatedData);
    
        return redirect()->refresh();
    }
    
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        
        // Log the deletion attempt
        Log::info('Deleting Reservation:', [
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
        ]);
        return redirect()->back()->with('success', 'Reservation deleted successfully.');
    }
}
