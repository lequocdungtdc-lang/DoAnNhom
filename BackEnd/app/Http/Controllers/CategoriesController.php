<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
   // list
    public function index()
    {
        $data = Categories::all();
        // trả về json 
        return response()->json($data);
    }

    // form create
    // public function create()
    // {
    //     return view('categories.create');
    // }

    // lưu dữ liệu
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'tentheloai' => 'required',
    //     ]);

    //     Categories::create([
    //         'tentheloai' => $request->tentheloai,
    //         'nhom' => $request->nhom,
    //         'image' => $request->image,
    //         'description' => $request->description,
    //         'status' => $request->status ?? 1,
    //     ]);

    // }
}
