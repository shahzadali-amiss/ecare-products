<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request; 

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Attribute;
use App\Models\Attribute_value;
use App\Models\Product_attribute;
// use App\Models\ProductAttributeValue;
use App\Models\BannerAds;
use Illuminate\Validation\Rules;
use App\Models\OTP;
use Validator;
use Session; 
  

class FrontController extends Controller
{

    public function updateCart(Request $request){
        // dd($request->all());
        foreach($request->cart as $cart_id => $values){
            $cart = \App\Models\Cart::find($cart_id);
            $cart->quantity = $values['quantity'];
            $cart->save();
        }
        return back()->with('success', 'Cart Updated');
    }

    public function cart(Request $request){
        if($request->isMethod('get')){
            $data['items'] = \App\Models\Cart::visitor($request)->with('product')->available()->get();
            return view('shop.cart', $data);  
        }else{
            $request->validate([
                'quantity.*' => 'required|numeric|min:1|max:5',
            ]);
            // dd($request->all());
            foreach ($request->quantity as $key => $q) {
                foreach (getCartProducts() as $index => $p) {
                    if($key==$index){    
                        if(!setCartProductQuantity($p->id, $q)){
                            return back()->with('error','Something went wrong! Please try again');
                        } 
                    }
                }
            }

            return redirect()->route('checkout-details');
        }
    }

    public function checkoutShipping(Request $request){
        if($request->isMethod('get')){
            // $data = $this->getAllData();
            $data = [];
            return view('shop.checkout-shipping', $data);
        }else{
            dd('');
        }
    }

    public function checkoutReview(Request $request){
        if($request->isMethod('get')){
            // $data = $this->getAllData();        
            $data = [];
            return view('shop.checkout-review', $data);
        }
    }

    public function customerRegister(Request $request){
        if($request->isMethod('get')){    
            return view('auth.register');
        }else{
            $request->validate([
                'mobile' => ['numeric','digits:10'],
                'role' => ['required'],
                'password' => ['required', Rules\Password::defaults()],
            ]);
            $is_user_exist=getUser($request->mobile, $request->role);
            if(!$is_user_exist){
                $user = new User();
                $user->name = $request->name;
                $user->role = $request->role;
                $user->mobile = $request->mobile;
                $user->password = Hash::make($request->password);
                if($user->save()){
                    $user=User::find($user->id)->toArray();
                    $ses=['id'=>$user['id'], 'name'=>$user['name'], 'mobile'=>$user['mobile'], 'role'=>$user['role'], 'email'=>$user['email'], 'email_verified_at'=>$user['email_verified_at'], 'mobile_verified_at'=>$user['mobile_verified_at'], 'status'=>$user['status'], 'created_at'=>$user['created_at'], 'updated_at'=>$user['updated_at']];
                    Session::put('customer', $ses);
                    return redirect()->route('home');
                }else{
                    return back()->with('error', 'Something went wrong');
                }    
            }else{
                return back()->with('status', 'User already exist with this mobile number');
            }

            
        }
    }

    public function customerLogin(Request $request){
        if($request->isMethod('get')){    
            if(Session::has('customer')){
                return redirect()->route('home');
            }else{    
                return view('auth.login');
            }
        }else{
            $request->validate([
                'mobile' => ['numeric','digits:10'],
                'role' => ['required'],
                'password' => ['required', Rules\Password::defaults()],
            ]);
            $user=getUser($request->mobile, $request->role);
            if($user){
                $user=$user[0];
                if(Hash::check($request->password, $user['password'])){
                    $ses=['id'=>$user['id'], 'name'=>$user['name'], 'mobile'=>$user['mobile'], 'role'=>$user['role'], 'email'=>$user['email'], 'email_verified_at'=>$user['email_verified_at'], 'mobile_verified_at'=>$user['mobile_verified_at'], 'status'=>$user['status'], 'created_at'=>$user['created_at'], 'updated_at'=>$user['updated_at']];
                    Session::put('customer', $ses);
                    return redirect()->route('home');
                }else{
                    return back()->with('status', 'Incorrect Password');
                }
            }else{
                return back()->with('status', 'User doesn\'t exist');    
            }
        }
    }


