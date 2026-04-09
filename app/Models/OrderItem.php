<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'costum_id',
        'pcs',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function costum()
    {
        return $this->belongsTo(Costum::class);
    }
}
