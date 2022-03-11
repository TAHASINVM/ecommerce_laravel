@extends('admin/layout')
@section('page_title','Manage Brand')
@section('brand_select','active')
@section('container')

    @if ($id>0)
    {{ $image_required="" }}
    @else
    {{ $image_required="required" }}
    @endif

    @error('image')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>   
    @enderror


    <h1>Manage Brand</h1>
    <a href="{{ url('admin/brand') }}"><button class="btn btn-success mt-3">Back</button></a>
    <div class="row m-t-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('brand.manage_brand_process') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label mb-1">Brand</label>
                            <input id="name" value="{{ $name }}" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                            @error('name')
                                <div class="alert alert-danger text-center mt-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label mb-1">Image</label>
                            <input id="image" value="{{ $image }}" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" {{ $image_required }}>
                            @if ($image!="")
                                <img width="100px" src="{{ asset('storage/media/brand/'.$image) }}" alt="">
                            @endif
                            @error('image')
                                <div class="alert alert-danger text-center mt-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
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