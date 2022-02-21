<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;   
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\BannerAds;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Image;
use App\Models\Bank;
use App\Models\Supplier;
use App\Models\Attribute;
use App\Models\Address;
use App\Models\Attribute_value;  
use App\Models\Product_attribute;


class AdminController extends Controller
{   

    // Constructor function that loads first whenever the AdminController is called
    public function __construct()
    {
        $this->middleware(function ($request, $next){
            //condition that run when admin not exist in session
            if(!Session::has('admin')){
                //redirect to admin login route
                return redirect()->route('admin-login');
            }
        //if admin exist in session this will return the user's request
        return $next($request);
        });
    }


    // return admin dashboard when session contains admin
    public function index(){
        if(Session::has('admin')){
            return view('admin.dashboard');
        }
    }

    //removes the admin from session and returns admin login view
    public function logout(Request $request){
        Session::forget('admin');
        return redirect()->route('admin-login');
    }

    // USED TO VERIFY/NON VERIFY SUPPLIER
    public function verifyUser(Request $request){
        $request->validate([
            // 'is_verified'=>'required',
            'supplier_id'=>'required'
        ]);
        // GET SUPPLIER
        $supplier = Supplier::find($request->supplier_id);
        $supplier->is_verified = !$supplier->is_verified;

        // ATTEMPT TO SAVE DATA
        if($supplier->save())
            return back()->with('success', 'Supplier Verification Updated');

        // RETURN WITH ERROR MSG
        return back()->with('error', 'Whoops, something went wrong please try after sometime');
    }

    //show category..........
    public function showCategory(){
            $data['categories'] = \App\Models\Category::all();
            $data['attributes'] = \App\Models\Attribute::all();
            if (count($data) == 0) {
                return view('admin.all-categories');
                }
            else{ 
            // dd('data hare');
                return view('admin.all-categories')->with($data);
                }
    }


    // CREATE NEW CATEGORY
    public function AddCategory(Request $request, $edit_id = null){
        //Give true if request is in edit mode
        $is_edit = is_null($edit_id) ? false : true;
        $data['is_edit'] = $is_edit;

        if($is_edit)
            $category = \App\Models\Category::find($edit_id);

        if($request->isMethod('get')){
        //if request method is get
            $data['categories'] = \App\Models\Category::where('status', true)->get();

            if($is_edit)
                $data['category'] = $category;

            return view('admin.add-category', $data);
        }else{
        //if request method is post

            $request->validate([
                // 'name'=>'required',//|unique:categories',
                'status'=>'required',

            ]);
        
            if($is_edit){
                if($request->image) {
                    // check if emage exixts in edit mode/.................
                    $request->validate( [
                    'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
                    ]);  
                }

                // FIND DATA OF PERTICULER ID
                $category = \App\Models\Category::find($request->edit_id);
                // dd($request->edit_id);  
                if ($request->name == $category->name) {
                    $request->validate(['name'=>'required']);
                }    
                else{
                    $request->validate(['name'=>'required|unique:categories']);
                }              

            }
            else{
                //validates the new image for category
                $request->validate( [
                'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
                ]);

                //creating new category
                $category = new \App\Models\Category();
                if($request->grand=="" && $request->parent=="")
                    $request->validate(['name'=>'required|unique:categories']);
                else
                    $request->validate(['name'=>'required']);
            }




            // dd($request->all());

            // CONDITIONAL CATEGORY TYPE AND PARENT ASSIGN
            if(!is_null($request->grand)){
                if(!is_null($request->parent)){
                    $category->category_type = 3;
                    $category->parent_id = $request->parent;
                }
                else{
                    $category->category_type = 2;
                    $category->parent_id = $request->grand;
                }
            }
            else{
                $category->category_type = 1;
            }

            // SET OTHER MODEL DATA
            $category->name = $request->name;
            $category->status = $request->status;


            // IF IMAGE IS NOT PRESENT IN EDIT MODE...    
            if ($is_edit and !$request->image) {
                    
            }
            else{
                $request->validate( ['image'=>'required|image|mimes:jpeg,png,jpg|max:2048']);
                // STORE PRODUCT IMAGE IN FOLDER
                $destinationPath = public_path( '/category_images' );
                $image = $request->file('image');
                $fileName = 'image'.time() . '.'.$image->clientExtension();
                $image->move( $destinationPath, $fileName );
                $category->image = $fileName;
            }
            // dd($category);

            // ATTEMPT TO SAVE CATEGORYT
            if($category->save())
                return back()->with('msg', 'Data updated');

            // NOT SAVED,
            // RETURN BACK WITH ERROR MSG
            return back()->with('msg', 'Whoops, something went wrong? Pleae try after sometime');
        }
    }

