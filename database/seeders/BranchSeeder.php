<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Branch::create([
            'name' => 'Chicago HQ',
            'city' => 'Chicago',
            'address' => '123 Windy City Blvd, IL 60601',
            'is_active' => true,
        ]);

        \App\Models\Branch::create([
            'name' => 'New York Hub',
            'city' => 'New York',
            'address' => '456 Liberty Ave, NY 10001',
            'is_active' => true,
        ]);

        \App\Models\Branch::create([
            'name' => 'LA Terminal',
            'city' => 'Los Angeles',
            'address' => '789 Sunset Strip, CA 90001',
            'is_active' => true,
        ]);
    }
}
