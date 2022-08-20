<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Image;
use App\Models\City;
use App\Models\User;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getAllData(){
        return [];
    }    

    // Delete category............
    public function delete($type, $id){
        if ($type == 'c') {
        $data = Category::find($id);
        // dd($data);
        if(is_null($data)){
            
            Session::flash('msg', 'Data already deleted');
            return redirect()->route('admin-all-products'); 
        }
        else{
            $data->delete();
            Session::flash('msg', 'Data Deleted successfully');
            return redirect()->route('admin-all-categories');
        }
           
        }
        elseif ($type == 'p') {
        $data = Product::find($id); 
        if(is_null($data)){
            
            Session::flash('msg', 'Data already deleted');
            return redirect()->route('admin-all-products'); 
        }
        else{
            $data->delete();
            Session::flash('msg', 'Data Deleted successfully');
            return redirect()->route('admin-all-categories');
        }           
        }
    }

    public function deleteProduct($id){
        $product=Product::find($id);
        if($product){
            $images=Image::where(['type' => 'p', 'type_id' => $id])->get();
            if($images){
                foreach ($images as $image) {
                    unlink(public_path('product_images/'.$image->image));
                    $image->delete();
                }
            }
            if($product->delete()){
                return back()->with('success', 'Product deleted');
            }else{
                return back()->with('error', 'Something went wrong! Please try again');
            }
        }else{
            return back()->with('error', 'Product not found');
        }
    }

    protected function getattributeandvalue($id){
        $data=\App\Models\Attribute::with('getAttributeValues')->where(['category_id' => $id])->get();
        if($data)
            return response()->json(['status'=>true, 'data'=>$data], 200);
        else
            return response()->json(['status' => false]);
    }

    protected function checkuserbymobile($mobile, $role){
        $user=User::where('mobile', $mobile)->where('role', $role)->where('status', true)->get();
        if($user->isEmpty()){
            $data['otp']=1234;        
            $data['user']='';        
            return response()->json(['status'=>'otp', 'data'=>$data], 200);
        }else{            
            return response()->json(['status'=>true, 'data'=>$user], 200);
        }
    }

    protected function getchildbyparent($parentId, $type){
        $category= Category::where('category_type', $type)->where('parent_id', $parentId)->where('status', true)->get();
        if($category)
            return response()->json(['status'=>true, 'data'=>$category], 200);
        else
            return response()->json(['status' => false]);   
    }

    protected function deleteProductImage($id){
        $image=Image::find($id);
        // unlink(public_path('product_images/'.$image->image)) && $image->delete()
        if( $image ){
            return response()->json(['status'=>true, 'data' => $image], 200);
        }
        else{
            return response()->json(['status' => false]);
        }
    }

    protected function getcitiesfromstate($id){
        $cities= City::where('state_id', $id)->where('status', true)->orderBy('city')->get();
        if(!$cities->isEmpty())
            return response()->json(['status'=>true, 'data'=>$cities], 200);
        else
            return response()->json(['status' => false]);
    }

    

}
