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
        'image',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class)->withTimestamps();
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class)->withTimestamps();
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