    // ADMIN SHOW ALL PRODUCTS
    public function showProduct(){
        $data['products'] = Product::orderBy('id', 'desc')->get();
        $data['categories'] = \App\Models\Category::all();
        
        return view('admin.all-products', $data);
          
    }

    //To show product categories to select while adding product
    public function showProductCategories(Request $request){
        if($request->isMethod('get')){
        // $data['attributes'] = \App\Models\Attribute::all();
            $data['grands']= Category::with('childs')->where('category_type', 1)->where('status', true)->get();
            $data['categories'] = \App\Models\Category::all();
            return view('admin.select-product-category', $data);
        }else{
            $request->validate([
                'grand_category'=>'required',
                'parent_category'=>'required',
                'child_category'=>'required',
            ]);

            // put category values in the session for use on next page
            Session::put('grand_category', $request->grand_category);
            Session::put('parent_category', $request->parent_category);
            Session::put('child_category', $request->child_category);
            // $data['category']=$request->category;
            // $data['category']=$request->category;
            $data['category']=$request->child_category;
            return redirect()->route('add_product',$data);
        }
    }    
    // ADD AND EDIT PRODUCTS
    // public function addProduct(Request $request, $edit_id = null){
    //     $is_edit = is_null($edit_id) ? false : true;
    //     $data['is_edit'] = $is_edit;
    //     // CHECK METHODE (GET OR POST)..............
    //     if($request->isMethod('get')){

    //             $data['category'] = $category;
    //         if($is_edit){
    //             $data['product'] = \App\Models\Product::find($edit_id);
    //         }
    //         else{
    //             $data['product'] = [];   
    //         }
    //         $data['attributes']= \App\Models\Attribute::where('category_id', $category)->get();
    //         // VIEW PRODUCT FORM PAGE (IN EDIT OR CREATE MODE)
    //         return view('admin.add-product', $data);  
    //     }
    //     else{

    //         // VALIDATE FIELDS....
    //         //dd($request->all());
    //         $request->validate([
    //         'name'=>'required',
    //         'category'=>'required',
    //         'price'=>'required|numeric',
    //         'dis_price'=>'required|numeric',
           
    //         ]);

    //         // CHECK MODE (EDIT OR ADD)
    //         if($is_edit){
    //             if ($request->image) {
    //                 // check if emage exixts in edit mode/.................
    //                 $request->validate( [
    //                 'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
    //                 ]);  
    //             }
    //             $product = \App\Models\Product::find($request->edit_id);
    //             if (!$product) {
    //                 return back()->with('msg', 'Data not found');
    //             }
    //         }
    //         else{
    //             $request->validate( ['image'=>'required|image|mimes:jpeg,png,jpg|max:2048']);

    //             // CREATE NEW PRODUCT OBJECT
    //             $product = new \App\Models\Product();                

    //         }
            

    //         // SET OTHER MODEL DATA
    //         $product->name = $request->name;
    //         $product->role_id = Auth::user()->id;
    //         $product->category_id = $request->category;
    //         $product->mrp = $request->price;
    //         $product->offer_price = $request->dis_price;
    //         $product->status = $request->status;

    //         // IF EMAGE IS NOT PRESENT IN EDIT MODE...    
    //         if ($is_edit and !$request->image) {
                    
    //         }
    //         else{
    //             $request->validate( ['image'=>'required|image|mimes:jpeg,png,jpg|max:2048']);
    //             // STORE PRODUCT IMAG IN FOLDER
    //             $destinationPath = public_path( '/product_images' );
    //             $image = $request->file('image');
    //             $fileName = 'image'.time() . '.'.$image->clientExtension();
    //             $image->move( $destinationPath, $fileName );
    //             $product->image = $fileName;
    //         }

    //         // SAVE IMAGE NAME IN DATABASE                

    //         // ATTEMPT TO SAVE PRODUCT
    //         if($product->save())
    //         //dd($request->all());
    //             $attributes= \App\Models\Attribute::where('category_id', $request->category)->get();
                
