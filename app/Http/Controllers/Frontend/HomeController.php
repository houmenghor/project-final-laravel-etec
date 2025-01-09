<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        
        $promotion = Product::whereRaw('regular_price != sale_price')->limit(4)->get();
        // return $promotion;
        $newProduct = Product::orderBy('id','desc')->limit(4)->get();
        $popularProduct = Product::orderBy('viewer','desc')->limit(4)->get();
        // return $promotion;
        return view("frontend.index",compact('promotion','newProduct','popularProduct'));
    }

    public function productDetail($id){
        $product = Product::find($id);
        $related_product = Product::where('category',"=", $product->category)->limit(4)->get();

        Product::where('id',$id)->update([
            'viewer'=>$product->viewer+1,
        ]);

        return view('frontend.product-detail',compact('product','related_product'));
    }

    public function search(Request $request){
        $query = $request->query_search;
        $result = Product::where('name','LIKE','%'.$query.'%')->get();
        return view('frontend.search',compact('result'));            
    }
}
