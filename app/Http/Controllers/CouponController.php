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
            $data['type']=$result->type;
            $data['min_order_amt']=$result->min_order_amt;
            $data['is_one_time']=$result->is_one_time;
            $data['id']=$id;
        }else{
            $data['title']='';
            $data['code']='';
            $data['value']='';
            $data['type']='';
            $data['min_order_amt']='';
            $data['is_one_time']='';
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
            $model->status=1;
        }
        $model->title=$request->title;
        $model->code=$request->code;
        $model->value=$request->value;
        $model->type=$request->type;
        $model->min_order_amt=$request->min_order_amt;
        $model->is_one_time=$request->is_one_time;
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
    public function status($status,$id){
        $data=Coupon::find($id);
        $data->status=$status;
        $data->save();
        session()->flash('message','Status Updated');
        return redirect('admin/coupon');
    }
}
