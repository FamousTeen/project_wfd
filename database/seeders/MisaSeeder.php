<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activityDateTime = Carbon::now()->addDays(5);

        DB::table('misas')->insert([
            'title' => "Misa Kudus",
            'category' => "Misa Harian/Rutin",
            'activity_datetime' => $activityDateTime->format('Y-m-d H:i:s'),
            'upload_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'evaluation' => "Fusce metus erat, feugiat eu hendrerit aliquet, pulvinar eu urna. Curabitur eu sagittis diam. Maecenas faucibus scelerisque.",
            'status' => "Proses",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('misas')->insert([
            'title' => "Misa Natal",
            'category' => "Misa Acara Besar",
            'activity_datetime' => $activityDateTime->format('Y-m-d H:i:s'),
            'upload_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'evaluation' => "Fusce metus erat, feugiat eu hendrerit aliquet, pulvinar eu urna. Curabitur eu sagittis diam. Maecenas faucibus scelerisque.",
            'status' => "Proses",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('misas')->insert([
            'title' => "Misa Natal 2",
            'category' => "Misa Acara Besar",
            'activity_datetime' => $activityDateTime->subDays(2)->format('Y-m-d H:i:s'),
            'upload_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'evaluation' => "Fusce metus erat, feugiat eu hendrerit aliquet, pulvinar eu urna. Curabitur eu sagittis diam. Maecenas faucibus scelerisque.",
            'status' => "Proses",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('misas')->insert([
            'title' => "Misa Anjay",
            'category' => "Misa Acara Besar",
            'activity_datetime' => $activityDateTime->subDays(2)->format('Y-m-d H:i:s'),
            'upload_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'evaluation' => "Fusce metus erat, feugiat eu hendrerit aliquet, pulvinar eu urna. Curabitur eu sagittis diam. Maecenas faucibus scelerisque.",
            'status' => "Proses",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
