@extends('admin/layout')
@section('page_title','Product')
@section('product_select','active')
@section('container')

    @if (session()->has('message'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>x</span>
            </button>
        </div>
    @endif
    <h1>Products</h1>
    <a href="{{ url('admin/product/manage_product') }}"><button class="btn btn-success my-3">Add Product</button></a>
    <div class="row">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->slug }}</td>
                                <td>
                                    <a href="{{ url('admin/product/manage_product',$item->id) }}" class="btn btn-success">Edit</a>
                                    @if ($item->status==1)
                                        <a href="{{ url('admin/product/status/0',$item->id) }}" class="btn btn-primary">Active</a>
                                    @elseif ($item->status==0)
                                        <a href="{{ url('admin/product/status/1',$item->id) }}" class="btn btn-warning">Deactive</a>
                                    @endif
                                    <a href="{{ url('admin/product/delete',$item->id) }}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>
@endsection