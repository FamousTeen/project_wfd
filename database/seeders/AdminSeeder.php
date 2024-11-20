<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'name' => "Budi",
            'email' => "budi@gmail.com",
            'password' => bcrypt('12345'),
            'photo' => 'default.png',
            'address' => '100 Wise Street',
            'birthdate' => '27-11-1999',
            'region' => 'B',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('admins')->insert([
            'name' => "Budi2",
            'email' => "budi2@gmail.com",
            'password' => bcrypt('123'),
            'photo' => 'default.png',
            'address' => '200 Wise Street',
            'birthdate' => '27-11-1999',
            'region' => 'C',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('admins')->insert([
            'name' => "Adi",
            'email' => "adi@gmail.com",
            'password' => bcrypt('123'),
            'photo' => 'default.png',
            'address' => '200 Wise Street',
            'birthdate' => '27-11-1999',
            'region' => 'A',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
