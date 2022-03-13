@extends('admin/layout')
@section('page_title','Manage Home Banner')
@section('home_banner_select','active')
@section('container')
    <h1>Manage Home Banner</h1>
    <a href="{{ url('admin/home_banner') }}"><button class="btn btn-success mt-3">Back</button></a>
    <div class="row m-t-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('home_banner.manage_home_banner_process') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="btn_text" class="control-label mb-1">Btn Text</label>
                                    <input id="btn_text" value="{{ $btn_text }}" name="btn_text" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                </div>
                                <div class="col-md-6">
                                    <label for="btn_link" class="control-label mb-1">Btn Link</label>
                                    <input id="btn_link" value="{{ $btn_link }}" name="btn_link" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label mb-1">Image</label>
                            <input id="image" value="{{ $image }}" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" >
                            @if ( $image!='')
                                <img width="100px" src="{{ asset('storage/media/category/'.$image) }}" alt="">
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