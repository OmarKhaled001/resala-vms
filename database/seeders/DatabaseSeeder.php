<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Branch;
use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LaratrustSeeder::class);
        // $this->call(ContributionSeeder::class);
        // $this->call(SectionSeeder::class);
        // $this->call(ActivitySeeder::class);
        // $this->call(BranchSeeder::class);
    }
}
