<?php

namespace Modules\Gadget\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GadgetCheckItem extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'gadget_id',
        'risk',
        'procedure',
        'level',

    ];

    protected static function newFactory()
    {
        return \Modules\Gadget\Database\factories\GadgetCheckItemFactory::new ();
    }
}
