<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::latest()->paginate(10),
            'totalUsers' => User::count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.form', [
            'userItem' => new User(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:admin,user'],
            'status' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'min:6'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('status', 'Tạo người dùng thành công.');
    }

    public function edit(int $id): View
    {
        return view('admin.users.form', [
            'userItem' => User::findOrFail($id),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:admin,user'],
            'status' => ['nullable', 'string', 'max:50'],
            'password' => ['nullable', 'min:6'],
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('status', 'Cập nhật người dùng thành công.');
    }

    public function delete(int $id): RedirectResponse
    {
        User::findOrFail($id)->delete();

        return redirect()->route('admin.users.index')
            ->with('status', 'Xóa người dùng thành công.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:users,id'],
        ]);

        User::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('admin.users.index')
            ->with('status', 'Xóa các người dùng đã chọn thành công.');
    }
}
