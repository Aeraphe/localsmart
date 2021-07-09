<?php

namespace App\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
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
     * Create a relationship with User and Account (Composition)
     *
     * @return App\Account
     */
    public function account()
    {
        return $this->hasOne(Account::class);
    }

    /**
     * User create a new Store
     *
     * @param array $data Contain data for create the store
     * 
     *    $data[
     *      'name'    =>    (string) Store name 
     *      'address' =>    (string) Store address
     *      'phone'   =>    (string) Store phone number 
     *     ]
     * 
     * @return App\Sotre | null
     */
    public function createStore(array $data)
    {

        $data['user_id'] = $this->id;

        if ($this->canCreateStores()) {
            return Store::create($data);
        } else {
            return null;
        }

    }

    /**
     * Check is user can create sotre
     * 
     * @return boolean
     */
    public function canCreateStores()
    {
        $account = $this->account;
        $store = $this->store;
        if ($account->plan_status) {
            if ($store == null) {
                return true;
            } elseif ($store->count() <= $account->store_qt) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

}
