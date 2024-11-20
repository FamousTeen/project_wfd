<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('announcements')->insert([
            'admin_id' => 1,
            'upload_time' => Carbon::now()->format('Y-m-d H:i:s'),
            'type' => 1,
            'description' => "Fusce metus erat, feugiat eu hendrerit aliquet, pulvinar eu urna. Curabitur eu sagittis diam. Maecenas faucibus scelerisque.",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('announcements')->insert([
            'admin_id' => 1,
            'upload_time' => Carbon::now()->format('Y-m-d H:i:s'),
            'description' => "Wow gile bgt",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('announcements')->insert([
            'admin_id' => 1,
            'upload_time' => Carbon::now()->format('Y-m-d H:i:s'),
            'type' => 1,
            'description' => "Buat yang pengurus-pengurus aja",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
