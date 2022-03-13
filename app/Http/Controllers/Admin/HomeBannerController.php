<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\HomeBanner;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\DB;


class HomeBannerController extends Controller
{
    public function index()
    {
        $data=HomeBanner::all();
        return view('admin.home_banner',compact('data'));
    }



    public function manage_home_banner($id='')
    {

        if($id>0){
            $result=HomeBanner::find($id);
            $data['image']=$result->image;
            $data['btn_text']=$result->btn_text;
            $data['btn_link']=$result->btn_link;
            $data['id']=$id;
        }else{
            $data['image']='';
            $data['btn_text']='';
            $data['btn_link']='';
            $data['id']=0;
        }

        return view('admin.manage_home_banner',$data);
    }
    public function manage_home_banner_process(Request $request)
    {
        $request->validate([
            'image'=>'required|mimes:jpeg,jp,png',
        ]);

        if($request->id > 0){
            $model=HomeBanner::find($request->id);
            $msg='HomeBanner Updated';
        }else{
            $model=new HomeBanner;
            $msg='HomeBanner Inserted';
        }
        $model->btn_text=$request->btn_text;
        $model->btn_link=$request->btn_link;

        if($request->hasfile('image')){
            if($request->id > 0){
                $arrImage=DB::table('home_banners')->where(['id'=>$request->id])->get();
                if( Storage::exists('/public/media/banner/'.$arrImage[0]->image)){
                    Storage::delete('/public/media/banner/'.$arrImage[0]->image);
                }
            }

            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->storeAs('/public/media/banner',$image_name);
            $model->image=$image_name;
        }

        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/home_banner');
    }

    public function delete($id){
        $data=HomeBanner::find($id);
        $data->delete();
        session()->flash('message','Banner deleted');
        return redirect()->back();
    }
    public function status($status,$id){
        $data=HomeBanner::find($id);
        $data->status=$status;
        $data->save();
        session()->flash('message','Banner Status Updated');
        return redirect()->back();
    }
}
