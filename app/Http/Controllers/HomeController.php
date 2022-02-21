<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category; 
use App\Models\State; 
use App\Models\City; 
use App\Models\Payment; 
use App\Models\Order; 
use App\Models\Address;
use Illuminate\Validation\Rules; 
use Session; 

class HomeController extends Controller   
{
    public function __construct()
    {
        $this->middleware(function ($request, $next){
            if(!Session::has('customer')){
                return redirect()->route('customer_login');
            }
        return $next($request);
        });
    }
    public function index(Request $request){
        if($request->isMethod('get')){
            $data = $this->getAllData();
            $data['page'] = 'Profile';
            return view('customer.profile', $data);
        }else{
            if(!Session::has('customer.email')){
                $request->validate([
                    'email' => 'required|email',
                ]);
            }else{
                if(!is_null($request->email)){
                    $request->validate([
                        'email' => 'email',
                    ]);
                }
            }
           
            if($request->has('password')){
                $request->validate([
                    'password' => ['required', Rules\Password::defaults()],
                    'password_confirmation' => ['required', Rules\Password::defaults()],
                ]);
                if($request->password != $request->password_confirmation){
                    return back()->with('status', 'Password Mismatched! Please try again.');
                }
            }
            
            $user=User::find(Session::get('customer.id'));
            if($user){
                if(!is_null($request->email)){
                    $user->email=$request->email;
                }
                if($request->has('password')){
                    $user->password = Hash::make($request->password);
                }
                if($user->save()){
                    Session::put('customer.email', $user->email);
                    return back()->with('success', 'Profile updated successfully');
                }else{
                    return back()->with('error', 'Something went wrong! Please try again');
                }
            }
            return back()->with('error', 'No user found');
        }
    }

    public function logout(Request $request){
        Session::forget('customer');
        return redirect()->route('guest-home');
    }

    public function orders(Request $request){
        $data = $this->getAllData();
        return view('customer.orders', $data);
    }

    public function address(Request $request){
        if($request->isMethod('get')){
            $data = $this->getAllData();
            $address=Address::where('role_id', Session::get('customer.id'))->first();
            $data['states']=State::where(['status'=>true])->get();
            if($address){
                $data['address']=$address;
            }
            return view('customer.address', $data);
        }else{
            $request->validate([
                'state' => 'required|numeric',
                'city' => 'required|numeric',
                'house' => 'required',
                'area' => 'required',
                'landmark' => 'required',
                'zipcode' => 'required|numeric',
            ]);

            if(is_null($request->is_update)){
                $address = new Address();
            }else{
                $address = Address::find($request->is_update);
            }
            $address->type='delivery';
            $address->role_id=Session::get('customer.id');
            $address->name=Session::get('customer.name');
            $address->mobile=Session::get('customer.mobile');
            if(Session::has('customer.email')){
                $address->email=Session::get('customer.email');
            }
            $address->house=$request->house;
            $address->area=$request->area;
            $address->landmark=$request->landmark;
            $address->state=$request->state;
            $address->city=$request->city;
            $address->pincode=$request->zipcode;
            if($address->save()){
                return back()->with('success','Address updated'); 
            }else{
                return back()->with('status','Something went wrong! Please try again');
            }
            
            return back()->with('error','Something went wrong! Please try again');
        }
    }

    public function shopCart(Request $request, $type, $page){
        $data['page']=$page;
        return view($type.'.'.$page)->with($data);        
    }

    public function addtocart(Request $request){
        $request->validate([
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
        ]);       
        $product=Product::find($request->product_id);
        if($product){
            $order=new Order();
            $order->product_id=$product->id;
            $order->user_id=Session::get('customer.id');
            $order->quantity=$request->quantity;
            $order->attributes=json_encode($request->attribute);
            $order->final_price=$product->offer_price;
            if($order->save()){
                return back()->with('success', 'Product added to cart');
            }
        }
    }

