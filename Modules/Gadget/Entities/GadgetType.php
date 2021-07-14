<?php

namespace Modules\Gadget\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GadgetType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    
    protected static function newFactory()
    {
        return \Modules\Gadget\Database\factories\GadgetTypeFactory::new();
    }
}
