<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;

class TableAvailabilityController extends Controller
{
    public function index(request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $date = $request->input('date');
        $time = $request->input('time');

        $availableTables = Table::whereDoesntHave('reservations', function ($query) use ($date, $time) {
            $query->where('date', $date)
                  ->where('time', $time);
        })->get();

        return response()->json($availableTables);
    }

    
}
