<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop(Request $request){
        $cate = $request->cate;
        $price = $request->price;
        $promotion = $request->promotion;
        $page = $request->page;
        if($request->cate){
            $total    = Product::where('category','=',$request->cate)->count('id');
            $totalPage = ceil($total/3);
            $rsProduct = ($page-1)*3;
            $products = Product::orderBy('id','desc')->where('category','=',$request->cate)->offset($rsProduct)->limit(3)->get();
            
        }elseif($request->price=="min"){
            $total    = Product::count('id');
            $totalPage = ceil($total/3);
            $rsProduct = ($page-1)*3;
            $products = Product::orderBy('sale_price','asc')->offset($rsProduct)->limit(3)->get();
            

        }elseif($request->price=="max"){
            $total    = Product::count('id');
            $totalPage = ceil($total/3);
            $rsProduct = ($page-1)*3;
            $products = Product::orderBy('sale_price','desc')->offset($rsProduct)->limit(3)->get();
            
        }elseif($request->promotion){
            $total    = Product::whereRaw('regular_price != sale_price')->count('id');
            $totalPage = ceil($total/3);
            $rsProduct = ($page-1)*3;
            $products = Product::whereRaw('regular_price != sale_price')->offset($rsProduct)->limit(3)->get();
            
             
        }
        else{
            $total    = Product::count('id');
            $totalPage = ceil($total/3);
            $rsProduct = ($page-1)*3;
            $products = Product::orderBy('id','desc')->offset($rsProduct)->limit(3)->get();
            
             
        }
        
        $categories = Category::get();
        return view('frontend.shop',compact('products','cate','price','page','promotion','categories','totalPage'));
    }
}
