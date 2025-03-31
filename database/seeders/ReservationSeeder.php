<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('role', 'klant')->first();
        $table = Table::first();

        Reservation::create([
            'user_id' => $user->id,
            'table_id' => $table->id,
            'date' => '2021-12-24',
            'time' => '18:00',
            'number_of_people' => 4,
            'phone_number' => '0612345678',
            'Occasion' => 'Verjaardag',
            'status' => 'geboekt',
        ]);
    }
}
