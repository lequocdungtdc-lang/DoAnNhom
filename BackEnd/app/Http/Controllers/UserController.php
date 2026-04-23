<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ✅ REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'user' // 🔥 mặc định
        ]);

        return response()->json([
            'message' => 'Đăng ký thành công',
            'user' => $this->formatUser($user)
        ]);
    }

    // ✅ LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Sai email hoặc mật khẩu'
            ], 401);
        }

        $token = $user->createToken('user-token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'token' => $token,
            'user' => $this->formatUser($user) // 🔥 chuẩn
        ]);
    }

    // ✅ PROFILE
    public function profile(Request $request)
    {
        return response()->json([
            'user' => $this->formatUser($request->user())
        ]);
    }

    // ✅ UPDATE PROFILE
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $user->update([
            'fullname' => $request->fullname ?? $user->fullname,
            'phone' => $request->phone ?? $user->phone,
            'address' => $request->address ?? $user->address
        ]);

        return response()->json([
            'message' => 'Cập nhật thông tin thành công',
            'user' => $this->formatUser($user)
        ]);
    }

    // ✅ LOGOUT
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Đã đăng xuất'
        ]);
    }

    // 🔥 FORMAT USER (QUAN TRỌNG)
    private function formatUser($user)
    {
        return [
            'id' => $user->id,
            'fullname' => $user->fullname,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'role' => $user->role,
        ];
    }
}