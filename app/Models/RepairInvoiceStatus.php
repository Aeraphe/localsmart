<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairInvoiceStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_invoice_id',
        'description',
        'status',
    ];



    /**
     * Get invoice owner of RepairInvoiceStatus
     *
     * @return App\Models\RepairInvoice
     */
    public function repairInvoice(){

        return $this->belongsTo(RepairInvoice::class);
    }
}
