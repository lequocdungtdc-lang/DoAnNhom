<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    // Hiển thị danh sách album
   public function index()
    {
        $data = Album::all();
        // trả về json 
        return response()->json(
            [
                'data' => $data
            ]
        );
    }
}
