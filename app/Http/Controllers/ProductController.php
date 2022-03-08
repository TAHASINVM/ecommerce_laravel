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
        }

        $data['category']=DB::table('categories')->where(['status'=>1])->get();
        return view('admin.manage_product',$data);
    }
    public function manage_product_process(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:products,slug,'.$request->id,
        ]);

        if($request->id > 0){
            $model=Product::find($request->id);
            $msg='Product Updated';
        }else{
            $model=new Product;
            $msg='Product Inserted';
        }
        $model->category_id=$request->category_id;
        $model->name=$request->name;
        $model->image=$request->image;
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
        $request->session()->flash('message',$msg);
        return redirect('admin/product');
    }

    public function delete($id){
        $data=Product::find($id);
        $data->delete();
        session()->flash('message','Product deleted');
        return redirect('admin/product');
    }
    public function status($status,$id){
        $data=Product::find($id);
        $data->status=$status;
        $data->save();
        session()->flash('message','Product Status Updated');
        return redirect('admin/product');
    }
}
