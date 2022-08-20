<?php

namespace App\Helper;

use Illuminate\Http\Request;

class Helper{

    private static $categories = [];
    public static function getCategories(){
        if(empty(self::$categories))
            self::$categories = \App\Models\Category::where('status', true)->where('category_type', 1)->get();
        
        return self::$categories;
    }

} 

?>