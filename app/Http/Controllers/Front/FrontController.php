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

        foreach($result['product'] as $item1){
            $result['product_images'][$item1->id]=DB::table('product_images')
            ->where(['product_id' => $item1->id])
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

    public function add_to_cart(Request $request){
        if($request->session()->has('FRONT_USER_LOGIN')){
            $uid=$request->session()->get('FRONT_USER_LOGIN');
            $user_type="Reg";
        }else{
            $uid=getUserTempId();
            $user_type="Not-Reg"; 
        }
        $size_id=$request->size_id;
        $color_id=$request->color_id;
        $pqty=$request->pqty;
        $product_id=$request->product_id;

        $result=DB::table('product_attr')
                ->select('product_attr.id')
                ->leftJoin('sizes','sizes.id','=','product_attr.size_id')
                ->leftJoin('colors','colors.id','=','product_attr.color_id')
                ->where(['product_id'=> $product_id])
                ->where(['sizes.size'=> $size_id])
                ->where(['colors.color'=> $color_id])
                ->get();

        $product_attr_id=$result[0]->id;

        $check=DB::table('cart')
                ->where(['user_id'=>$uid])
                ->where(['user_type'=>$user_type])
                ->where(['product_id'=>$product_id])
                ->where(['product_attr_id'=>$product_attr_id])
                ->get();
        if(isset($check[0])){
            $update_id=$check[0]->id;
            DB::table('cart')
                ->where(['id'=>$update_id])
                ->update(['qty'=>$pqty]);
            $msg="UPDATED";
        }else{
            $id=DB::table('cart')->insertGetId([
                'user_id'=>$uid,
                'user_type'=>$user_type,
                'product_id'=>$product_id,
                'product_attr_id'=>$product_attr_id,
                'qty'=>$pqty,
                'added_on'=>date('Y-m-d h:i:s')
            ]);
            $msg="ADDED";
        }
        return response()->json(['msg'=>$msg]);
    }
}
