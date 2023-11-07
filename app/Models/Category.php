<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'showHome',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function scopeOrWithName($query, $name)
    {
        return $name ? $query->orWhere('name', 'LIKE', "%$name%") : $query;
    }

    public function search($name)
    {
        return Category::orWithName($name)
            ->latest('id')->paginate(10)
            ->withQueryString();
    }
}
