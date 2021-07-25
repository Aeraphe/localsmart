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
    ];

    /**
     * Add All Equipament conditions
     *
     * @param array $conditions
     * @return void
     */
    public function addEquipamentConditions(array $conditions)
    {
        foreach ($conditions as $condition) {
            InvoiceEquipamentCondition::create(['name' => $condition, 'repair_invoice_id' => $this->id]);

        }
    }
}
