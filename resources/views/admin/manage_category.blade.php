@extends('admin/layout')
@section('page_title','Manage Category')
@section('category_select','active')
@section('container')
    <h1>Manage Category</h1>
    <a href="{{ url('admin/category') }}"><button class="btn btn-success mt-3">Back</button></a>
    <div class="row m-t-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('category.manage_category_process') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="category_name" class="control-label mb-1">Category</label>
                                    <input id="category_name" value="{{ $category_name }}" name="category_name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="category_slug" class="control-label mb-1">Category Slug</label>
                                    <input id="category_slug" value="{{ $category_slug }}" name="category_slug" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('category_slug')
                                        <div class="alert alert-danger text-center mt-2" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="parent_category_id" class="control-label mb-1">Parent Category</label>
                                    <select  id="parent_category_id" value="{{ $parent_category_id }}" name="parent_category_id" class="form-control" aria-required="true" aria-invalid="false" required>
                                        <option value="0">Select Categories</option>
                                        @foreach ($category as $item)
                                            @if ($parent_category_id==$item->id)
                                                <option selected value="{{ $item->id }}"> 
                                            @else
                                                <option value="{{ $item->id }}"> 
                                            @endif
                                            {{ $item->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_image" class="control-label mb-1">Category Image</label>
                            <input id="category_image" value="{{ $category_image }}" name="category_image" type="file" class="form-control" aria-required="true" aria-invalid="false" >
                            @if ( $category_image!='')
                                <img width="100px" src="{{ asset('storage/media/category/'.$category_image) }}" alt="">
                            @endif 
                            @error('category_image')
                                <div class="alert alert-danger text-center mt-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="is_home" class="control-label mb-1">Show In Home Page</label>
                            <input id="is_home"  name="is_home" type="checkbox" {{ $is_home_selected }}>
                        </div>
                        <div>
                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                Submit
                            </button>
                        </div>
                        <input type="hidden" name="id" value="{{ $id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection