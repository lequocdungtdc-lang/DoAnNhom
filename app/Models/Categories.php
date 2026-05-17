<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'group_name',
        'image',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}