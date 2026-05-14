<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $plans = Plan::all();

        if ($users->isEmpty() || $plans->isEmpty()) {
            return;
        }

        foreach ($users as $user) {

            // Random plan
            $plan = $plans->random();

            // Random ngày bắt đầu
            $startsAt = Carbon::now()
                ->subDays(rand(1, 30));

            // Tính ngày hết hạn
            $expiresAt = (clone $startsAt)
                ->addDays($plan->duration_days);

            Subscription::create([
                'user_id' => $user->id,

                'plan_id' => $plan->id,

                'starts_at' => $startsAt,

                'expires_at' => $expiresAt,

                'status' => true,
            ]);
        }
    }
}