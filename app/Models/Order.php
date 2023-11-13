<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty', 'price', 'total', 'color', 'size')->withTimestamps();
    }

    public function scopeOrWithNameOrEmailOrId($query, $searchTerm)
    {
        return $searchTerm ? $query->orWhere('full_name', 'LIKE', "%$searchTerm%")
            ->orWhere('email', 'LIKE', "%$searchTerm%")
            ->orWhere('id', 'LIKE', "%$searchTerm%") : $query;
    }

    public function search($searchTerm)
    {
        return Order::orWithNameOrEmailOrId($searchTerm)
            ->latest('id')->paginate(10)
            ->withQueryString();
    }

}
