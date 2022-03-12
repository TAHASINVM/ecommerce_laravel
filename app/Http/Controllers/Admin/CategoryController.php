<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;



class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Category::all();
        return view('admin.category',compact('data'));
    }



    public function manage_category($id='')
    {

        if($id>0){
            $result=Category::find($id);
            $data['category_name']=$result->category_name;
            $data['category_slug']=$result->category_slug;
            $data['parent_category_id']=$result->parent_category_id;
            $data['category_image']=$result->category_image;

            $data['is_home']=$result->is_home;
            $data['is_home_selected']="";
            if($result->is_home==1){
                $data['is_home_selected']="checked";
            }
            $data['id']=$id;
            $data['category']=DB::table('categories')->where(['status'=>1])->where('id','!=',$id)->get();

        }else{
            $data['category_name']='';
            $data['category_slug']='';
            $data['parent_category_id']="";
            $data['category_image']="";
            $data['is_home']="";
            $data['is_home_selected']="";
            $data['id']=0;
            $data['category']=DB::table('categories')->where(['status'=>1])->get();

        }

        return view('admin.manage_category',$data);
    }
    public function manage_category_process(Request $request)
    {
        $request->validate([
            'category_name'=>'required',
            'category_image'=>'mimes:png,jpg,jpeg',
            'category_slug'=>'required|unique:categories,category_slug,'.$request->id,
        ]);

        if($request->id > 0){
            $model=Category::find($request->id);
            $msg='Category Updated';
        }else{
            $model=new Category;
            $msg='Category Inserted';
        }
        $model->category_name=$request->category_name;
        $model->category_slug=$request->category_slug;
        $model->parent_category_id=$request->parent_category_id;
        $model->is_home=0;
        if($request->is_home!==null){
            $model->is_home=1;
        }

        if($request->hasfile('category_image')){
            if($request->id > 0){
                $arrImage=DB::table('categories')->where(['id'=>$request->id])->get();
                if( Storage::exists('/public/media/category/'.$arrImage[0]->category_image)){
                    Storage::delete('/public/media/category/'.$arrImage[0]->category_image);
                }
            }

            $image=$request->file('category_image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->storeAs('/public/media/category',$image_name);
            $model->category_image=$image_name;
        }

        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/category');
    }

    public function delete($id){
        $data=Category::find($id);
        $data->delete();
        session()->flash('message','Category deleted');
        return redirect()->back();
    }
    public function status($status,$id){
        $data=Category::find($id);
        $data->status=$status;
        $data->save();
        session()->flash('message','Status Updated');
        return redirect()->back();
    }


}