    public function adminRegister(Request $request){
        if($request->isMethod('get')){    
            if(Session::has('admin')){
                return redirect()->route('admin');
            }else{    
                return view('admin.register');
            }
        }else{
            $request->validate([
                'name' => ['required'],
                'email' => ['required'],
                'mobile' => ['numeric','digits:10'],
                'role' => ['required'],
                'password' => ['required', Rules\Password::defaults()],
            ]);
            $is_user_exist=getUser($request->mobile, $request->role);
            if(!$is_user_exist){
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->role = $request->role;
                $user->mobile = $request->mobile;
                $user->password = Hash::make($request->password);
                if($user->save()){ 
                    $user=User::find($user->id)->toArray();
                    $ses=['id'=>$user['id'], 'name'=>$user['name'], 'mobile'=>$user['mobile'], 'role'=>$user['role'], 'email'=>$user['email'], 'email_verified_at'=>$user['email_verified_at'], 'mobile_verified_at'=>$user['mobile_verified_at'], 'status'=>$user['status'], 'created_at'=>$user['created_at'], 'updated_at'=>$user['updated_at']];
                    Session::put('admin', $ses);
                    return redirect()->route('admin');
                }else{
                    return back()->with('error', 'Something went wrong');
                }    
            }else{
                return back()->with('status', 'Admin already exist with this mobile number');
            }

            
        }
    }
    public function adminLogin(Request $request){
        if($request->isMethod('get')){    
            if(Session::has('admin')){
                return redirect()->route('admin');
            }else{    
                return view('admin.login');
            }
        }else{
            $request->validate([
                'mobile' => ['numeric','digits:10'],
                'role' => ['required'],
                'password' => ['required', Rules\Password::defaults()],
            ]);
            $user=getUser($request->mobile, $request->role);
            if($user){
                $user=$user[0];
                if(Hash::check($request->password, $user['password'])){
                    $ses=['id'=>$user['id'], 'name'=>$user['name'], 'mobile'=>$user['mobile'], 'role'=>$user['role'], 'email'=>$user['email'], 'email_verified_at'=>$user['email_verified_at'], 'mobile_verified_at'=>$user['mobile_verified_at'], 'status'=>$user['status'], 'created_at'=>$user['created_at'], 'updated_at'=>$user['updated_at']];
                    Session::put('admin', $ses);
                    return redirect()->route('admin');
                }else{
                    return back()->with('status', 'Incorrect Password');
                }
            }else{
                return back()->with('status', 'Admin doesn\'t exist');    
            }
        }
    }



    public function getSupplierMobile(Request $request){
        if($request->isMethod('get')){
            if(Session::has('supplier')){
                return redirect()->route('seller-home');
            }else{    
                return view('seller.enter-mobile');
            }   
        }else{
            Session::flash('seller-mobile', $request->mobile);
            
            //Session::flash('role', $request->role);
            Session::flash('role', 's');
            
            return redirect()->route('get-supplier-details');
        }
    }

