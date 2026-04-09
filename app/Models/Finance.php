<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'total',
        'desc',
        'type',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
