<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'user_id',
    ];

    /**
     * Create a relationship to User - One To Many
     * Get te user that owns the store
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
