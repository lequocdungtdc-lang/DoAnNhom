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
use Illuminate\Support\Str;

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

    public function showPayment(Request $request, Plan $plan): View
    {
        if (!$plan->status) {
            return redirect()->route('plans.index')->with([
                'status' => 'error',
                'message' => 'Gói này hiện không khả dụng.',
            ]);
        }

        $orderId = 'ORD' . now()->format('YmdHis') . Str::random(4);
        $amount = (int) $plan->price;
        $orderInfo = "Thanh toan goi {$plan->name} - {$plan->duration_days} ngay";

        return view('web.plans.payment', [
            'plan' => $plan,
            'orderId' => $orderId,
            'amount' => $amount,
            'orderInfo' => $orderInfo,
        ]);
    }

    public function vnpayReturn(Request $request): RedirectResponse
    {
        $vnp_ResponseCode = $request->get('vnp_ResponseCode', '99');
        $planId = $request->get('plan_id');
        $paymentMethod = $request->get('payment_method', 'vnpay');
        $plan = Plan::find($planId);

        if (!$plan) {
            return redirect()->route('plans.index')->with([
                'status' => 'error',
                'message' => 'Không tìm thấy gói đăng ký.',
            ]);
        }

        if ($vnp_ResponseCode === '00') {
            $user = $request->user();
            $activeSubscription = $user->activeSubscription;

            if ($activeSubscription) {
                $newExpiresAt = $activeSubscription->expires_at->addDays($plan->duration_days);

                $subscription = Subscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'starts_at' => now(),
                    'expires_at' => $newExpiresAt,
                    'status' => true,
                    'payment_method' => $paymentMethod,
                ]);
            } else {
                $subscription = Subscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'starts_at' => now(),
                    'expires_at' => now()->addDays($plan->duration_days),
                    'status' => true,
                    'payment_method' => $paymentMethod,
                ]);
            }

            ActivityLog::create([
                'module' => 'Subscription',
                'action' => 'CREATE',
                'title' => 'User #' . $user->id . ' subscribed to ' . $plan->name . ' via VNPay',
                'user_id' => $user->id,
            ]);

            return redirect()->route('plans.index')->with([
                'status' => 'success',
                'message' => "Thanh toán gói \"{$plan->name}\" thành công! Bạn đã có thể nghe các bài hát VIP và không còn quảng cáo.",
            ]);
        }

        return redirect()->route('plans.index')->with([
            'status' => 'error',
            'message' => 'Thanh toán bị hủy hoặc thất bại. Vui lòng thử lại.',
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
