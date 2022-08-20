<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Product extends Model
{
    use HasFactory;

    public function category(){
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }

    public function images(){
        return $this->hasMany('App\Models\Image', 'type_id', 'id')->where('type', 'p');
    }

    public function getDiscountPercentageAttribute(){
        return round(($this->mrp - $this->offer_price) / $this->mrp * 100);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
} 
