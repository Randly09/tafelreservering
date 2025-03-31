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
        Table::create(['name' => 'Two Pair Table', 'capacity' => 4, 'location' => 'Inside']);
        Table::create(['name' => 'The Duo Table', 'capacity' => 2, 'location' => 'Outside']);
        Table::create(['name' => 'Round Table', 'capacity' => 6, 'location' => 'Inside']);
        Table::create(['name' => 'The Party Table', 'capacity' => 8, 'location' => 'Inside']);
        Table::create(['name' => 'The Duo Table', 'capacity' => 2, 'location' => 'Outside']);
        Table::create(['name' => 'Two Pair Table', 'capacity' => 4, 'location' => 'Outside']);
    }
}
