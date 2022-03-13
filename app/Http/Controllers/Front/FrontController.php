<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{

    public function index()
    {
        $result['home_categories']=DB::table('categories')
                                        ->where(['status'=>1])
                                        ->where(['is_home'=>1])
                                        ->get();

        foreach($result['home_categories'] as $item){
            $result['home_categories_product'][$item->id]=DB::table('products')
                                                    ->where(['status'=>1])
                                                    ->where(['category_id'=>$item->id])
                                                    ->get();

            foreach($result['home_categories_product'][$item->id] as $item1){
                $result['home_product_attr'][$item1->id]=DB::table('product_attr')
                        ->leftJoin('sizes','sizes.id','=','product_attr.size_id')
                        ->leftJoin('colors','colors.id','=','product_attr.color_id')
                        ->where(['product_attr.product_id' => $item1->id])
                        ->get();
            }

        }


        $result['home_brand']=DB::table('brands')
                                        ->where(['status'=>1])
                                        ->where(['is_home'=>1])
                                        ->get();
        $result['home_featured_product']=DB::table('products')
                                        ->where(['status'=>1])
                                        ->where(['is_featured'=>1])
                                        ->get();

        foreach($result['home_featured_product'] as $item1){
            $result['home_featured_product_attr'][$item1->id]=DB::table('product_attr')
                    ->leftJoin('sizes','sizes.id','=','product_attr.size_id')
                    ->leftJoin('colors','colors.id','=','product_attr.color_id')
                    ->where(['product_attr.product_id' => $item1->id])
                    ->get();
        }
        $result['home_trending_product']=DB::table('products')
                                        ->where(['status'=>1])
                                        ->where(['is_trending'=>1])
                                        ->get();

        foreach($result['home_trending_product'] as $item1){
            $result['home_trending_product_attr'][$item1->id]=DB::table('product_attr')
                    ->leftJoin('sizes','sizes.id','=','product_attr.size_id')
                    ->leftJoin('colors','colors.id','=','product_attr.color_id')
                    ->where(['product_attr.product_id' => $item1->id])
                    ->get();
        }
        $result['home_discounded_product']=DB::table('products')
                                        ->where(['status'=>1])
                                        ->where(['is_discounted'=>1])
                                        ->get();

        foreach($result['home_discounded_product'] as $item1){
            $result['home_discounded_product_attr'][$item1->id]=DB::table('product_attr')
                    ->leftJoin('sizes','sizes.id','=','product_attr.size_id')
                    ->leftJoin('colors','colors.id','=','product_attr.color_id')
                    ->where(['product_attr.product_id' => $item1->id])
                    ->get();
        } 


        $result['home_banner']=DB::table('home_banners')
                                        ->where(['status'=>1])
                                        ->get();

        return view('front.index',compact('result'));
        
    }


    public function product(Request $request , $slug){

        $result['product']=DB::table('products')
                ->where(['status'=>1])
                ->where(['slug'=>$slug])
                ->get();

        foreach($result['product'] as $item1){
                $result['product_attr'][$item1->id]=DB::table('product_attr')
                ->leftJoin('sizes','sizes.id','=','product_attr.size_id')
                ->leftJoin('colors','colors.id','=','product_attr.color_id')
                ->where(['product_attr.product_id' => $item1->id])
                ->get();
        } 

        $result['related_product']=DB::table('products')
                ->where(['status'=>1])
                ->where('slug','!=',$slug)
                ->where(['category_id'=>$result['product'][0]->category_id])
                ->get();
        foreach($result['related_product'] as $item1){
                $result['related_product_attr'][$item1->id]=DB::table('product_attr')
                ->leftJoin('sizes','sizes.id','=','product_attr.size_id')
                ->leftJoin('colors','colors.id','=','product_attr.color_id')
                ->where(['product_attr.product_id' => $item1->id])
                ->get();
        } 
        // prx($result);
        return view('front.product',$result);
    }
}
