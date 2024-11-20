<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MisaDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('misa_details')->insert([
            'misa_id' => 1,
            'account_id' => 1,
            'roles' => "Petugas",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('misa_details')->insert([
            'misa_id' => 1,
            'account_id' => 2,
            'roles' => "Petugas",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('misa_details')->insert([
            'misa_id' => 1,
            'account_id' => 3,
            'roles' => "Pengawas",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('misa_details')->insert([
            'misa_id' => 1,
            'account_id' => 4,
            'roles' => "Pengawas",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('misa_details')->insert([
            'misa_id' => 1,
            'account_id' => 5,
            'roles' => "Perkap",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('misa_details')->insert([
            'misa_id' => 1,
            'account_id' => 6,
            'roles' => "Perkap",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('misa_details')->insert([
            'misa_id' => 2,
            'account_id' => 1,
            'roles' => "Petugas",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('misa_details')->insert([
            'misa_id' => 2,
            'account_id' => 2,
            'roles' => "Pengawas",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('misa_details')->insert([
            'misa_id' => 2,
            'account_id' => 3,
            'roles' => "Perkap",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
