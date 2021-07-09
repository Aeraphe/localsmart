<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * The Attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'plan_name',
        'plan_status',
        'store_qt',
        'user_id',
    ];

    /**
     * Create a relationship with user
     *
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
