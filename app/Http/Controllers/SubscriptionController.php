<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function create(): View
    {
        return view('admin.subscriptions.form', [
            'subscription' => new Subscription(),
            'isEdit' => false,
            'users' => User::all(),
            'plans' => Plan::all(),
        ]);
    }

    public function edit(int $id): View
    {
        return view('admin.subscriptions.form', [
            'subscription' => Subscription::findOrFail($id),
            'isEdit' => true,
            'users' => User::all(),
            'plans' => Plan::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'plan_id' => ['required', 'exists:plans,id'],
            'starts_at' => ['required', 'date'],
            'status' => ['nullable', 'boolean'],
        ]);

        // Lấy plan
        $plan = Plan::findOrFail($validated['plan_id']);

        // Tính ngày hết hạn
        $validated['expires_at'] = now()
            ->parse($validated['starts_at'])
            ->addDays($plan->duration_days);

        $validated['status'] = $request->boolean('status');

        Subscription::create($validated);

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('status', 'Tạo subscription thành công.');
    }
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = Subscription::with([
            'user',
            'plan'
        ])->latest();

        if (!empty($search) && mb_strlen($search) > 2) {

            $query->whereHas('user', function ($q) use ($search) {

                $q->where('fullname', 'like', '%' . $search . '%');
            });
        }
        // Tổng subscription
        $totalSubscriptions = Subscription::count();

        // Tổng doanh thu
        $totalRevenue = Subscription::join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price');
        // Revenue theo tháng, dựa trên tháng bắt đầu của subscription
        $monthlyRevenue = Subscription::join(
            'plans',
            'subscriptions.plan_id',
            '=',
            'plans.id'
        )
            ->whereYear(
                'subscriptions.starts_at',
                now()->year
            )
            ->select(
                DB::raw('MONTH(subscriptions.starts_at) as month'),
                DB::raw('SUM(plans.price) as revenue')
            )
            ->groupBy(DB::raw('MONTH(subscriptions.starts_at)'))
            ->orderBy('month')
            ->get();

        // Labels chart
        $chartLabels = $monthlyRevenue->pluck('month');

        // Revenue chart
        $chartRevenue = $monthlyRevenue->pluck('revenue');
        return view('admin.subscriptions.index', [
            'subscriptions' => $query
                ->paginate(10)
                ->withQueryString(),
            'totalSubscriptions' => $totalSubscriptions,
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'chartLabels' => $chartLabels,
            'chartRevenue' => $chartRevenue,
        ]);
    }
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'plan_id' => ['required', 'exists:plans,id'],
            'starts_at' => ['required', 'date'],
            'status' => ['nullable', 'boolean'],
        ]);

        // Lấy plan
        $plan = Plan::findOrFail($validated['plan_id']);

        // Tính lại ngày hết hạn
        $validated['expires_at'] = Carbon::parse($validated['starts_at'])
            ->addDays($plan->duration_days);

        $validated['status'] = $request->boolean('status');

        // Tìm subscription
        $subscription = Subscription::findOrFail($id);

        // Update
        $subscription->update($validated);
        ActivityLog::create([
            'module' => 'Subscription',
            'action' => 'Cập nhật subscription',
            'title' => 'Subscription #' . $subscription->id,
            'user_id' => auth()->id(),
        ]);
        return redirect()
            ->route('admin.subscriptions.index')
            ->with('status', 'Cập nhật subscription thành công.');
    }
    public function delete(int $id): RedirectResponse
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->delete();

        ActivityLog::create([
            'module' => 'Subscription',
            'action' => 'Xóa subscription',
            'title' => 'Subscription #' . $subscription->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('status', 'Xóa subscription thành công.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:subscriptions,id'],
        ]);

        $subscriptions = Subscription::whereIn('id', $validated['ids'])->get();

        foreach ($subscriptions as $subscription) {
            $subscriptionId = $subscription->id;
            $subscription->delete();

            ActivityLog::create([
                'module' => 'Subscription',
                'action' => 'Xóa subscription',
                'title' => 'Subscription #' . $subscriptionId,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('status', 'Xóa các subscription đã chọn thành công.');
    }
}