    //             foreach ($attributes as $key => $attribute) {
    //                 $temp=strtolower($attribute->name);
    //                 $attr=$temp.'_attribute_values';
    //                 if ($request->has($attr)) {
    //                     foreach ($request->$attr as $attr_value) {
    //                         $attr_val=\App\Models\Attribute_value::find($attr_value); 
    //                         if(!$attr_val){
    //                             $attr_val= new \App\Models\Attribute_value();
    //                             $attr_val->attribute_id=$attribute->id;
    //                             $attr_val->value=$attr_value;
    //                             $attr_val->save();
    //                         }
    //                         $product_attribute = new \App\Models\Product_attribute();
    //                         $product_attribute->attribute_value_id=$attr_val->id;
    //                         $product_attribute->product_id = $product->id;
    //                         $product_attribute->save();
    //                     }
    //                 }
    //             }

    //             return back()->with('msg', 'Data updated');

    //         // NOT SAVED,
    //         // RETURN BACK WITH ERROR MSG
    //         return back()->with('msg', 'Whoops, something went wrong? Pleae try after sometime');
    //     }
    // }

    // To add or edit the product
    public function addProduct(Request $request, $edit_id = null){
        //If request method is get
        if($request->isMethod('get')){
        //CHECK EDIT MODE
            $is_edit = is_null($edit_id) ? false : true;
            $data['attributes']=Attribute::with('getAttributeValues')->where('category_id', Session::get('child_category'))->get();
            $data['is_edit'] = $is_edit;
            // Get the existing images in edit mode
            if($is_edit){
                $data['image2'] = getImage('p',$edit_id, 2, 1);
                $data['image3'] = getImage('p',$edit_id, 3, 1);
                $data['image4'] = getImage('p',$edit_id, 4, 1);
                $data['image5'] = getImage('p',$edit_id, 5, 1);
                $data['product'] = Product::find($edit_id);   
            }
            return view('admin.add-product', $data);
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
                    
                // Attempt to find the product in edit mode
                $product = Product::find($request->edit_id);
                //If product not found in edit mode
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
            // $product->role_id = Session::get('admin.id');
            $product->role_id = 1;
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
                    //removing the old image and adding new one
                    $product->image = replaceProductImage($request,'file',$product->image);       
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
                        // $image2->role_id=Session::get('admin.id');
                        $image2->role_id=1;
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
                        // $image3->role_id=Session::get('admin.id');
                        $image3->role_id=1;
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
                        // $image4->role_id=Session::get('admin.id');
                        $image4->role_id=1;
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
                        // $image5->role_id=Session::get('admin.id');
                        $image5->role_id=1;
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
                    return redirect()->route('admin-all-products')->with('success', $msg);
                }else{
                    Session::forget('grand_category');
                    Session::forget('parent_category');
                    Session::forget('child_category');
                    $msg='Product Uploaded';
                    return redirect()->route('showProductCategories')->with('success', $msg);
                }

                
            }

