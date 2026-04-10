<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ["name", "desc", "type"];

    public function costums()
    {
        return $this->hasMany(Costum::class);
    }

    public function finances()
    {
        return $this->hasMany(Finance::class);
    }
}
