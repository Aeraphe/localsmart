<?php

namespace Modules\Gadget\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairRisk extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'dificult',
        'repair_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Gadget\Database\factories\RepairRiskFactory::new ();
    }
}
