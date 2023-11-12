<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddresses extends Model
{
    use HasFactory;

    protected $table = 'customer_addresses';

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'email',
        'province',
        'district',
        'ward',
        'address',
        'notes',
    ];
}
