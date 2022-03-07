@extends('admin/layout')
@section('page_title','Size')
@section('size_select','active')
@section('container')
    {{ session('message') }}
    <h1>Size</h1>
    <a href="size/manage_size"><button class="btn btn-success my-3">Add Size</button></a>
    <div class="row">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Size</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->size }}</td>
                                <td>
                                    <a href="{{ url('admin/size/manage_size',$item->id) }}" class="btn btn-success">Edit</a>
                                    @if ($item->status==1)
                                        <a href="{{ url('admin/size/status/0',$item->id) }}" class="btn btn-primary">Active</a>
                                    @elseif ($item->status==0)
                                        <a href="{{ url('admin/size/status/1',$item->id) }}" class="btn btn-warning">Deactive</a>
                                    @endif
                                    <a href="{{ url('admin/size/delete',$item->id) }}" class="btn btn-danger">Delete</a>
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