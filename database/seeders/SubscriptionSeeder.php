<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $plan1 = Plan::find(1);
        $plan2 = Plan::find(2);
        $plan3 = Plan::find(3);

        $start1 = Carbon::parse('2026-05-01');
        $start2 = Carbon::parse('2026-04-10');
        $start3 = Carbon::parse('2026-03-14');

        Subscription::create([
            'user_id' => 1,
            'plan_id' => $plan1->id,
            'starts_at' => $start1,
            'expires_at' => (clone $start1)
                ->addDays($plan1->duration_days),
            'status' => true,
        ]);

        Subscription::create([
            'user_id' => 2,
            'plan_id' => $plan2->id,
            'starts_at' => $start2,
            'expires_at' => (clone $start2)
                ->addDays($plan2->duration_days),
            'status' => true,
        ]);

        Subscription::create([
            'user_id' => 3,
            'plan_id' => $plan3->id,
            'starts_at' => $start3,
            'expires_at' => (clone $start3)
                ->addDays($plan3->duration_days),
            'status' => true,
        ]);
        Subscription::create([
            'user_id' => 4,
            'plan_id' => $plan3->id,
            'starts_at' => $start3,
            'expires_at' => (clone $start3)
                ->addDays($plan3->duration_days),
            'status' => true,
        ]);
        Subscription::create([
            'user_id' => 5,
            'plan_id' => $plan3->id,
            'starts_at' => $start3,
            'expires_at' => (clone $start3)
                ->addDays($plan3->duration_days),
            'status' => true,
        ]);
        Subscription::create([
            'user_id' => 6,
            'plan_id' => $plan1->id,
            'starts_at' => $start1,
            'expires_at' => (clone $start1)
                ->addDays($plan1->duration_days),
            'status' => true,
        ]);
        Subscription::create([
            'user_id' => 7,
            'plan_id' => $plan1->id,
            'starts_at' => $start1,
            'expires_at' => (clone $start1)
                ->addDays($plan1->duration_days),
            'status' => true,
        ]);
        Subscription::create([
            'user_id' => 8,
            'plan_id' => $plan2->id,
            'starts_at' => $start2,
            'expires_at' => (clone $start2)
                ->addDays($plan2->duration_days),
            'status' => true,
        ]);
    }
}