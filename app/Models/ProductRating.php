<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    use HasFactory;

    protected $table = 'product_ratings';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeOrWithName($query, $name)
    {
        return $name ? $query->orWhere('username', 'LIKE', "%$name%") : $query;
    }

    public function search($name)
    {
        return ProductRating::orWithName($name)
            ->latest('id')->paginate(10)
            ->withQueryString();
    }
}
