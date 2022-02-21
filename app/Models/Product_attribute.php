<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute_value;


class Product_attribute extends Model
{
    use HasFactory;

    function getAttributeValues(){
    	return $this->hasOne(Attribute_value::class, 'id', 'attribute_value_id');
    }
}
