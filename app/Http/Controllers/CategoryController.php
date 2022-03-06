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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
