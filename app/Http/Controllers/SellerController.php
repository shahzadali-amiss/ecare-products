<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request; 
use App\Models\Category; 
use App\Models\Product; 
use App\Models\Image; 
use App\Models\State; 
use App\Models\Supplier; 
use App\Models\Order; 
use App\Models\User; 
use App\Models\Bank; 
use App\Models\City; 
use App\Models\Address; 
use App\Models\Attribute; 
use App\Models\Attribute_value; 
use App\Models\Product_attribute; 
// use App\Models\ProductAttributeValue; 
use Session;

class SellerController extends Controller 
{
	public function __construct()
    {
        $this->middleware(function ($request, $next){
            if(!Session::has('supplier')){
                return redirect()->route('seller_login');
            }
        return $next($request);
        });
    }

    public function index(Request $request){
    	if(Session::has('supplier')){	
    		return view('seller.dashboard');
    	}
    }

    public function logout(Request $request){
        Session::forget('supplier');
        return redirect()->route('seller_login');
    }

    public function uploadType(Request $request){
        return view('seller.upload-type');
    }

    public function chooseCategory(Request $request, $type=null){
    	if($request->isMethod('get')){
	    		$data['grands']= Category::with('childs')->where('category_type', 1)->where('status', true)->get();
		    if($data['grands']){	
		    	if($type=='single'){
		    		return view('seller.choose-category', $data);
		    	}elseif($type=='bulk') {
		    		return view('seller.choose-category', $data);
		    	}else{

		    	}
		    }else{
		    	return back()->with('status', 'No category found');
		    }	
    	}else{
    		$request->validate([
    			'grand_category' => 'numeric|required',
    			'parent_category' => 'numeric|required',
    			'child_category' => 'numeric|required',
    		]); 
    		
    		Session::put('grand_category', $request->grand_category);
    		Session::put('parent_category', $request->parent_category);
    		Session::put('child_category', $request->child_category);
        	return redirect()->route('add-product');
    	}
    }

