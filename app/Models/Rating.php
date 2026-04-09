<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rating',      // nullable, diisi saat user submit prompt
        'is_submitted',
    ];

    protected $casts = [
        'is_submitted' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
