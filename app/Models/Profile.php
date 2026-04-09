<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'avatar_url',
        'nik_url',
        'no_darurat',
        'ktp_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