    public function addProduct(Request $request, $edit_id = null){
        if($request->isMethod('get')){
        //CHECK EDIT MODE
            $is_edit = is_null($edit_id) ? false : true;
            $data['attributes']=Attribute::with('getAttributeValues')->where('category_id', Session::get('child_category'))->get();
            $data['is_edit'] = $is_edit;
            if($is_edit){
                $data['image2'] = getImage('p',$edit_id, 2, Session::get('supplier.id'));
                $data['image3'] = getImage('p',$edit_id, 3, Session::get('supplier.id'));
                $data['image4'] = getImage('p',$edit_id, 4, Session::get('supplier.id'));
                $data['image5'] = getImage('p',$edit_id, 5, Session::get('supplier.id'));
                $data['product'] = Product::find($edit_id);   
            }
            return view('seller.add-product', $data);
        }else{
            $is_edit = is_null($request->edit_id) ? false : true;
            $request->validate([
                'name'=>'required',
                'grand_category'=>'required',
                'parent_category'=>'required',
                'child_category'=>'required',
                'price'=>'required|numeric',
                'dis_price'=>'required|numeric',    
            ]);
            
            $attributes=Attribute::with('getAttributeValues')->where('category_id', Session::get('child_category'))->get();

            // CHECK MODE (EDIT OR ADD)
            if($is_edit){
                if ($request->file) {
                    // check if image exixts in edit mode/.................
                    $request->validate( [
                    'file'=>'required|image|mimes:jpeg,png,jpg|max:2048'
                    ]);  
                }
                if ($request->file2) {
                    // check if image exixts in edit mode/.................
                    $request->validate( [
                    'file2'=>'required|image|mimes:jpeg,png,jpg|max:2048'
                    ]);  
                }
                if ($request->file3) {
                    // check if image exixts in edit mode/.................
                    $request->validate( [
                    'file3'=>'required|image|mimes:jpeg,png,jpg|max:2048'
                    ]);  
                }
                if ($request->file4) {
                    // check if image exixts in edit mode/.................
                    $request->validate( [
                    'file4'=>'required|image|mimes:jpeg,png,jpg|max:2048'
                    ]);  
                }
                if ($request->file5) {
                    // check if image exixts in edit mode/.................
                    $request->validate( [
                    'file5'=>'required|image|mimes:jpeg,png,jpg|max:2048'
                    ]);  
                }
                    

                $product = Product::find($request->edit_id);
                if (!$product) {
                    return back()->with('status', 'Product not found');
                }
            }else{
                $request->validate( ['file'=>'required|image|mimes:jpeg,png,jpg|max:2048']);
                // CREATE NEW PRODUCT OBJECT
                $product = new Product();                

            }
                

            // SET OTHER MODEL DATA
            $product->name = $request->name;
            $product->role_id = Session::get('supplier.id');
            $product->grand_category_id = $request->grand_category;
            $product->parent_category_id = $request->parent_category;
            $product->category_id = $request->child_category;
            $product->mrp = $request->price;
            $product->offer_price = $request->dis_price;

            if($request->desc != ""){
                $product->description = $request->desc;    
            }
            $product->status = $request->status;

            // IF EMAGE IS NOT PRESENT IN EDIT MODE...    
            if ($is_edit && !$request->file){

            }else{
                $request->validate( ['file'=>'required|image|mimes:jpeg,png,jpg|max:2048']);
                // STORE PRODUCT IMAGE IN FOLDER
                if($is_edit){
                    $product->image = replaceProductImage($request,'file',$product->image);
                    if($is_edit){    
                }       
                }else{
                    $product->image = moveProductImage($request,'file');
                } 
            } 

            if($is_edit){
                if($request->file2){
                    $image2=isImageExist($request->edit_id, 2);
                    if(!$image2->isEmpty()){
                        $image2->image=replaceProductImage($request,'file2',$image2->image);
                        $image2->save();
                    }else{
                        $image2=new Image();
                        $image2->role_id=Session::get('supplier.id');
                        $image2->type='p';
                        $image2->type_id=$product->id;
                        $image2->priority=2;
                        $image2->image=moveProductImage($request,'file2');
                        $image2->save();
                    }
                }
                if($request->file3){
                    $image3=isImageExist($request->edit_id, 3);
                    if(!$image3->isEmpty()){
                        $image3->image=replaceProductImage($request,'file3',$image3->image);
                        $image3->save();
                    }else{
                        $image3=new Image();
                        $image3->role_id=Session::get('supplier.id');
                        $image3->type='p';
                        $image3->type_id=$product->id;
                        $image3->priority=3;
                        $image3->image=moveProductImage($request,'file3');
                        $image3->save();
                    }
                }
                if($request->file4){
                    $image4=isImageExist($request->edit_id, 4);
                    if(!$image4->isEmpty()){
                        $image4->image=replaceProductImage($request,'file4',$image4->image);
                        $image4->save();
                    }else{
                        $image4=new Image();
                        $image4->role_id=Session::get('supplier.id');
                        $image4->type='p';
                        $image4->type_id=$product->id;
                        $image4->priority=4;
                        $image4->image=moveProductImage($request,'file4');
                        $image4->save();
                    }
                }
                if($request->file5){
                    $image5=isImageExist($request->edit_id, 5);
                    if(!$image5->isEmpty()){
                        $image5->image=replaceProductImage($request,'file5',$image->image);
                        $image5->save();
                    }else{
                        $image5=new Image();
                        $image5->role_id=Session::get('supplier.id');
                        $image5->type='p';
                        $image5->type_id=$product->id;
                        $image5->priority=5;
                        $image5->image=moveProductImage($request,'file5');
                        $image5->save();
                    }
                }
            }
            
                
            // SAVE IMAGE NAME IN DATABASE                

            // ATTEMPT TO SAVE PRODUCT
            if($product->save()){
                foreach ($attributes as $key => $attribute) {
                    $name=strtolower($attribute->name).'s';
                    if($request->has($name)){
                        foreach ($request->$name as $attr) {
                            $productattributevalue= new Product_attribute();
                            $productattributevalue->product_id = $product->id;
                            $productattributevalue->attribute_value_id = $attr;
                            $productattributevalue->save();
                        }
                    }
                    $name=strtolower($attribute->name);
                    if($request->has($name)){
                        foreach ($request->$name as $attr) {
                            if(!is_null($attr)){
                                $attrvalue=Attribute_value::where(['attribute_id' => $attribute->id, 'value' => $attr])->first();
                                if(!$attrvalue){
                                    $attrvalue= new Attribute_value();
                                    $attrvalue->attribute_id = $attribute->id;
                                    $attrvalue->value = $attr;
                                    $attrvalue->is_verified = false;
                                    $attrvalue->status = true;
                                    $attrvalue->save();
                                }
                                $productattributevalue= new Product_attribute();
                                $productattributevalue->product_id = $product->id;
                                $productattributevalue->attribute_value_id = $attrvalue->id;
                                $productattributevalue->save();
                            }
                        }
                    }
                }

                if($is_edit){
                    $msg='Product Updated';
                    return redirect()->route('supplier_products')->with('success', $msg);
                }else{
                    Session::forget('grand_category');
                    Session::forget('parent_category');
                    Session::forget('child_category');
                    $msg='Product Uploaded';
                    return redirect()->route('seller-upload-type')->with('success', $msg);
                }

                
            }

            // NOT SAVED,
            // RETURN BACK WITH ERROR MSG
            return back()->with('error', 'Whoops, something went wrong? Please try after sometime');   
        }
    	
    }	

    public function products(Request $request){
        $data = $this->getAllData();
        $data['products']=Product::where('role_id', Session::get('supplier.id'))->where('status', true)->orderBy('id', 'desc')->paginate(10);
        return view('seller.products')->with($data);
       
    }

    public function payouts(Request $request){
        $data = $this->getAllData();
        return view('seller.payouts')->with($data);
    }

