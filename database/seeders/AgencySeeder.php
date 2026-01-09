<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Agency::create(['name' => 'Elite Events', 'country' => 'Hungary', 'type' => 'A']);
        \App\Models\Agency::create(['name' => 'Global Agency', 'country' => 'Germany', 'type' => 'B']);
        \App\Models\Agency::create(['name' => 'Party Masters', 'country' => 'Austria', 'type' => 'C']);
    }
}
