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
        'sulg',
        'address',
        'phone',
        'account_id',
    ];

    /**
     * Create a relationship to Account - One To Many
     * Get te Account that owns the store
     *
     * @return App\Models\Account
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
