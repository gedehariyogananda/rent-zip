<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costum extends Model
{
    use HasFactory;

    protected $table = "costums";

    protected $appends = ["rented_stock", "available_stock"];

    protected $fillable = [
        "photo_url",
        "name",
        "source",
        "size",
        "stock",
        "priceday",
        "desc",
        "category_id",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function getRentedStockAttribute()
    {
        return $this->orderItems()
            ->whereHas("order", function ($query) {
                $query->where("status", "paid");
            })
            ->sum("pcs") ?? 0;
    }

    public function getAvailableStockAttribute()
    {
        return $this->stock - $this->rented_stock;
    }
}