            // NOT SAVED,
            // RETURN BACK WITH ERROR MSG
            return back()->with('error', 'Whoops, something went wrong? Please try after sometime');   
        }
        
    }

    // SHOW ALL USERS...........
    public function showUser($type=''){
        // dd($type);
        if ($type == 'customer') {
            $data['users'] = \App\Models\User::where(['role'=>'c'])->get();
            $data['type'] = 'Customer';
        }
        elseif ($type == 'supplier') {
            $data['users'] = \App\Models\User::where(['role'=>'s'])->get();
            $data['type'] = 'Supplier';  
        }
        else{        
            $data['users'] = \App\Models\User::all();
            $data['type'] = 'User';
        }

        return view('admin.all-users', $data);
    }

    public function viewUser(Request $request, $id){
        $user=User::find($id);
        $data=[];
        if($user){
            $data['user']=$user;
            if($user->role=='c'){
                $data['role']='c';
                $data['address']=Address::where(['role_id'=>$user->id, 'type'=>'delivery'])->first();
            }elseif($user->role=='s') {
                $data['role']='s';
                $data['r_address']=Address::where(['role_id'=>$user->id, 'type'=>'registered'])->first();
                $data['p_address']=Address::where(['role_id'=>$user->id, 'type'=>'pickup'])->first();
                $data['supplier']=Supplier::where('role_id',$user->id)->first();
                $data['bank']=Bank::where('role_id',$user->id)->first();
            }elseif($user->role=='a') {
                $data['role']='a';
            }
            return view('admin.view-user', $data);
        }
        return back()->with('error', 'User not found');
    }

    public function addUser(Request $request, $type,$editId=''){
        if($request->isMethod('get')){
            $data['isEdit']=false;
            if( $editId !='' ){
                $data['isEdit']=true;
                $data['user']=User::find($editId);
            }
            $data['type']=$type;
            return view('admin.add-user', $data);
        }else{
            $request->validate([
                'email'=>'email',
                'phone'=>'required|numeric|digits:10',
                'role'=>'required|in:s,c,a',
                'status'=>'required',
            ]);
            $isEdit=false;
            if($request->has('editId')){
                $isEdit=true;
            }

            if(!$isEdit){
                $request->validate([
                    'password'=>['required',Rules\Password::defaults()],
                    'confirm_password'=>['required','same:password',Rules\Password::defaults()],
                ]);

                $user=User::where(['mobile'=>$request->phone, 'role'=>$request->role])->first();
                if($user){
                    return back()->with('error', 'User already exist.');    
                }
                $user=new User();
            }else{
                $request->validate([
                    'confirm_password'=>'same:password',
                ]);
                $user=User::find($request->editId);
            }
            
            if($request->name != ''){
                $user->name=$request->name;
            }
            if($request->email != ''){    
                $user->email=$request->email;
            }

            $user->mobile=$request->phone;
            $user->role=$request->role;
            $user->status=$request->status;
            if($request->password != ''){
                $user->password=Hash::make($request->password);
            }
            if($isEdit){
                if($user->update()){
                    return back()->with('success', 'User updated successfully.');
                }
            }else{
                if($user->save()){
                    return back()->with('success', 'User created successfully.');
                }    
            }
            
            return back()->with('error', 'Something went wrong! Please try again.');
            
            
        }
    }

    // ASMIN ADD ATTRIBUTE NAMES... 
    public function AddAttribute(Request $request, $edit_id = null){

        $is_edit = is_null($edit_id) ? false : true;
        $data['is_edit'] = $is_edit;
        $data['child_categories'] = \App\Models\Category::where(['status'=> true, 'category_type'=>3])->get();

        // CHECK METHODE (GET OR POST)..............
        if($request->isMethod('get')){

            if($is_edit){
                $data['attribute'] = \App\Models\Attribute::find($edit_id);
            }
            else{
                $data['attribute'] = [];   
            }
            // VIEW ATTRIBUTE FORM PAGE (IN EDIT OR CREATE MODE)
            return view('admin.add-attribute',  $data);
        }
        else{
             // dd($request->all());
            // VALIDATE FIELDS....

            $request->validate([
            'name'=>'required',
            'category'=>'required',
           
            ]);

            // CHECK MODE (EDIT OR ADD)
            if($is_edit){
                $attribute = \App\Models\Attribute::find($request->edit_id);
                if (!$attribute) {
                    return back()->with('msg', 'Data not found');
                }
            }
            else{
                // CREATE NEW ATTRIBUTE OBJECT
                $attribute = new \App\Models\Attribute();                

            }

            // SET OTHER MODEL DATA
            $attribute->name = $request->name;
            $attribute->category_id = $request->category;              

            // ATTEMPT TO SAVE ATTRIBUTE
            if($attribute->save())
                return back()->with('msg', 'Data updated');

            // NOT SAVED,
            // RETURN BACK WITH ERROR MSG
            return back()->with('msg', 'Whoops, something went wrong? Pleae try after sometime');
        }
        
    }

    public function AddAttributeValues(Request $request, $edit_id = null){

        $is_edit = is_null($edit_id) ? false : true;
        $data['is_edit'] = $is_edit;
        $data['attributes'] = \App\Models\Attribute::join('categories', 'attributes.category_id', '=', 'categories.id')->select('categories.name as cat_name', 'attributes.name', 'attributes.id')->get();

        // CHECK METHODE (GET OR POST)..............
        if($request->isMethod('get')){

            if($is_edit){
                $data['attribute_value'] = \App\Models\Attribute_value::find($edit_id);
            }
            else{
                $data['attribute_value'] = [];   
            }
            // VIEW ATTRIBUTE FORM PAGE (IN EDIT OR CREATE MODE)
            // dd($data);
            return view('admin.add-attribute_value', $data);
        }
        else{
             // dd($request->all());
            // VALIDATE FIELDS....

            $request->validate([
            'attr_name'=>'required',
            'value'=>'required',
            'is_verified'=>'required|in:0,1',
            'status'=>'required|in:0,1',
           
            ]);

            // CHECK MODE (EDIT OR ADD)
            if($is_edit){
                $attribute_value = \App\Models\Attribute_value::find($request->edit_id);
                if (!$attribute_value) {
                    return back()->with('msg', 'Data not found');
                }
            }
            else{
                // CREATE NEW ATTRIBUTE OBJECT
                $attribute_value = new \App\Models\Attribute_value();                

            }

            // SET OTHER MODEL DATA
            $attribute_value->attribute_id = $request->attr_name;
            $attribute_value->value = $request->value;              
            $attribute_value->is_verified = $request->is_verified;              
            $attribute_value->status = $request->status;              

            // ATTEMPT TO SAVE ATTRIBUTE
            if($attribute_value->save())
                if($is_edit){
                    return redirect()->route('admin-show-attribute-values')->with('msg', 'Attribute value updated');
                }else{
                    return back()->with('msg', 'Attribute Value added successfully');
                }

            // NOT SAVED,
            // RETURN BACK WITH ERROR MSG
            return back()->with('msg', 'Whoops, something went wrong? Pleae try after sometime');
        }
        
    }

    // ADMIN SHOW ALL ATTRIBUTES ..........
    public function showAttributes(){
        // $data['attributes'] = \App\Models\Attribute::all();
        $data['attribute_value'] = \App\Models\Attribute_value::where(['status'=>true,'is_verified'=>true])->get();
        $data['attributes'] = \App\Models\Attribute::join('categories', 'attributes.category_id', '=', 'categories.id')->select('categories.name as cat_name', 'attributes.name', 'attributes.id')->get();
        // dd($data['attributes']);
        return view('admin.all-attributes', $data);
        

    }

    public function showAttributeValues(){
        $data['attribute_value'] = \App\Models\Attribute_value::all();
        return view('admin.all-attribute-values', $data);
    }

    public function addAdBanner(Request $request, $edit_id = null){
        $is_edit = is_null($edit_id) ? false : true;
        $data['is_edit'] = $is_edit;
        if($request->isMethod('get')){
            if($is_edit){
                $banner = BannerAds::find($edit_id);
                $data['banner'] = $banner;
            }
            return view('admin.add-adbanner', $data);
        }else{
            // VALIDATE FIELDS....
            //dd($request->all());
            $request->validate([
            'type'=>'required|in:Primary,Secondary',
            'status'=>'required',
            'title'=>'required',           
            'link'=>'required',           
            ]);

            // CHECK MODE (EDIT OR ADD)
            if($is_edit){
                if ($request->image) {
                    // check if emage exixts in edit mode/.................
                    $request->validate( [
                    'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
                    ]);  
                }
                $banner = BannerAds::find($request->edit_id);
                if (!$banner) {
                    return back()->with('error', 'Data not found');
                }
            }else{
                $request->validate( ['image'=>'required|image|mimes:jpeg,png,jpg|max:2048']);

                // CREATE NEW PRODUCT OBJECT
                $banner = new BannerAds();                

            }
            

            // SET OTHER MODEL DATA
            $banner->title = $request->title;
            $banner->type = $request->type;
            if(!is_null($request->subtitle))
                $banner->subtitle = $request->subtitle;
            if(!is_null($request->tagline))
                $banner->tagline = $request->tagline;
            if(!is_null($request->button_title))
                $banner->button_title = $request->button_title;
            $banner->link = $request->link;
            $banner->status = $request->status;

            // IF EMAGE IS NOT PRESENT IN EDIT MODE...    
            if ($is_edit and !$request->image) {
                    
            }
            else{
                $request->validate( ['image'=>'required|image|mimes:jpeg,png,jpg|max:2048']);
                // STORE PRODUCT IMAG IN FOLDER
                $destinationPath = public_path( '/banner_images' );
                $image = $request->file('image');
                $fileName = 'image'.time() . '.'.$image->clientExtension();
                $image->move( $destinationPath, $fileName );
                $banner->image = $fileName;
            }

            // SAVE IMAGE NAME IN DATABASE                

            // ATTEMPT TO SAVE PRODUCT
            if($banner->save()){
                if($is_edit){
                    return back()->with('success', 'Banner updated');
                }else{
                    return back()->with('success', 'Banner is successfully added.');
                }
            }
            return back()->with('error', 'Whoops, something went wrong? Pleae try after sometime');
            // NOT SAVED,
            // RETURN BACK WITH ERROR MSG
            
        }
    }

    public function allOrders(){
        $data['orders'] = \App\Models\Order::orderBy('id','desc')->get();
        return view('admin.orders', $data);
    }
    public function allPayments(){
        $data['payments'] = Payment::orderBy('id','desc')->get();
        return view('admin.payments', $data);
    }


}


