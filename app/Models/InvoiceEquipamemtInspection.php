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

    /**
     * Get the equipament that inspetion belongs
     *
     * @return App\Models\Equipament
     */
    public function equipament()
    {
        return $this->belongsTo(Equipament::class);
    }

    /**
     * Get Invoice That equipament that inspetion belongs
     *
     * @return App\Models\Equipament
     */
    public function repairInvoice()
    {
        return $this->belongsTo(RepairInvoice::class);
    }
}
