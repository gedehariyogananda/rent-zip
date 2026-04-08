<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function categoryProyek()
    {
        return $this->belongsTo(CategoryProyek::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
