<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PlanController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required'],
            'duration_days' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        Plan::create($validated);

        return redirect()->route('admin.plans.index')->with([
            'status' => 'success',
            'message' => 'Tạo gói cước thành công.',
        ]);
    }
}