    public function cart(Request $request){
        if($request->isMethod('get')){
            $data = $this->getAllData();
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
    public function checkoutDetails(Request $request){
        if($request->isMethod('get')){
            $data = $this->getAllData();
            $address=Address::where('role_id', Session::get('customer.id'))->first();
            $data['states']=State::where(['status'=>true])->get();
            if($address){
                $data['address']=$address;    
            }
            return view('shop.checkout-details', $data);
        }else{
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'mobile' => 'required|digits:10|numeric',
                'state' => 'required|numeric',
                'city' => 'required|numeric',
                'house' => 'required',
                'area' => 'required',
                'landmark' => 'required',
                'zipcode' => 'required|numeric',
            ]);
            if(is_null($request->is_update)){
                $address = new Address();
            }else{
                $address = Address::find($request->is_update);
            }
            $address->type='delivery';
            $address->role_id=Session::get('customer.id');
            $address->name=$request->name;
            $address->email=$request->email;
            $address->mobile=$request->mobile;
            $address->house=$request->house;
            $address->area=$request->area;
            $address->landmark=$request->landmark;
            $address->state=$request->state;
            $address->city=$request->city;
            $address->pincode=$request->zipcode;
            if($address->save()){
                return redirect()->route('checkout-review'); 
            }
            
            return back()->with('error','Something went wrong! Please try again');
            
        }   
    }

    public function checkoutShipping(Request $request){
        if($request->isMethod('get')){
            $data = $this->getAllData();
            return view('shop.checkout-shipping', $data);
        }else{
            dd('');
        }
    }

    public function checkoutReview(Request $request){
        if($request->isMethod('get')){
            $data = $this->getAllData();        
            return view('shop.checkout-review', $data);
        }
    }

    public function prePayment(Request $request){
        if($request->isMethod('get')){
            $data = $this->getAllData();
            return view('shop.checkout-payment', $data);
        }else{
            $request->validate([
                'payment_type' => 'required|in:online,cash',
            ]);
            // dd($request->all());
            
            $orders=Order::where([ 'user_id' => Session::get('customer.id'), 'is_in_cart' => true])->get();
            if(!$orders->isEmpty()){
                $payment= new Payment();
                $pmt_id=uniqid('OR');
                $payment->user_id=Session::get('customer.id');
                $payment->pmt_id=$pmt_id;
                $payment->pmt_type=$request->payment_type;
                //Remove this when gateway start
                Session::put('pmt_id',$pmt_id);
                //

                $suppliers=[];
                $i=0;
                $temp='';

                $address=Address::where(['role_id'=>Session::get('customer.id'), 'type'=>'delivery'])->first();
                foreach($orders as $key => $order){
                    if(!in_array(getProductSupplier($order->product_id), $suppliers)){
                        $suppliers[$i]=getProductSupplier($order->product_id);
                        $temp=uniqid(5000);
                        $order->order_id=$temp;
                        $i++;
                    }else{
                        $order->order_id=$temp;
                    }
                    $order->delivery_address=$address->house.', '.$address->area.', '.$address->landmark.', '.getCityName($address->city).', '.getStateName($address->state).' - '.$address->pincode.', Mob - '.$address->mobile;
                    $order->pmt_id=$pmt_id;
                    $order->save();
                }
                $payment->amount=getCartSubTotal();
                $payment->status=false;
                if($payment->save()){
                    return redirect()->route('payment-gateway');
                }else{
                    return back()->with('error','Something went wrong! Please try again');
                }
            }
        }
    }

    public function paymentGateway(Request $request){
        $response=true;
        if($response==true){
            return redirect()->route('checkout-complete');
        }else{
            dd('error');
        }
    }

    public function checkoutComplete(Request $request){
        if($request->isMethod('get')){
            $response=true;
            if($response==true){
                $orders=Order::where([ 'user_id' => Session::get('customer.id'), 'is_in_cart' => true])->get();
                foreach ( $orders as $key => $order ) {
                    $order->is_in_cart=false;
                    $order->status='pending';
                    date_default_timezone_set('Asia/Kolkata');
                    $order->order_time=date('Y-m-d h:i:s');
                    $order->save();
                }
                $payment=Payment::where(['pmt_id' => Session::get('pmt_id')])->first();
                
                if($payment->pmt_type=='online')
                    $payment->status=true;

                if($payment->save()){
                    Session::forget('pmt_id');
                    $data = $this->getAllData();
                    $data['payment']=Payment::find($payment->id);
                    $data['orders']=Order::where('pmt_id', $data['payment']->pmt_id)->get();
                    return view('shop.checkout-complete',$data);
                }else{
                    dd('error');
                }
                
            }else{
                dd('error');
            }    
        }
    }

    public function deleteCartProduct($id){
        $order=Order::where([ 'user_id' => Session::get('customer.id'), 'is_in_cart' => true, 'product_id' => $id ])->first();
        if($order->delete()){
            return back()->with('success', 'Product removed from cart successfully');
        }else{
            return back()->with('error', 'Something went wrong! Please try again');
        }
    }
}
