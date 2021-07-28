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
        'slug',
        'address',
        'phone',
        'account_id',
        'status',
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

    /**
     * Get employee that are loaded in store
     *
     * @return Colection<App\Models\Employee>
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    /**
     * Get Repair Invoices from store
     *
     * @return void
     */
    public function repairInvoice()
    {
        return $this->hasMany(RepairInvoice::class);
    }
}
