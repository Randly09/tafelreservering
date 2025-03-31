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
            ->limit(10)
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

    public function store(Request $request)
    {
        // Validate incoming data.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
        ]);

        // Create a new table record.
        Table::create($validated);

        // Redirect back to the admin tables page with a success message.
        return redirect()->route('beheerderTables.index')
            ->with('success', 'Table created successfully.');
    }

    /**
     * Update the specified table in storage.
     */
    public function update(Request $request, Table $table)
    {
        // Validate incoming data.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
        ]);

        // Update the table record.
        $table->update($validated);

        // Redirect back with a success message.
        return redirect()->route('beheerderTables.index')
            ->with('success', 'Table updated successfully.');
    }

    /**
     * Remove the specified table from storage.
     */
    public function destroy(Table $table)
    {
        $table->delete();

        // Redirect back with a success message.
        return redirect()->route('beheerderTables.index')
            ->with('success', 'Table deleted successfully.');
    }
}