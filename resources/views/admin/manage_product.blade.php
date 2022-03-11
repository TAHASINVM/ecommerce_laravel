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
    
    @if (session()->has('sku_error'))
        <div class="alert alert-danger" role="alert">
            {{ session('sku_error') }} 
        </div> 
    @endif
    @error('attr_image.*')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>   
    @enderror
    @error('images.*')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>   
    @enderror
    <a href="{{ url('admin/product') }}"><button class="btn btn-success mt-3">Back</button></a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <form action="{{ route('product.manage_product_process') }}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
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
                                    <label for="image" class="control-label mb-1">Image</label>
                                    <input id="image" value="{{ $image }}" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" {{ $image_required }}>
                                    @error('image')
                                        <div class="alert alert-danger text-center mt-2" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-4">
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
                                        <div class="col-4">
                                            <label for="brand" class="control-label mb-1">Brand</label>
                                            <select  id="brand" value="{{ $brand }}" name="brand" class="form-control" aria-required="true" aria-invalid="false" required>
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $item)
                                                    @if ($brand==$item->id)
                                                        <option selected value="{{ $item->id }}"> 
                                                    @else
                                                        <option value="{{ $item->id }}"> 
                                                    @endif
                                                    {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <label for="model" class="control-label mb-1">Model</label>
                                            <input id="model" value="{{ $model }}" name="model" type="text" class="form-control" aria-required="true" aria-invalid="false" required>        
                                        </div>
                                    </div>
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
                            
                                <input type="hidden" name="id" value="{{ $id }}">
                            </div>
                        </div>   
                    </div>
                    <h2 class="mb-3">Product Attributes</h2>
                    <div class="col-lg-12" id="product_attr_box">
                        @php
                            $loop_count_num=1 
                        @endphp
                        @foreach ($productAttrArr as $key=>$val)
                            <?php
                                $pAArr=(array)$val;
                            ?>
                            <input id="paid" name="paid[]" type="hidden" value="{{ $pAArr['id'] }}">        
                            <div class="card" id="product_attr_{{ $loop_count_num++ }}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="sku" class="control-label mb-1">SKU</label>
                                                <input id="sku" name="sku[]" type="text" value="{{ $pAArr['sku'] }}" class="form-control" aria-required="true" aria-invalid="false" required>        
                                            </div>
                                            <div class="col-2">
                                                <label for="mrp" class="control-label mb-1">MRP</label>
                                                <input id="mrp" name="mrp[]" type="text"  value="{{ $pAArr['mrp'] }}" class="form-control" aria-required="true" aria-invalid="false" required>        
                                            </div>
                                            <div class="col-2">
                                                <label for="price" class="control-label mb-1">Price</label>
                                                <input id="price" name="price[]" type="text" value="{{ $pAArr['price'] }}" class="form-control" aria-required="true" aria-invalid="false" required>        
                                            </div>
                                            <div class="col-3">
                                                <label for="size_id" class="control-label mb-1">Price</label>
                                                <select  id="size_id" name="size_id[]" class="form-control" aria-required="true" aria-invalid="false" >
                                                    <option value="">Select</option>
                                                    @foreach ($size as $item)
                                                        @if ($pAArr['size_id']==$item->id )
                                                            <option selected value="{{ $item->id }}">{{ $item->size }}</option>
                                                        @else
                                                            <option value="{{ $item->id }}">{{ $item->size }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>                                        
                                            </div>
                                            <div class="col-3">
                                                <label for="color_id" class="control-label mb-1">Color</label>
                                                <select  id="color_id" name="color_id[]" class="form-control" aria-required="true" aria-invalid="false" >
                                                    <option value="">Select</option>
                                                    @foreach ($color as $item)
                                                        @if ($pAArr['color_id']==$item->id )
                                                            <option selected value="{{ $item->id }}">{{ $item->color }}</option>
                                                        @else
                                                            <option value="{{ $item->id }}">{{ $item->color }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>                                        
                                            </div>
                                            <div class="col-2">
                                                <label for="qty" class="control-label mb-1">Qty</label>
                                                <input id="qty" name="qty[]" type="text" value="{{ $pAArr['qty'] }}" class="form-control" aria-required="true" aria-invalid="false" required>        
                                            </div>
                                            <div class="col-4">
                                                <label for="attr_image" class="control-label mb-1">Image</label>
                                                <input id="attr_image" name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" required> 
                                                @if ( $pAArr['attr_image']!='')
                                                    <img width="100px" src="{{ asset('storage/media/'.$pAArr['attr_image']) }}" alt=""></td>
                                                @endif                                             
                                            </div>
                                            <div class="col-2">
                                                <label for="" class="control-label mb-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>

                                                @if($loop_count_num==2)
                                                <button type='button' class="btn btn-success btn-lg" onclick="add_more()">
                                                    <i class="fa fa-plus"></i>&nbsp;Add
                                                </button>
                                                @else
                                                    <a href="{{ url('admin/product/product_attr_delete/')}}/{{ $pAArr['id'] }}/{{ $id }}">
                                                        <button type='button' class="btn btn-danger btn-lg" onclick="remove_more({{ $loop_count_num-1 }})">
                                                            <i class="fa fa-minus"></i>&nbsp;Remove
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <h2 class="mb-3">Product Images</h2>
                    <div class="col-lg-12" >
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row" id="product_images_box">
                                            @php
                                                $loop_count_num=1 
                                            @endphp
                                            @foreach ($productImagesArr as $key=>$val)
                                                <?php
                                                    $pIArr=(array)$val;
                                                ?>
                                                <input id="piid" name="piid[]" type="hidden" value="{{ $pIArr['id'] }}"> 
                                            <div class="col-4 product_images_{{ $loop_count_num++ }}" >
                                                <label for="images" class="control-label mb-1">Image</label>
                                                <input id="images" name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" required> 
                                                @if ( $pIArr['images']!='')
                                                    <a href="{{ asset('storage/media/'.$pIArr['images']) }}" target="_blank"><img width="100px" src="{{ asset('storage/media/'.$pIArr['images']) }}" alt=""></a>
                                                @endif                                             
                                            </div>
                                            <div class="col-2" >
                                                <label for="" class="control-label mb-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                @if($loop_count_num==2)
                                                <button type='button' class="btn btn-success btn-lg" onclick="add_image_more()">
                                                    <i class="fa fa-plus"></i>&nbsp;Add
                                                </button>
                                                @else
                                                    <a href="{{ url('admin/product/product_images_delete/')}}/{{ $pIArr['id'] }}/{{ $id }}">
                                                        <button type='button' class="btn btn-danger btn-lg" onclick="remove_image_more({{ $loop_count_num-1 }})">
                                                            <i class="fa fa-minus"></i>&nbsp;Remove
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                            
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div>
                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var loop_count=1;
        function add_more(){
            loop_count++
            let html=`<input id="paid" name="paid[]" type="hidden" >        
                    <div class="card" id="product_attr_${loop_count}">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">`;

            html+=`<div class="col-2">
                        <label for="sku" class="control-label mb-1">SKU</label>
                        <input id="sku" name="sku[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>        
                    </div>`
            html+=`<div class="col-2">
                        <label for="mrp" class="control-label mb-1">MRP</label>
                        <input id="mrp" name="mrp[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>        
                    </div>`
            html+=`<div class="col-2">
                        <label for="price" class="control-label mb-1">Price</label>
                        <input id="price" name="price[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>        
                    </div>`
            var size_id_html=jQuery('#size_id').html();
            size_id_html=size_id_html.replace("selected","")
            html+=`<div class="col-3">
                        <label for="size_id" class="control-label mb-1">Price</label>
                        <select  id="size_id" name="size_id[]" class="form-control" aria-required="true" aria-invalid="false" >
                            ${size_id_html}
                        </select>                                        
                    </div>`
            var color_id_html=jQuery('#color_id').html();
            color_id_html=color_id_html.replace("selected","")
            html+=`<div class="col-3">
                        <label for="color_id" class="control-label mb-1">Color</label>
                        <select  id="color_id" name="color_id[]" class="form-control" aria-required="true" aria-invalid="false" >
                            ${color_id_html}
                        </select>                                        
                    </div>`
            html+=`<div class="col-2">
                        <label for="qty" class="control-label mb-1">Qty</label>
                        <input id="qty" name="qty[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>        
                    </div>`
            html+=`<div class="col-4">
                        <label for="attr_image" class="control-label mb-1">Image</label>
                        <input id="attr_image" name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" required>                                              
                    </div>`
            html+=`<div class="col-2">
                        <label for="" class="control-label mb-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <button type='button' class="btn btn-danger btn-lg" onclick="remove_more(${loop_count})">
                            <i class="fa fa-minus"></i>&nbsp;Remove
                        </button>
                    </div>`

            html+="</div></div></div></div>";

            jQuery('#product_attr_box').append(html)
        }

        function remove_more(loop_count){
            jQuery('#product_attr_'+loop_count).remove();
        }


        var loop_image_count=1;
        function add_image_more(){
            loop_image_count++;
            var html=`<input id="piid" name="piid[]" type="hidden" value=""">
                    <div class="col-4 product_images_${loop_image_count}">
                        <label for="images" class="control-label mb-1">Image</label>
                        <input id="images" name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" required>                                              
                    </div>`
            html+=`<div class="col-2 product_images_${loop_image_count}">
                        <label for="" class="control-label mb-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <button type='button' class="btn btn-danger btn-lg" onclick="remove_image_more(${loop_image_count})">
                            <i class="fa fa-minus"></i>&nbsp;Remove
                        </button>
                    </div>`

            jQuery('#product_images_box').append(html)
        }

        function remove_image_more(loop_image_count){
            jQuery('.product_images_'+loop_image_count).remove();
        }
    </script>
@endsection