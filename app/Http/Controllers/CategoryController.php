<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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
            $data['id']=$id;
        }else{
            $data['category_name']='';
            $data['category_slug']='';
            $data['id']=0;
        }
        return view('admin.manage_category',$data);
    }
    public function manage_category_process(Request $request)
    {
        $request->validate([
            'category_name'=>'required',
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
