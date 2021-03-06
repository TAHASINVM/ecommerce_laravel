<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Crypt;
use Mail;

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
            if($pqty==0){
                DB::table('cart')
                    ->where(['id'=>$update_id])
                    ->delete();
                $msg="Removed";
            }else{
                DB::table('cart')
                    ->where(['id'=>$update_id])
                    ->update(['qty'=>$pqty]);
                $msg="UPDATED";
            }
         
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
        $result=DB::table('cart')
                ->leftJoin('products','products.id','=','cart.product_id')
                ->leftJoin('product_attr','product_attr.id','=','cart.product_attr_id')
                ->leftJoin('sizes','sizes.id','=','product_attr.size_id')
                ->leftJoin('colors','colors.id','=','product_attr.color_id')
                ->where(['user_id'=>$uid])
                ->where(['user_type'=>$user_type])
                ->select('cart.qty','products.name','products.image','sizes.size','colors.color',
                        'product_attr.price','products.slug','products.id as pid','product_attr.id as attr_id')
                ->get();
        return response()->json(['msg'=>$msg,'data'=>$result,'totalItem'=>count($result)]);
    }


    public function cart(Request $request){

        if($request->session()->has('FRONT_USER_LOGIN')){
            $uid=$request->session()->get('FRONT_USER_LOGIN');
            $user_type="Reg";
        }else{
            $uid=getUserTempId();
            $user_type="Not-Reg"; 
        }
        $result['list']=DB::table('cart')
                ->leftJoin('products','products.id','=','cart.product_id')
                ->leftJoin('product_attr','product_attr.id','=','cart.product_attr_id')
                ->leftJoin('sizes','sizes.id','=','product_attr.size_id')
                ->leftJoin('colors','colors.id','=','product_attr.color_id')
                ->where(['user_id'=>$uid])
                ->where(['user_type'=>$user_type])
                ->select('cart.qty','products.name','products.image','sizes.size','colors.color',
                        'product_attr.price','products.slug','products.id as pid','product_attr.id as attr_id')
                ->get();
        // prx($check);
        return view('front.cart',$result);
    }


    public function category(Request $request , $slug){
        $sort="";
        $sort_txt="";
        $filter_price_start="";
        $filter_price_end="";
        $color_filter="";
        $colorFilterArr=[];
        if($request->sort!=null){
            $sort=$request->sort;
        }
        $query=DB::table('products');
        $query=$query->leftJoin('categories','categories.id','=','products.category_id');
        $query=$query->leftJoin('product_attr','product_attr.product_id','=','products.id');
        $query=$query->where(['products.status'=>1]);
        $query=$query->where(['categories.category_slug'=>$slug]);
        if($sort=='name'){
            $query=$query->orderBy('products.name','asc');
            $sort_txt="Name";
        }
        if($sort=='date'){
            $query=$query->orderBy('products.id','desc');
            $sort_txt="Date";
        }
        // if($sort=='price_desc'){
        //     $query=$query->orderBy('product_attr.price','desc');
        //     $sort_txt="Price - Des";
        // }
        // if($sort=='price_asc'){
        //     $query=$query->orderBy('product_attr.price','asc');
        //     $sort_txt="Price - Asc";
        // }
        if($request->filter_price_start!=null && $request->filter_price_end!=null){
            $filter_price_start=$request->filter_price_start;
            $filter_price_end=$request->filter_price_end;
            if($filter_price_start>0 && $filter_price_end>0){
                $query=$query->whereBetween('product_attr.price',[$filter_price_start,$filter_price_end]);
            }
        }
        if($request->color_filter!=null){
            $color_filter=$request->color_filter;
            $colorFilterArr=explode(':',$color_filter);
            $colorFilterArr=array_filter($colorFilterArr);
            $query=$query->where(['product_attr.color_id' => $request->color_filter]);
        }
        $query=$query->select('products.*');
        $query=$query->get();
        $result['product']=$query;
        foreach($result['product'] as $item1){
                $query=DB::table('product_attr');
                $query=$query->leftJoin('sizes','sizes.id','=','product_attr.size_id');
                $query=$query->leftJoin('colors','colors.id','=','product_attr.color_id');
                $query=$query->where(['product_attr.product_id' => $item1->id]);
                $query=$query->get();
                $result['product_attr'][$item1->id]=$query;
        }

        $result['colors']=DB::table('colors')
                ->where(['status'=>1])
                ->get();

        $result['categories_left']=DB::table('categories')
                ->where(['status'=>1])
                ->where(['is_home'=>1])
                ->get();

        $result['slug']=$slug;
        $result['sort']=$sort;
        $result['sort_txt']=$sort_txt;
        $result['filter_price_start']=$filter_price_start;
        $result['filter_price_end']=$filter_price_end;
        $result['color_filter']=$color_filter;
        $result['colorFilterArr']=$colorFilterArr;
        return view('front.category',$result);
    }


    public function search(Request $request ,$str){
                $query=DB::table('products');
                $query=$query->leftJoin('categories','categories.id','=','products.category_id');
                $query=$query->leftJoin('product_attr','product_attr.product_id','=','products.id');
                $query=$query->where(['products.status'=>1]);
                $query=$query->where('name','like',"%$str%");
                $query=$query->orwhere('model','like',"%$str%");
                $query=$query->orwhere('short_desc','like',"%$str%");
                $query=$query->orwhere('desc','like',"%$str%");
                $query=$query->orwhere('keywords','like',"%$str%");
                $query=$query->orwhere('technical_specification','like',"%$str%");
                $query=$query->distinct()->select('products.*');
                $query=$query->get();
                $result['product']=$query;
                foreach($result['product'] as $item1){
                        $query=DB::table('product_attr');
                        $query=$query->leftJoin('sizes','sizes.id','=','product_attr.size_id');
                        $query=$query->leftJoin('colors','colors.id','=','product_attr.color_id');
                        $query=$query->where(['product_attr.product_id' => $item1->id]);
                        $query=$query->get();
                        $result['product_attr'][$item1->id]=$query;
                }
        

        return view('front.search',$result);
    }

    public function registration(Request $request){

        if($request->session()->has('FRONT_USER_LOGIN')!=null){
            return redirect('/');
        }
        $result=[];
        return view('front.registration',$result);
    }

    public function registration_process(Request $request){
        
        $valid=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:customers,email',
            'password'=>'required',
            'mobile'=>'required|numeric|digits:10',
        ]);

        if(!$valid->passes()){
            return response()->json(['status'=>'error','error'=>$valid->errors()]);
        }else{
            $rand_id=rand(111111111,999999999);
            $arr=[
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Crypt::encrypt($request->password),
                'mobile'=>$request->mobile,
                'status'=>1,
                'is_verify'=>0,
                'rand_id'=>$rand_id,
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ];
            $query=DB::table('customers')->insert($arr);
            if($query){
                $data=['name'=>$request->name,'rand_id'=>$rand_id];
                $user['to']=$request->email;
                Mail::send('front/email_verification',$data,function($messages) use ($user){
                    $messages->to($user['to']);
                    $messages->subject('Email Id Verification');
                });

                return response()->json(['status'=>'success','msg'=>'Registration Successfully. Please check your email id for verification']);
            }
        }
    }
    public function login_process(Request $request){
        
        $result=DB::table('customers')
                ->where(['email'=>$request->str_login_email])
                ->get();
        if(isset($result[0])){
            $db_pwd=Crypt::decrypt($result[0]->password);
            $status=$result[0]->status;
            $is_verify=$result[0]->is_verify;
            if($db_pwd==$request->str_login_password){
                $request->session()->put('FRONT_USER_LOGIN',true);
                $request->session()->put('FRONT_USER_ID',$result[0]->id);
                $request->session()->put('FRONT_USER_NAME',$result[0]->name);

                if($is_verify==0){
                    return response()->json(['status'=>'error','msg'=>'Please verify email id']);
                }
                if($status==0){
                    return response()->json(['status'=>'error','msg'=>'Your account has been Deactivated']);
                }
                if($request->rememberme===null){
                    setcookie('login_email',$request->str_login_email,100);
                    setcookie('login_pwd',$request->str_login_password,100);
                }else{
                    setcookie('login_email',$request->str_login_email,time()+60*60*24*100);
                    setcookie('login_pwd',$request->str_login_password,time()+60*60*24*100);
                }
                $status="success";
                $msg="";

            }else{
                $status="error";
                $msg="Please Enter Valid Password";
            }
            
        }else{
            $status="error";
            $msg="Please Enter Valid Email id";
        }
        
        return response()->json(['status'=>$status,'msg'=>$msg]);
    }

    public function email_verification(Request $request , $id){
        $result=DB::table('customers')
                    ->where(['rand_id'=>$id])
                    ->get();
        if(isset($result[0])){
            DB::table('customers')
                ->where(['id'=>$result[0]->id])
                ->update(['is_verify'=>1,'rand_id'=>'']);
            return view('front.verification');

        }else{
            return redirect('/');
        }
    }
}
