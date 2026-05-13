<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Plan extends Model
{
    protected $fillable = [
        'name',
        'duration_days',
        'price',
        'status',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}