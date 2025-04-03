<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Reservation;

class TableController extends Controller
{


    public function adminIndex()
    {
        $reservations = Reservation::with(['table', 'user'])
            ->latest() // Orders by created_at descending
            ->get();

        return Inertia::render('BeheerderDashboard', [
            'reservations' => $reservations,
        ]);
    }
    /**
     * Display a listing of the tables.
     */
    public function index()
    {
        // Retrieve all tables from the database
        $tables = Table::all();

        // Render the 'Tables' component and pass the tables data as a prop
        return Inertia::render('Tables', [
            'tables' => $tables,
        ]);
    }
    public function tablesData()
    {
        $tables = Table::all();
        return response()->json($tables);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'capacity' => 'required|integer',
            'location' => 'required|string|max:255',
        ]);

        $table = Table::create($validatedData);

        return response()->json($table, 201);
    }


    /**
     * Update the specified table in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the table by its ID
        $table = Table::find($id);

        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        // Validate incoming data
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'capacity' => 'required|integer',
            'location' => 'required|string|max:255',
        ]);

        // Update the table record
        $table->update($validatedData);

        // Return the updated table as JSON
        return response()->json($table, 200);
    }

    public function edit(Request $request, $id)
    {
        $table = Table::findOrFail($id);
    
        // If the request is an XHR or wants JSON explicitly, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($table);
        }
    
        // Otherwise return Inertia page
        return Inertia::render('EditTable', [
            'table' => $table,
        ]);
    }
    /**
     * Remove the specified table from storage.
     */
    public function destroy($id)
    {
        $table = Table::find($id);

        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        $table->delete();

        return response()->json(['message' => 'Table deleted successfully'], 200);
    }
}