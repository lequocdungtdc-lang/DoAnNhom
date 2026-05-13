<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name' => 'Gói 1 tháng',
            'duration_days' => 30,
            'price' => 99000,
            'status' => true,
        ]);

        Plan::create([
            'name' => 'Gói 6 tháng',
            'duration_days' => 180,
            'price' => 499000,
            'status' => true,
        ]);

        Plan::create([
            'name' => 'Gói 1 năm',
            'duration_days' => 365,
            'price' => 899000,
            'status' => true,
        ]);
    }
}