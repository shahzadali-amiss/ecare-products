<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
 
class UserController extends Controller
{
    public function showUser($type=''){
        // dd($type);
        if ($type == 'costumers') {
            $data['users'] = User::where(['role'=>'C'])->get();
            $data['type'] = $type;
        }
        elseif ($type == 'supplires') {
            $data['users'] = User::where(['role'=>'S'])->get();
            $data['type'] = $type;
        }
        else{        
            $data['users'] = User::all();
            $data['type'] = 'All Users';
        }

        return view('admin.all-users', $data);
    }

    // public function 
}
