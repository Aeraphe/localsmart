<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceEquipamentCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'equipament_id',
        'repair_invoice_id',
    ];
}
