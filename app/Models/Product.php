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
}
