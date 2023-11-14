<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const INACTIVE = 0;

    const ACTIVE = 1;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

//    public function setPasswordAttribute($value)
//    {
//        if ($value) {
//            $this->attributes['password'] = bcrypt($value);
//        }
//    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function scopeOrWithNameOrEmailOrId($query, $searchTerm)
    {
        return $searchTerm ? $query->orWhere('name', 'LIKE', "%$searchTerm%")
            ->orWhere('email', 'LIKE', "%$searchTerm%")
            ->orWhere('id', 'LIKE', "%$searchTerm%") : $query;
    }

    public function search($searchTerm)
    {
        return User::orWithNameOrEmailOrId($searchTerm)
            ->latest('id')->paginate(10)
            ->withQueryString();
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
