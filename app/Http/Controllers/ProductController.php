<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
 public function getProducts(){
    $products = Product::all();

        $response = ['products' => $products,'status'=>true];
        return response()->json($response, 200,[], JSON_NUMERIC_CHECK);
 }
 public function getProduct($productId){

    $product = Product::find($productId);

    if (!$product) {
        return response()->json(['message' => 'Product not found', 'status'=>false], 404);
    }

    
    return response()->json(['product' => $product, 'status'=>true], 200,[], JSON_NUMERIC_CHECK);
     
}
 public function postProduct(Request $request){
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'size' => 'required',
        'price' => 'required',
        'quantity' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => $validator->errors(),'status'=>false], 404);
    }

    if($request->hasFile('file')){
        $this->path = $request->file('file')->store('products');
    }else{
        return response()->json(['message' => 'Please add an Image',  'status'=>false], 404);
    }
    

    $product = new Product();
    $product->name = $request->input('name');
    $product->price = $request->input('price');
    $product->size = $request->input('size');
    $product->quantity = $request->input('quantity');
    $product->image = $this->path;
    $product->save();

    return response()->json(['product' => $product,'status'=>true], 200,[], JSON_NUMERIC_CHECK);

 }
 public function putProduct(Request $request, $productId){
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'size' => 'required',
        'price' => 'required',
        'quantity' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => $validator->errors(),'status'=>false], 404);
    }
    $product = Product::find($productId);
    if (!$product) {
        return response()->json(['message' => 'Product not found',  'status'=>false], 404);
    }

    $product->update([
        'name' => $request->input('name'),
        'size' => $request->input('size'),
        'price' => $request->input('price'),
        'quantity' => $request->input('quantity')
    ]);

    return response()->json(['product' => $product, 'status'=>true], 200,[], JSON_NUMERIC_CHECK);
     
}

public function viewFile($productId){
    $product = Product::withTrashed()->find($productId);
   if (!$product) {
       return response()->json(['message' => 'product not found', 'status'=>false], 404);
   }
   
   $pathToFile = storage_path('/app/'.$product->image);
   
   
     
   return response()->download($pathToFile);
   
}
public function deleteProduct($productId){
    $product = Product::find($productId);

    if (!$product) {
        return response()->json(['message' => 'product not found','status'=>false], 404);
    }

    $product->delete();
    return response()->json(['message' => 'product deleted successfully','status'=>true], 200);
}
}
