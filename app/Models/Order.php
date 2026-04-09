<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code_booking',
        'status',
        'qris',
        'total',
        'tgl_sewa',
        'tgl_pengembalian',
    ];

    protected $casts = [
        'tgl_sewa' => 'date',
        'tgl_pengembalian' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
