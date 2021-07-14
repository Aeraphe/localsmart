<?php

namespace Modules\Gadget\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'dificult',
        'operation',
        'gadget_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Gadget\Database\factories\RepairFactory::new ();
    }
}
