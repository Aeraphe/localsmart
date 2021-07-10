<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'account_id',
        'email',
        'cpf',
        'phone',
        'msg_app_number',
        'city',
        'state',
        'address',
        'obs',

    ];
}
