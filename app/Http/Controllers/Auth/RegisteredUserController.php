<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Session; 

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if($request->role=='c'){
            $request->validate([ 'otp' => 'required|digits:6', ]);
        }
        $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['numeric','digits:10'],
            'role' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user_exist=isUserExist($request->mobile, $request->role);
        if(!$user_exist){
            if($request->role=='c'){ 
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'password' => Hash::make($request->password),
                ]);
            }else{
                if($request->otp==Session::get('otp')){
                    $user = User::create([
                        'email' => $request->email,
                        'mobile' => $request->mobile,
                        'password' => Hash::make($request->password),
                    ]); 
                    Session::forget('otp');
                }else{
                    Session::forget('otp');
                    return back()->with('status','Entered wrong OTP');
                }   
                  
            }
            event(new Registered($user));

            $role = Role::create([
                'type' => $request->role,
                'user_id' => $user->id,
            ]);
            
            if(Auth::check()){
                Session::flush();
                dd(Session::all());
                Auth::logout();
            }
            Auth::login($user);
            if($request->role=='c'){
                Session::put('role','c');
                return redirect(RouteServiceProvider::HOME);
            }else{
                Session::put('role','s');
                return redirect(RouteServiceProvider::SUPPLIER);
            }
        }else{
            return back()->with('status','User already exist with this mobile number');
        }
    }
}
