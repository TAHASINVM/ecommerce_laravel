@extends('admin/layout')
@section('page_title','Coupon')
@section('container')
    {{ session('message') }}
    <h1>Coupon</h1>
    <a href="{{ url('admin/coupon/manage_coupon') }}"><button class="btn btn-success my-3">Add Coupon</button></a>
    <div class="row">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Title</th>
                            <th>Code</th>
                            <th>Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->value }}</td>
                                <td>
                                    <a href="{{ url('admin/coupon/delete',$item->id) }}" class="btn btn-danger">Delete</a>
                                    <a href="{{ url('admin/coupon/manage_coupon',$item->id) }}" class="btn btn-success">Edit</a>
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