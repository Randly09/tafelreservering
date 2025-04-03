<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Log;

class TableController extends Controller
{


    public function adminIndex()
    {
        $reservations = Reservation::with(['table', 'user'])
            ->latest() 
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
        $tables = Table::all();

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
        $table = Table::find($id);

        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'capacity' => 'required|integer',
            'location' => 'required|string|max:255',
        ]);

        Log::info('Updating Table:', [
            'table_id' => $table->id,
            'updated_data' => $validatedData,
        ]);

        $table->update($validatedData);



        return response()->json($table, 200);
    }

    public function edit(Request $request, $id)
    {
        $table = Table::findOrFail($id);
        
        Log::info('Editing Table:', [
            'table_id' => $table->id,
            'name' => $table->name,
            'capacity' => $table->capacity,
            'location' => $table->location,
        ]);

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

        Log::info('Deleting Table:', [
            'table_id' => $table->id,
            'name' => $table->name,
        ]);

        return response()->json(['message' => 'Table deleted successfully'], 200);
    }
}