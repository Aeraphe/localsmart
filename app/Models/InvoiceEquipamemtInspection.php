<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceEquipamemtInspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_invoice_id',
        'equipament_id',
        'name',
    ];
}
