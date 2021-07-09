<?php

namespace App\Models;

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


}
