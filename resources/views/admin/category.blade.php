@extends('admin/layout')
@section('container')
    {{ session('message') }}
    <h1>Category</h1>
    <a href="category/manage_category"><button class="btn btn-success my-3">Add Category</button></a>
    <div class="row">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Category Name</th>
                            <th>Category Slug</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->category_name }}</td>
                                <td>{{ $item->category_slug }}</td>
                                <td>
                                    <a href="{{ url('admin/category/delete',$item->id) }}" class="btn btn-danger">Delete</a>
                                    <a href="{{ url('admin/category/manage_category',$item->id) }}" class="btn btn-success">Edit</a>
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