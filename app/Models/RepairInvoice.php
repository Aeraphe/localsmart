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
     * Add Equipament conditions from given array
     *
     * @param array $conditions
     * @return void
     */
    public function addEquipamentConditions(array $conditions)
    {
        foreach ($conditions as $condition) {
            InvoiceEquipamentCondition::create([
                'name' => $condition,
                'repair_invoice_id' => $this->id,
                'equipament_id' => $this->equipament->id,
            ]);

        }
    }

    /**
     * Add Equipament Inspetions from given array
     *
     * @param array $inpections
     * @return void
     */
    public function addEquipamentInspections(array $inpections)
    {

        foreach ($inpections as $inpection) {
            InvoiceEquipamemtInspection::create([
                'name' => $inpection,
                'equipament_id' => $this->equipament->id,
                'repair_invoice_id' => $this->id,
            ]);
        }
    }

    /**
     * Get all Repair Status for the RepairInvoice
     *
     * @return App\Models\RepaisInvoice\Status
     */
    public function status()
    {

        return $this->hasMany(RepairInvoiceStatus::class);
    }

    /**
     * Get store that Repair Invoice belongs
     *
     * @return void
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get Equipament that belongs to the RepairInvoice
     *
     * @return void
     */
    public function equipament()
    {
        return $this->belongsTo(Equipament::class);
    }

    /**
     * Get Equipament Conditions that belongs to the RepairInvoice
     *
     * @return void
     */
    public function conditions()
    {
        return $this->hasMany(InvoiceEquipamentCondition::class);
    }

}
