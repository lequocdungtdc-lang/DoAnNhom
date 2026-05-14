<?php


namespace App\Http\Controllers;

use App\Models\Song; // Đảm bảo bạn đã import model Song
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Để ghi log gỡ lỗi

class SongController extends Controller
{

    public function index()
    {
        $data = Song::all();
        // trả về json
        return response()->json(
            [
                'data' => $data
            ]
        );
    }
}
