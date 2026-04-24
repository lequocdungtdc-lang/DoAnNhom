<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    // Chỉ định chính xác tên bảng trong Database
    protected $table = 'albums';

    // Các cột được phép nạp dữ liệu hàng loạt
    protected $fillable = [
        'ten_album',
        'nghe_si',
        'anh_bia',
        'status',
    ];

    // Ép kiểu dữ liệu khi lấy ra từ DB (rất quan trọng cho Vue.js)
    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}