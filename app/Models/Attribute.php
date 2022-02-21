<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    function getAttributeValues(){
    	return $this->hasMany(Attribute_value::class, 'attribute_id', 'id');
    }
}
