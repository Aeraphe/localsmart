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

    /**
     * Get Equipament that the condition belongs
     *
     * @return App\Models\Equipament
     */
    public function equipament()
    {
        return $this->belongsTo(Equipament::class);
    }

    /**
     * Get RepairInvoice from Equipament Condition belongs
     *
     * @return App\Models\RepairInvoice
     */
    public function repairInvoice()
    {
        return $this->belongsTo(RepairInvoice::class);
    }
}
