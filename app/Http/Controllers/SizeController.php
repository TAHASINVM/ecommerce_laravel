<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Size::all();
        return view('admin.size',compact('data'));
    }



    public function manage_size($id='')
    {

        if($id>0){
            $result=Size::find($id);
            $data['size']=$result->size;
            $data['status']=$result->staus;
            $data['id']=$id;
        }else{
            $data['size']='';
            $data['status']='';
            $data['id']=0;
        }
        return view('admin.manage_size',$data);
    }
    public function manage_size_process(Request $request)
    {
        $request->validate([
            'size'=>'required|unique:sizes,size,'.$request->id,
        ]);

        if($request->id > 0){
            $model=Size::find($request->id);
            $msg='Size Updated';
        }else{
            $model=new Size;
            $msg='Size Inserted';
        }
        $model->size=$request->size;
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/size');
    }

    public function delete($id){
        $data=Size::find($id);
        $data->delete();
        session()->flash('message','Size deleted');
        return redirect('admin/size');
    }
    public function status($status,$id){
        $data=Size::find($id);
        $data->status=$status;
        $data->save();
        session()->flash('message','Size Updated');
        return redirect('admin/size');
    }
}
