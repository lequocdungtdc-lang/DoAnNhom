<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // 🔥 Dashboard
    public function dashboard()
    {
        return response()->json([
            'message' => 'Welcome Admin',
            'total_users' => User::count(),
        ]);
    }

    // 🔥 List users
    public function users()
    {
        return response()->json([
            'users' => User::select('id', 'fullname', 'email', 'role')->get()
        ]);
    }

    // 🔥 Delete user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // ❌ không cho xoá chính mình (optional)
        if (auth()->id() == $user->id) {
            return response()->json([
                'message' => 'Không thể xoá chính bạn'
            ], 400);
        }

        $user->delete();

        return response()->json([
            'message' => 'Đã xoá user'
        ]);
    }
}