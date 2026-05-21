<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class PlanController extends Controller
{
    public function index(): View
    {
        $plans = Plan::where('status', true)->get();
        $currentSubscription = auth()->user()?->activeSubscription;
        $hasActiveSubscription = $currentSubscription ? true : false;

        return view('web.plans.index', [
            'plans' => $plans,
            'currentSubscription' => $currentSubscription,
            'hasActiveSubscription' => $hasActiveSubscription,
        ]);
    }

    public function subscribe(Request $request, Plan $plan): RedirectResponse
    {
        if (!$plan->status) {
            return back()->with([
                'status' => 'error',
                'message' => 'Gói này hiện không khả dụng.',
            ]);
        }

        $activeSubscription = $request->user()->activeSubscription;

        if ($activeSubscription) {
            $newExpiresAt = $activeSubscription->expires_at->addDays($plan->duration_days);

            $subscription = Subscription::create([
                'user_id' => $request->user()->id,
                'plan_id' => $plan->id,
                'starts_at' => now(),
                'expires_at' => $newExpiresAt,
                'status' => true,
            ]);
        } else {
            $subscription = Subscription::create([
                'user_id' => $request->user()->id,
                'plan_id' => $plan->id,
                'starts_at' => now(),
                'expires_at' => now()->addDays($plan->duration_days),
                'status' => true,
            ]);
        }

        ActivityLog::create([
            'module' => 'Subscription',
            'action' => 'CREATE',
            'title' => 'User #' . $request->user()->id . ' subscribed to ' . $plan->name,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('plans.index')->with([
            'status' => 'success',
            'message' => 'Đăng ký gói "' . $plan->name . '" thành công! Bạn đã có thể nghe các bài hát VIP và không còn quảng cáo.',
        ]);
    }
}
