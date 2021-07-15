<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'equipament_id',
        'budget',
        'fail_description',
        'status',
    ];
}
