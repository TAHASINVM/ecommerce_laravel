<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Tax::all();
        return view('admin.tax',compact('data'));
    }



    public function manage_tax($id='')
    {

        if($id>0){
            $result=Tax::find($id);
            $data['tax_desc']=$result->tax_desc;
            $data['tax_value']=$result->tax_value;
            $data['status']=$result->status;
            $data['id']=$id;
        }else{
            $data['tax_desc']='';
            $data['tax_value']='';
            $data['status']='';
            $data['id']=0;
        }
        return view('admin.manage_tax',$data);
    }
    public function manage_tax_process(Request $request)
    {
        $request->validate([
            'tax_value'=>'required|unique:taxes,tax_value,'.$request->id,
        ]);

        if($request->id > 0){
            $model=Tax::find($request->id);
            $msg='Tax Updated';
        }else{
            $model=new Tax;
            $msg='Tax Inserted';
        }
        $model->tax_desc=$request->tax_desc;
        $model->tax_value=$request->tax_value;
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/tax');
    }

    public function delete($id){
        $data=Tax::find($id);
        $data->delete();
        session()->flash('message','Tax deleted');
        return redirect('admin/tax');
    }
    public function status($status,$id){
        $data=Tax::find($id);
        $data->status=$status;
        $data->save();
        session()->flash('message','Tax Updated');
        return redirect('admin/tax');
    }
}
