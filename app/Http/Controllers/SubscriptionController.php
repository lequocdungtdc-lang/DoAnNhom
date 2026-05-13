<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\User;

class SubscriptionController extends Controller
{
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

                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        return view('admin.subscriptions.index', [
            'subscriptions' => $query
                ->paginate(10)
                ->withQueryString(),
        ]);
    }
    
}
