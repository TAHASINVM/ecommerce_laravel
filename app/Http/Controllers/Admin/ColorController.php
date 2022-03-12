<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Color::all();
        return view('admin.color',compact('data'));
    }



    public function manage_color($id='')
    {

        if($id>0){
            $result=Color::find($id);
            $data['color']=$result->color;
            $data['status']=$result->staus;
            $data['id']=$id;
        }else{
            $data['color']='';
            $data['status']='';
            $data['id']=0;
        }
        return view('admin.manage_color',$data);
    }
    public function manage_color_process(Request $request)
    {
        $request->validate([
            'color'=>'required|unique:colors,color,'.$request->id,
        ]);

        if($request->id > 0){
            $model=Color::find($request->id);
            $msg='Color Updated';
        }else{
            $model=new Color;
            $msg='Color Inserted';
        }
        $model->color=$request->color;
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/color');
    }

    public function delete($id){
        $data=Color::find($id);
        $data->delete();
        session()->flash('message','Color deleted');
        return redirect('admin/color');
    }
    public function status($status,$id){
        $data=Color::find($id);
        $data->status=$status;
        $data->save();
        session()->flash('message','Color Updated');
        return redirect('admin/color');
    }
}
