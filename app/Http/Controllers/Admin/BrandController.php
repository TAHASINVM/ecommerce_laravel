<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Brand::all();
        return view('admin.brand',compact('data'));
    }



    public function manage_brand($id='')
    {

        if($id>0){
            $result=Brand::find($id);
            $data['name']=$result->name;
            $data['image']=$result->image;
            $data['is_home']=$result->is_home;
            $data['is_home_selected']="";
            if($result->is_home==1){
                $data['is_home_selected']="checked";
            }
            $data['status']=$result->staus;
            $data['id']=$id;
        }else{
            $data['name']='';
            $data['image']='';
            $data['is_home']="";
            $data['is_home_selected']="";
            $data['status']='';
            $data['id']=0;
        }
        return view('admin.manage_brand',$data);
    }
    public function manage_brand_process(Request $request)
    {
        
   
        $request->validate([
            'name'=>'required|unique:brands,name,'.$request->id,
            'image'=>'mimes:jpeg,jpg,png',
        ]);

        if($request->id > 0){
            $model=Brand::find($request->id);
            $msg='Brand Updated';
        }else{
            $model=new Brand;
            $msg='Brand Inserted';
        }

        if($request->hasfile('image')){
            
            if($request->id > 0){
                $arrImage=DB::table('brands')->where(['id'=>$request->id])->get();
                if( Storage::exists('/public/media/brand/'.$arrImage[0]->image)){
                    Storage::delete('/public/media/brand/'.$arrImage[0]->image);
                }
            }
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->storeAs('/public/media/brand',$image_name);
            $model->image=$image_name;
        }

        $model->name=$request->name;
        $model->is_home=0;
        if($request->is_home!==null){
            $model->is_home=1;
        }
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/brand');
    }

    public function delete($id){
        $data=Brand::find($id);
        $data->delete();
        session()->flash('message','Brand deleted');
        return redirect('admin/brand');
    }
    public function status($status,$id){
        $data=Brand::find($id);
        $data->status=$status;
        $data->save();
        session()->flash('message','Brand Updated');
        return redirect('admin/brand');
    }
}
