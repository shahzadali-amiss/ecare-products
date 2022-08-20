<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function removeFromCart(Request $request){
        $cart = \App\Models\Cart::find($request->id);
        $cart->delete();
        return $this->getCartItems($request);
    }

    public function addItemIntoCart(Request $request){
        // dd($request->all());

        // GET PRODUCT
        $product = \App\Models\Product::find($request->pid);

        $cart = new \App\Models\Cart();
        $cart->product_id = $product->id;
        $cart->price = $product->offer_price;
        $cart->quantity = $request->qty;
        $cart->user_id = $request->user_id;
        $cart->visitor_id = $request->visitor_id;

        if($cart->save())
            return response()->json(['status' => true, 'product' => $this->cartResource($cart, $product)]);

        return response()->json(['status' => false]);
    }

    public function getCartItems(Request $request){
        $cart = \App\Models\Cart::visitor($request)->with('product')->available()->get();
        $data = [];
        foreach($cart as $item){
            $data[] = $this->cartResource($item, $item->product);
        }

        return response()->json(['status' => true, 'product' => $data]);
    }

    private function cartResource($cart, $product){
        return [
            'id' => $cart->id,
            'name' => ucwords($product->name),
            'quantity' => $cart->quantity,
            'price' => $cart->price,
            'image' => $product->image,
        ];
    }
}