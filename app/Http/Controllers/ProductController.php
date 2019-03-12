<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //SHOW ALL PRODUCTS
    public function index(Request $request){

        $products = Product::orderBy('created_at','desc')->get();

        return response()->json($products);

    }//END GET ALL PRODUCTS

    //CREATE NEW PRODUCT
    public function create(Request $request){
        //VALIDATE PARAMS
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'units' => 'required',
            'price' => 'required',
            'image' => 'required'
        ]);

        //VALID THEN CREATE PRODUCT
        $product = new Product([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'units' => $request->input('units'),
            'price' => $request->input('price'),
            'image' => $request->input('image')
        ]);

        //SAVE PRODUCT
        $product->save();

        //RETURN RESPONSE
    return response()->json([
        'message' => 'Product has been created'
    ], 201);

    }//END CREATE

    //DELETE PRODUCT
    public function deleteProduct($id){
        //GET PRODUCT BY ID
        $product = Product::find($id);
        //DELETE PRODUCT
        $product->delete();
        
        //RETURN RESPONSE
        return response()->json([
            'message' => 'Product deleted'
        ], 200);

    }//END DELETE

}
