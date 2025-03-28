<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming form data
        $validated = $request->validate([
            'table_id'      => 'required|exists:tables,id',
            'date'          => 'required|date|after_or_equal:today',
            'time'          => 'required',
            'phone_number'  => 'required|string',
            'Occation'      => 'nullable|string',
            'number_of_people' => 'required|integer|min:1',
        ]);

        // Retrieve the table to check its capacity
        $table = Table::findOrFail($validated['table_id']);

        // If the requested number of people exceeds the table's capacity, set it to the table's capacity
        if ($validated['number_of_people'] > $table->capacity) {
            $validated['number_of_people'] = $table->capacity;
        }

        // Add the authenticated user's id and default status
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'geboekt';

        // Create the reservation record
        Reservation::create($validated);

    }


}
