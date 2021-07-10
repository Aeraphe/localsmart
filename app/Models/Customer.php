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

    /**
     * Get account that customer is localted
     *
     *@return Collection
     */
    public function account()
    {

        return $this->belongsTo(Account::class);
    }

    /**
     * Get Customer equipaments
     *
     * @return Collection<Equipaments>
     */
    public function equipaments()
    {
        return $this->hasMany(Equipament::class);
    }

}
