<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accounts')->insert([
            'name' => "Sasha",
            'email' => "sasha@gmail.com",
            'password' => bcrypt('12345'),
            'photo' => 'default.jpg',
            'address' => '100 Main Street',
            'birth_place_date' => 'Surabaya, 10-10-2000',
            'region' => 'A',
            'roles' => "Pengurus",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('accounts')->insert([
            'name' => "Kevin",
            'email' => "kevin@gmail.com",
            'password' => bcrypt('user123'),
            'photo' => 'default.jpg',
            'address' => '200 Main Street',
            'birth_place_date' => 'Surabaya, 20-5-1995',
            'region' => 'A',
            'roles' => "Anggota",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('accounts')->insert([
            'name' => "Kurma",
            'email' => "kurma@gmail.com",
            'password' => bcrypt('user12345'),
            'photo' => 'default.jpg',
            'address' => '300 Main Street',
            'birth_place_date' => 'Surabaya, 20-5-1995',
            'region' => 'B',
            'roles' => "Pengurus",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('accounts')->insert([
            'name' => "Karina",
            'email' => "karina@gmail.com",
            'password' => bcrypt('user345'),
            'photo' => 'default.jpg',
            'address' => '400 Main Street',
            'birth_place_date' => 'Surabaya, 20-5-1995',
            'region' => 'B',
            'roles' => "Anggota",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('accounts')->insert([
            'name' => "Valiant",
            'email' => "valiant@gmail.com",
            'password' => bcrypt('345'),
            'photo' => 'default.jpg',
            'address' => '700 Main Street',
            'birth_place_date' => 'Surabaya, 20-5-1995',
            'region' => 'C',
            'roles' => "Pengurus",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('accounts')->insert([
            'name' => "Chyntia",
            'email' => "chyntia@gmail.com",
            'password' => bcrypt('123'),
            'photo' => 'default.jpg',
            'address' => '800 Main Street',
            'birth_place_date' => 'Surabaya, 20-5-1995',
            'region' => 'D',
            'roles' => "Anggota",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('accounts')->insert([
            'name' => "Warren",
            'email' => "warren@gmail.com",
            'password' => bcrypt('123'),
            'photo' => 'default.jpg',
            'address' => '1000 Main Street',
            'birth_place_date' => 'Surabaya, 20-5-1995',
            'region' => 'E',
            'roles' => "Anggota",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('accounts')->insert([
            'name' => "Richard",
            'email' => "richard@gmail.com",
            'password' => bcrypt('123'),
            'photo' => 'default.jpg',
            'address' => '1050 Main Street',
            'birth_place_date' => 'Surabaya, 20-5-1995',
            'region' => 'F',
            'roles' => "Pengurus",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
