<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MeetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('meets')->insert([
            'event_id' => 1,
            'title' => "Rapat 1",
            'date' => Carbon::now()->addDays(5)->format('Y-m-d H:i:s'),
            'notulen' => "Fusce metus erat, feugiat eu hendrerit aliquet, pulvinar eu urna. Curabitur eu sagittis diam. Maecenas faucibus scelerisque.",
            'place' => "Kantor",
            'permission' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('meets')->insert([
            'event_id' => 1,
            'title' => "Rapat 2",
            'date' => Carbon::now()->addDays(5)->format('Y-m-d H:i:s'),
            'notulen' => "Test 123",
            'place' => "Ruangan 1",
            'permission' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('meets')->insert([
            'event_id' => 1,
            'title' => "Rapat 3",
            'date' => Carbon::now()->addDays(5)->format('Y-m-d H:i:s'),
            'place' => "Ruangan 2",
            'notulen' => "Test 12345",
            'permission' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    
}
