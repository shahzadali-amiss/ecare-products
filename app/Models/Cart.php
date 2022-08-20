<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function scopeAvailable($query)
    {
        return $query->where('order_id', null);
    }

    public function scopeVisitor($query, $request)
    {
        return $query->where('user_id', $request->user_id ?? \Auth::user()->id ?? null)->orWhere('visitor_id', $request->visitor_id ?? \Cookie::get('visitor_id'));
    }

    public function product(){
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