    public function getSupplierDetails(Request $request){
        if($request->isMethod('get')){
            if(Session::has('supplier')){
                return redirect()->route('seller-home');
            }else{    
                $is_user_exist=getUser(Session::get('seller-mobile'), Session::get('role'));
                if($is_user_exist){
                    Session::reflash('seller-mobile');
                    return redirect()->route('seller_login');    
                }else{
                    $data['mobile']=Session::get('seller-mobile');
                    
                    // UNCOMMENT THIS TO RANDOMLY GENERATE OTP
                    // $otp=rand(1111,9999);
                    $otp=1234;
                    Session::put('otp', $otp);
                    return view('seller.details', $data);
                }
            }    
        }else{
            $request->validate([
                'mobile' => ['required','numeric','digits:10'],
                'role' => ['required'],
                'otp' => ['required','digits:4','numeric'],
                'email' => ['email'],
                'password' => ['required', Rules\Password::defaults()],
            ]);

            $is_user_exist=getUser($request->mobile, $request->role);
            
            if(!$is_user_exist){
                
                if($request->otp==Session::get('otp')){
                    $user = new User();
                    $user->role = $request->role;
                    $user->mobile = $request->mobile;
                    if($request->email!="")
                        $user->email = $request->email;
                    $user->password = Hash::make($request->password);
                    if($user->save()){
                        $user=User::find($user->id)->toArray();
                        $ses=['id'=>$user['id'], 'name'=>$user['name'], 'mobile'=>$user['mobile'], 'role'=>$user['role'], 'email'=>$user['email'], 'email_verified_at'=>$user['email_verified_at'], 'mobile_verified_at'=>$user['mobile_verified_at'], 'status'=>$user['status'], 'created_at'=>$user['created_at'], 'updated_at'=>$user['updated_at']];
                        Session::put('supplier', $ses);
                        Session::forget('otp');
                        return redirect()->route('seller-home');
                    }else{
                        return back()->with('error', 'Something went wrong');
                    }        
                }else{
                    return back()->with('status', 'Incorrect OTP');
                }
                
            }else{
                return back()->with('status', 'User already exist with this mobile number');
            }
        }
    }

    public function sellerLogin(Request $request){
        if($request->isMethod('get')){
            if(Session::has('supplier')){
                return redirect()->route('seller-home');
            }else{    
                return view('seller.login');
            } 
            
        }else{
            $request->validate([
                'mobile' => ['required','numeric','digits:10'],
                'role' => ['required'],
                'password' => ['required', Rules\Password::defaults()],
            ]);
            $user=getUser($request->mobile, $request->role);
            if(!$user){
                Session::flash('seller-mobile', $request->mobile);
                Session::flash('role', $request->role);
                return redirect()->route('get-supplier-details');
            }else{
                $user=$user[0];
                if(Hash::check($request->password, $user['password'])){
                    $ses=['id'=>$user['id'], 'name'=>$user['name'], 'mobile'=>$user['mobile'], 'role'=>$user['role'], 'email'=>$user['email'], 'email_verified_at'=>$user['email_verified_at'], 'mobile_verified_at'=>$user['mobile_verified_at'], 'status'=>$user['status'], 'created_at'=>$user['created_at'], 'updated_at'=>$user['updated_at']];
                        Session::put('supplier', $ses);
                        return redirect()->route('seller-home');
                    }else{
                        return back()->with('status', 'Wrong password');
                    }
            }
        }
    }

    public function index(){
        // dd(\Cookie::get('visitor_id'));
        $data['banners'] = BannerAds::where('status', true)->get();
        $data['categories'] = \Helper::getCategories();
        return view('welcome', $data);
    }

    public function showSingleProduct($id){
        $product = Product::find($id);
        $data['product'] = $product->load('category','images');
        return view('shop.single2', $data);
    }

    

    public function products(Request $request, $gid, $pid, $cid){
        $data = $this->getAllData();
        $data['products']=Product::where('grand_category_id', $gid)->where('parent_category_id', $pid)->where('category_id', $cid)->where('status',true)->get();
        return view('shop.products')->with($data);
       
    }

    public function allProducts(Request $request){
        
        $categories = Category::all();
            
        if (request()->category) {
            $targetCategory = Category::find(request()->category);
            $products = $targetCategory->products()->active();
        } else {
            $products = Product::active();
        }

        // if (request()->has('minPrice') && request()->has('maxPrice')) {
        //     $products->where('price', '>=', request()->minPrice)
        //              ->where('price', '<=', request()->maxPrice);
        // }

        if(request()->orderby){
            if (request()->orderby == 'price-desc') {
                $products = $products->orderBy('offer_price', 'desc');
            } else if (request()->orderby == 'price') {
                $products = $products->orderBy('offer_price');
            } else {
                $products = $products->latest();
            }
        }

        $data['products'] = $products->paginate(12);

        return view('shop.all-products')->with($data);
       
    }

    public function privacy(){
        return view('layouts.privacy');
    }

    public function terms(){
        return view('layouts.terms-and-conditions');
    }
}
