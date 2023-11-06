<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'gender',
        'price',
        'compare_price',
        'category_id',
        'is_featured',
        'qty',
        'track_qty',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class)->withTimestamps();
    }

    public function syncColors($colorIds): array
    {
        return $this->colors()->sync($colorIds);
    }


    public function sizes()
    {
        return $this->belongsToMany(Size::class)->withTimestamps();
    }

    public function syncSizes($sizeIds): array
    {
        return $this->sizes()->sync($sizeIds);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withTimestamps()->withPivot('qty', 'price', 'total', 'color', 'size');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function scopeWithCategory($query, $id)
    {
        return $id ? $query->whereHas('category', function ($query) use ($id) {
            $query->where('id', $id);
        }) : null;
    }

    public function scopeWithName($query, $name)
    {
        return $name ? $query->orWhere('name', 'LIKE', "%$name%") : $query;
    }

    public function scopeWithPriceFrom($query, $price)
    {
        return $price ? $query->where('price', '>=', $price) : null;
    }

    public function scopeWithPriceTo($query, $price)
    {
        return $price ? $query->where('price', '<=', $price) : null;
    }


    public function search($dataSearch)
    {
        return Product::withName($dataSearch['name'] ?? null)
            ->withCategory($dataSearch['category'] ?? null)
            ->withPriceFrom($dataSearch['price_from'] ?? null)
            ->withPriceTo($dataSearch['price_to'] ?? null)
            ->latest('id')->paginate(10)->withQueryString();
    }

}
