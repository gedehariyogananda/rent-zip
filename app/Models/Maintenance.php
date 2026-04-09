<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'costum_id',
        'pcs',
        'is_wash',
    ];

    protected $casts = [
        'is_wash' => 'boolean',
    ];

    public function costum()
    {
        return $this->belongsTo(Costum::class);
    }
}
