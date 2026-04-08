<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProyek extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function proyek()
    {
        return $this->hasMany(Proyek::class);
    }
}
