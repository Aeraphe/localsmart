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
     * The attributes that should be mutated to dates.
     * soft deleted
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get equipament customer owner
     *
     * @return Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get Equipament Repair Invoices
     *
     * @return void
     */
    public function repairInvoices()
    {
        return $this->hasMany(RepairInvoice::class);
    }

    /**
     * Get all conditions that equipament reveived from invoices
     *
     * @return Collection<App\Models\InvoiceEquipamentCondition>
     */
    public function conditions()
    {
        return $this->hasMany(InvoiceEquipamentCondition::class);
    }

    /**
     * Get all equipament inspetions from invoices
     *
     * @return Collection<App\Models\InvoiceEquipamemtInspection>
     */
    public function inspections()
    {

        return $this->hasMany(InvoiceEquipamemtInspection::class);
    }

}
