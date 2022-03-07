<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Coupon::all();
        return view('admin.coupon',compact('data'));
    }



    public function manage_coupon($id='')
    {

        if($id>0){
            $result=Coupon::find($id);
            $data['title']=$result->title;
            $data['code']=$result->code;
            $data['value']=$result->value;
            $data['id']=$id;
        }else{
            $data['title']='';
            $data['code']='';
            $data['value']='';
            $data['id']=0;
        }
        return view('admin.manage_coupon',$data);
    }
    public function manage_coupon_process(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'code'=>'required|unique:coupons,code,'.$request->id,
            'value'=>'required'
        ]);

        if($request->id > 0){
            $model=Coupon::find($request->id);
            $msg='Coupon Updated';
        }else{
            $model=new Coupon;
            $msg='Coupon Inserted';
        }
        $model->title=$request->title;
        $model->code=$request->code;
        $model->value=$request->value;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/coupon');
    }

    public function delete($id){
        $data=Coupon::find($id);
        $data->delete();
        session()->flash('message','Coupon deleted');
        return redirect('admin/coupon');
    }
}
