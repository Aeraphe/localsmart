<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipament extends Model
{
    use HasFactory;

    /**
     * Attribute that are mass assignable
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'name',
        'gadget_id',
    ];

    /**
     * Get equipament customer owner
     *
     * @return Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
