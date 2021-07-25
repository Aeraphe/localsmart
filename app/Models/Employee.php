<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use HasFactory, HasApiTokens, HasRoles;

    /**
     * Attribute mass assignable
     * @var array
     */
    protected $fillable = [
        'account_id',
        'name',
        'phone',
        'address',
        'login_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return the stores that employee can access
     *
     * @return Coleciton<App\Models\Store>
     */
    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }


    /**
     * Get account that employee is part
     *
     * @return App\Models\Account
     */
    public function account()
    {
       return $this->belongsTo(Account::class);
    }

}
