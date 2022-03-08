@extends('admin/layout')
@section('page_title','Manage Product')
@section('product_select','active')
@section('container')

    @if ($id>0)
        {{ $image_required="" }}
    @else
        {{ $image_required="required" }}
    @endif


    <h1>Manage Product</h1>
    <a href="{{ url('admin/product') }}"><button class="btn btn-success mt-3">Back</button></a>
    <div class="row m-t-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product.manage_product_process') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label mb-1">Product</label>
                            <input id="name" value="{{ $name }}" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                            @error('name')
                                <div class="alert alert-danger text-center mt-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug" class="control-label mb-1">Slug</label>
                            <input id="slug" value="{{ $slug }}" name="slug" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                            @error('slug')
                                <div class="alert alert-danger text-center mt-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label mb-1">Slug</label>
                            <input id="image" value="{{ $image }}" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" {{ $image_required }}>
                            @error('image')
                                <div class="alert alert-danger text-center mt-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="control-label mb-1">Category</label>
                            <select  id="category_id" value="{{ $category_id }}" name="category_id" class="form-control" aria-required="true" aria-invalid="false" required>
                                <option value="">Select Categories</option>
                                @foreach ($category as $item)
                                    @if ($category_id==$item->id)
                                        <option selected value="{{ $item->id }}"> 
                                    @else
                                        <option value="{{ $item->id }}"> 
                                    @endif
                                    {{ $item->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brand" class="control-label mb-1">Brand</label>
                            <input id="brand" value="{{ $brand }}" name="brand" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                        </div>
                        <div class="form-group">
                            <label for="model" class="control-label mb-1">Model</label>
                            <input id="model" value="{{ $model }}" name="model" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                        </div>
                        <div class="form-group">
                            <label for="short_desc" class="control-label mb-1">Short Desc</label>
                            <textarea  id="short_desc" name="short_desc" class="form-control" aria-required="true" aria-invalid="false" required>{{ $short_desc }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="desc" class="control-label mb-1">Desc</label>
                            <textarea id="desc" name="desc" class="form-control" aria-required="true" aria-invalid="false" required>{{ $desc }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="keywords" class="control-label mb-1">Keywords</label>
                            <textarea id="keywords" name="keywords" class="form-control" aria-required="true" aria-invalid="false" required>{{ $keywords }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="technical_specification" class="control-label mb-1">Technical Specification</label>
                            <textarea id="technical_specification" name="technical_specification" class="form-control" aria-required="true" aria-invalid="false" required>{{ $technical_specification }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="uses" class="control-label mb-1">Uses</label>
                            <textarea id="uses" name="uses" class="form-control" aria-required="true" aria-invalid="false" required>{{ $uses }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="warranty" class="control-label mb-1">Warranty</label>
                            <textarea id="warranty" name="warranty" class="form-control" aria-required="true" aria-invalid="false" required>{{ $warranty }}</textarea>
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