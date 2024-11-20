<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AccountSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(AnnouncementSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(MeetSeeder::class);
        $this->call(MisaSeeder::class);
        $this->call(TrainingSeeder::class);
        $this->call(TemplateSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(AnnouncementDetailSeeder::class);
        $this->call(EventDetailSeeder::class);
        $this->call(EventPermissionSeeder::class);
        $this->call(GroupDetailSeeder::class);
        $this->call(MisaDetailSeeder::class);
        $this->call(MisaPermissionSeeder::class);
        $this->call(TemplatePermissionSeeder::class);
        $this->call(TrainingDetailSeeder::class);
    }
}
