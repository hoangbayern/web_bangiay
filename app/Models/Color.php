<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeOrWithName($query, $name)
    {
        return $name ? $query->orWhere('name', 'LIKE', "%$name%") : $query;
    }

    public function search($name)
    {
        return Color::orWithName($name)
            ->latest('id')->paginate(10)
            ->withQueryString();
    }
}
