<?php

namespace Modules\Gadget\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected static function newFactory()
    {
        return \Modules\Gadget\Database\factories\ManufacturerFactory::new ();
    }
}
