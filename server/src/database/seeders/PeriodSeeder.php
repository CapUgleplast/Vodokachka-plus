<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Period;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Period::factory()->count(50)->make();
    }
}
