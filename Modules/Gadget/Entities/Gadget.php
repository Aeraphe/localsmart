<?php

namespace Modules\Gadget\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gadget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gadget_type_id',
        'manufacturer_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Gadget\Database\factories\GadgetFactory::new ();
    }
}