    public function orders(Request $request, $type){
        $data = $this->getAllData();
        if($type=='p'){
            return view('seller.pending-orders')->with($data);
        }else{
            return view('seller.completed-orders')->with($data);
        }
    }

    public function account(Request $request){
        if($request->isMethod('get')){
            $data = $this->getAllData();
            $data['bank']=Bank::where('role_id',Session::get('supplier.id'))->first();
            $data['pick_address']=Address::where(['role_id'=>Session::get('supplier.id'), 'type'=>'pickup'])->first();
            $data['reg_address']=Address::where(['role_id'=>Session::get('supplier.id'), 'type'=>'registered'])->first();
            $data['states']=State::where(['status'=>true])->get();
            return view('seller.my-account')->with($data);
        }else{
            $request->validate([
                'gst_number'=>'required',
                'business_name'=>'required',
                'pan_number'=>'required',
                'business_type'=>'required',
                'business_address'=>'required',
                'state'=>'required',
                'city'=>'required',
                'pincode'=>'required|digits:6',
                'address'=>'required',
                'account_holder_name'=>'required',
                'bank_name'=>'required',
                'account_number'=>'required',
                'ifsc_code'=>'required',
                'name'=>'required',
                'email'=>'required|email',
                'mobile'=>'required|numeric|digits:10',

            ]);
            if($request->image){
                $request->validate([
                    'image'=>'mimes:jpeg,png,jpg|max:1024|dimensions:ratio=1/1',
                ]);
            }


            if ($request->i_agree=='on') {

                $supplier=Supplier::where('role_id', Session::get('supplier.id'))->first();
                if(!$supplier){
                    $supplier = new Supplier();
                }

                $pick_address=Address::where(['role_id'=>Session::get('supplier.id'), 'type'=>'pickup'])->first();
                if(!$pick_address){
                    $pick_address = new Address();   
                }

                $reg_address=Address::where(['role_id'=>Session::get('supplier.id'), 'type'=>'registered'])->first();
                if(!$reg_address){
                    $reg_address = new Address();   
                }

                $bank=Bank::where(['account_number'=>$request->account_number, 'role_id'=>Session::get('supplier.id')])->first();
                if(!$bank){
                    $bank = new Bank();   
                }

                $user=User::find(Session::get('supplier.id'));
                $user->name=$request->name;
                Session::put('supplier.name', $request->name);

                $supplier->role_id=Session::get('supplier.id');
                $supplier->gst_no=$request->gst_number;
                $supplier->business_name=$request->business_name;
                $supplier->pan_no=$request->pan_number;
                $supplier->business_type=$request->business_type;
                $supplier->supplier_name=$request->name;
                $supplier->supplier_mobile=Session::get('supplier.mobile');
                

                $reg_address->type='registered';
                $reg_address->role_id=Session::get('supplier.id');
                $reg_address->name=$request->business_name;
                $reg_address->email=Session::get('supplier.email');
                $reg_address->mobile=Session::get('supplier.mobile');
                $reg_address->address=$request->business_address;
                

                $pick_address->type='pickup';
                $pick_address->role_id=Session::get('supplier.id');
                $pick_address->name=$request->business_name;
                $pick_address->email=Session::get('supplier.email');
                $pick_address->mobile=Session::get('supplier.mobile');
                $pick_address->state=$request->state;
                $pick_address->city=$request->city;
                $pick_address->pincode=$request->pincode;
                $pick_address->address=$request->address;

                $bank->role_id=Session::get('supplier.id');
                $bank->name=$request->account_holder_name;
                $bank->account_name=$request->bank_name;
                $bank->account_number=$request->account_number;
                $bank->ifsc=$request->ifsc_code;
                $bank->status=true;

                if($request->image){
                    $destinationPath = public_path( '/supplier_images' );
                    $image = $request->image;
                    $fileName = 'sup'.rand(11111111111111,99999999999999). '.'.$image->clientExtension();
                    $image->move( $destinationPath, $fileName );
                    if($supplier->image!='default.jpg'){
                        unlink(public_path('supplier_images/'.$supplier->image));
                    }
                    $supplier->image=$fileName;
                }

                if($supplier->save() && $reg_address->save() && $pick_address->save() && $bank->save() && $user->save()){

                    return back()->with('success', 'Account Updated');
                }
                return back()->with('status', 'Something went wrong! Please try again.');

            }else{
                return back()->with('status', 'You cannot proceed without agreeing out terms and conditions.');                
            }
        }
    }

    public function settings(Request $request){
        $data = $this->getAllData();
        return view('seller.settings')->with($data);
    }

    public function purchases(Request $request){
        $data = $this->getAllData();
        return view('seller.purchases')->with($data);
    }

    public function favorites(Request $request){
        $data = $this->getAllData();
        return view('seller.favorites')->with($data);
    }

    public function moveToCompleteOrder(Request $request){
        $order=Order::find($request->orderId);
        $order->status='delivered';
        if($order->save()){
            return back()->with('success', 'Order moved to complete orders');
        }
        return back()->with('error', 'Something went wrong! Please try again');
    }

}
