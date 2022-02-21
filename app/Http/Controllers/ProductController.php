<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Category;
use Session;

class ProductController extends Controller
{ 
        public function showProduct(){
            $data['products'] = Product::all();
            $data['category'] = Category::all();
            
            return view('admin.all-products', $data);
          
    }


    public function ProductForm ($mode ='' , $id = ''){
        if ($id!=null and $mode!=null) { 
            $data['product'] = Product::find($id);
            $data['mode'] = $mode;
            // dd($data['product']);     
            }
        else{
            $data['product'] = [];
        }        
        $data['categories'] = Catgory::select('name', 'id')->where(['category_type'=>3,'status'=>'1'])->get(); 
        // dd($data);
        return view('admin.add-product', $data);
        }

    public function saveProduct(Request $request, $mode='', $id = ''){
        // dd($id,$mode);
        
        //VALIDATIONS..............
        $request->validate([
            'name'=>'required',
            'category'=>'required',
            'price'=>'required|numeric',
            'dis_price'=>'required|numeric',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);


        // dd($request->all());
        $name = $request->input('name');
        $category_id = $request->input('category');
        $price = $request->input('price');
        $status = $request->input('status');
        $d_price = $request->input('dis_price');
        
        

        //store image..............
        $jdestinationPath = public_path( '/product_images' );
        $image = $request->file('image');
        $fileName = time() . '.'.$image->clientExtension();
        $image->move( $destinationPath, $fileName );
        // dd($image);


        if ($mode == 'edit') {
            $product = Product::find($id);
        }
        else{
            $product = new Product();

        }
        $product->name = $name;
        $product->category_id = $category_id;
        $product->mrp = $price;
        $product->offer_price = $d_price;
        $product->image = $fileName;
        $product->status = $status;
        if ($mode == 'edit') {
            $product->update();
            Session::flash('msg', 'Prouct Update Successfully');
        }
        else{
        $product->save();
        Session::flash('msg', 'Prouct Add Successfully');    
        }
        // dd($product);
        
        return redirect()->route('admin-all-products');
        
    }    
  
    public function updateProduct(Request $request, $id){
        // dd($request);
        
            $request->validate([
                'name'=>'required',
                'category'=>'required',
                'price'=>'required|numeric',
                'dis_price'=>'required|numeric',
                'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
            $product = Product::find($id);


            $product->update();
            Session::flash('msg', 'success');
            return redirect()->route('admin-all-categories');
            // dd($id);
    }



}
