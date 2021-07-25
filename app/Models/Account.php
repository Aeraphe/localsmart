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
        'slug',
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

    /**
     * Change the account status
     * @return void
     */
    public function changeAccountStatus($status)
    {
        $this->plan_status = $status;
        $this->save();

    }

    /**
     * Get account customers
     *
     * @return Collection
     */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get account stores
     *
     * @return Collection<App\Models\Store>
     */
    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    /**
     * Check is user can create sotre
     *
     * @return boolean
     */
    public function canCreateStore()
    {

        $stores = $this->stores;

        if ($this->plan_status) {
            if ($stores == []) {

                return true;

            } elseif ($stores->count() < $this->store_qt) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * Get employees from account
     *
     * @return Collection<Employee>
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

}
