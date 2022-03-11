<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Product::all();
        return view('admin.product',compact('data'));
    }



    public function manage_product($id='')
    {
        if($id>0){
            $result=Product::find($id);
            $data['category_id']=$result->category_id;
            $data['name']=$result->name;
            $data['image']=$result->image;
            $data['slug']=$result->slug;
            $data['brand']=$result->brand;
            $data['model']=$result->model;
            $data['short_desc']=$result->short_desc;
            $data['desc']=$result->desc;
            $data['keywords']=$result->keywords;
            $data['technical_specification']=$result->technical_specification;
            $data['uses']=$result->uses;
            $data['warranty']=$result->warranty;
            $data['status']=$result->status;
            $data['id']=$id;

            $data['productAttrArr']=DB::table('product_attr')->where(['product_id'=>$id])->get();
            $productImagesArr=DB::table('product_images')->where(['product_id'=>$id])->get();

            if(!isset($productImagesArr[0])){
                $data['productImagesArr'][0]['id']="";
                $data['productImagesArr'][0]['images']="";
            }else{
                $data['productImagesArr']=$productImagesArr;
            }
        }else{
            $data['category_id']='';
            $data['name']='';
            $data['image']='';
            $data['slug']='';
            $data['brand']='';
            $data['model']='';
            $data['short_desc']='';
            $data['desc']='';
            $data['keywords']='';
            $data['technical_specification']='';
            $data['uses']='';
            $data['warranty']='';
            $data['status']='';
            $data['id']=0;

            
            $data['productAttrArr'][0]['id']="";
            $data['productAttrArr'][0]['product_id']="";
            $data['productAttrArr'][0]['sku']="";
            $data['productAttrArr'][0]['attr_image']="";
            $data['productAttrArr'][0]['mrp']="";
            $data['productAttrArr'][0]['price']="";
            $data['productAttrArr'][0]['qty']="";
            $data['productAttrArr'][0]['size_id']="";
            $data['productAttrArr'][0]['color_id']="";

            $data['productImagesArr'][0]['id']="";
            $data['productImagesArr'][0]['images']="";
            
        }

        $data['category']=DB::table('categories')->where(['status'=>1])->get();
        $data['size']=DB::table('sizes')->where(['status'=>1])->get();
        $data['color']=DB::table('colors')->where(['status'=>1])->get();
        $data['brands']=DB::table('brands')->where(['status'=>1])->get();
        return view('admin.manage_product',$data);
    }
    public function manage_product_process(Request $request)
    {

        if($request->id > 0){
            $image_validation='mimes:jpeg,jpg,png';
        }else{
            $image_validation='required|mimes:jpeg,jpg,png';
        }
        $request->validate([
            'name'=>'required',
            'image'=>$image_validation,
            'slug'=>'required|unique:products,slug,'.$request->id,
            'attr_image.*' => 'mimes:png,jpg,jpeg',
            'images.*' => 'mimes:png,jpg,jpeg'
        ]);



        $paidArr=$request->paid;
        $skuArr=$request->sku;
        $mrpArr=$request->mrp;
        $priceArr=$request->price;
        $qtyArr=$request->qty;
        $size_idArr=$request->size_id;
        $color_idArr=$request->color_id;
        foreach($skuArr as $key=>$val){
            $check=DB::table('product_attr')
            ->where('sku','=',$skuArr[$key])
            ->where('id','!=',$paidArr[$key])
            ->get();

            if(isset($check[0])){
                $request->session()->flash('sku_error',$skuArr[$key].'SKU already used');
                return redirect()->back();
            }
        }


        if($request->id > 0){
            $model=Product::find($request->id);
            $msg='Product Updated';
        }else{
            $model=new Product;
            $msg='Product Inserted';
        }

        if($request->hasfile('image')){
            $image=$request->file('image');
            $ext=$image->extension();
            $image_names=time().'.'.$ext;
            $image->storeAs('/public/media',$image_names);
            $model->image=$image_names;
        }

        $model->category_id=$request->category_id;
        $model->name=$request->name;
        $model->slug=$request->slug;
        $model->brand=$request->brand;
        $model->model=$request->model;
        $model->short_desc=$request->short_desc;
        $model->desc=$request->desc;
        $model->keywords=$request->keywords;
        $model->technical_specification=$request->technical_specification;
        $model->uses=$request->uses;
        $model->warranty=$request->warranty;
        $model->status=1;
        $model->save();
        $pdi=$model->id;

        /*Product attr start*/



        foreach($skuArr as $key=>$val){
            $productAttrArr['product_id']=$pdi;
            $productAttrArr['sku']=$skuArr[$key];
            $productAttrArr['mrp']=(int)$mrpArr[$key];
            $productAttrArr['price']=(int)$priceArr[$key];
            $productAttrArr['qty']=(int)$qtyArr[$key];
            if($size_idArr[$key]==''){
                $productAttrArr['size_id']=0;
            }else{
                $productAttrArr['size_id']=$size_idArr[$key];
            }
            if($color_idArr[$key]==''){
                $productAttrArr['color_id']=0;
            }else{
                $productAttrArr['color_id']=$color_idArr[$key];
            }

            if($request->hasFile("attr_image.$key")){
                $rand=rand('111111111','999999999');
                $attr_image=$request->file("attr_image.$key");
                $ext=$attr_image->extension();
                $image_name=$rand.'.'.$ext;
                $attr_image->storeAs('/public/media',$image_name);
                $productAttrArr['attr_image']=$image_name;
            }


            if($paidArr[$key]!=''){
                DB::table('product_attr')->where(['id'=>$paidArr[$key]])->update($productAttrArr);
            }else{
                DB::table('product_attr')->insert($productAttrArr);
            }
        }
        
        
        /*Product attr end*/


        /*Product Images Start */

        $piidArr=$request->piid;
        foreach($piidArr as $key=>$val){
            $productImagesArr['product_id']=$pdi;
            if($request->hasFile("images.$key")){
                $rand=rand('111111111','999999999');
                $images=$request->file("images.$key");
                $ext=$images->extension();
                $image_name=$rand.'.'.$ext;
                $images->storeAs('/public/media',$image_name);
                $productImagesArr['images']=$image_name;



                
                if($piidArr[$key]!=''){
                    DB::table('product_images')->where(['id'=>$piidArr[$key]])->update($productImagesArr);
                }else{
                    DB::table('product_images')->insert($productImagesArr);
                }
            }


        }


        /*Product Images End */

        $request->session()->flash('message',$msg);
        return redirect('admin/product');
    }

    public function delete($id){
        $data=Product::find($id);
        $data->delete();
        session()->flash('message','Product deleted');
        return redirect('admin/product');
    }
    public function product_attr_delete($paid,$pid){
        DB::table('product_attr')->where(['id'=>$paid])->delete();
        return redirect('admin/product/manage_product/'.$pid);
    }
    public function product_images_delete($piid,$pid){
        DB::table('product_images')->where(['id'=>$piid])->delete();
        return redirect('admin/product/manage_product/'.$pid);
    }
    public function status($status,$id){
        $data=Product::find($id);
        $data->status=$status;
        $data->save();
        session()->flash('message','Product Status Updated');
        return redirect('admin/product');
    }
}
