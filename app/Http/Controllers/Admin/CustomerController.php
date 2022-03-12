<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Customer::all();
        return view('admin.customer',compact('data'));
    }



    public function show($id='')
    {
        $data=Customer::find($id);
        return view('admin.show_customer',compact('data'));
    }

    public function status($status,$id){
        $data=Customer::find($id);
        $data->status=$status;
        $data->save();
        session()->flash('message','Customer status Updated');
        return redirect('admin/customer');
    }
}
