<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Table::create(['name' => 'Tafel 1', 'capacity' => 4, 'location' => 'Binnen']);
        Table::create(['name' => 'Tafel 2', 'capacity' => 2, 'location' => 'Buiten']);
        Table::create(['name' => 'Tafel 3', 'capacity' => 6, 'location' => 'Binnen']);
        Table::create(['name' => 'Tafel 4', 'capacity' => 8, 'location' => 'Binnen']);
        Table::create(['name' => 'Tafel 5', 'capacity' => 2, 'location' => 'Buiten']);
        Table::create(['name' => 'Tafel 6', 'capacity' => 4, 'location' => 'Buiten']);
    }
}
