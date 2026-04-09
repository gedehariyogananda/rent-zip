<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'costum_id',
        'pcs',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function costum()
    {
        return $this->belongsTo(Costum::class);
    }
}
