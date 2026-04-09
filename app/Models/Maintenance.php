<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        "costum_id",
        "current_stock",
        "category_id",
        "type",
        "pcs",
        "desc",
    ];

    public function costum()
    {
        return $this->belongsTo(Costum::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
