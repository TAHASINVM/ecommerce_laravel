@extends('front.layout');
@section('page_title','Category')
@section('container')

  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
    <div class="aa-catg-head-banner-area">
      <div class="container">
       <div class="aa-catg-head-banner-content">
         
       </div>
      </div>
    </div>
   </section>
   <!-- / catg header banner section -->
 
   <!-- product category -->
   <section id="aa-product-category">
     <div class="container">
       <div class="row">
         <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
           <div class="aa-product-catg-content">
             <div class="aa-product-catg-head">
               <div class="aa-product-catg-head-left">
                 <form action="" class="aa-sort-form">
                   <label for="">Sort by</label>
                   <select name="" onchange="sort_by()" id="sort_by_value">
                     <option value="1" selected="Default">Default</option>
                     <option value="name">Name</option>
                     <option value="price_desc">Price Desc</option>
                     <option value="price_asc">Price Asc</option>
                     <option value="date">Date</option>
                    </select>
                    {{ $sort_txt }}
                 </form>
               </div>
               <div class="aa-product-catg-head-right">
                 <a id="grid-catg" href="#"><span class="fa fa-th"></span></a>
                 <a id="list-catg" href="#"><span class="fa fa-list"></span></a>
               </div>
             </div>
             <div class="aa-product-catg-body">
               <ul class="aa-product-catg">
                  <!-- start single product item -->
                  @if (isset($product[0]))  
                    @foreach ($product as $product)
                      <li>
                        <figure>
                          <a class="aa-product-img" href="{{ url('product/'.$product->slug) }}"><img src="{{ asset('storage/media/'.$product->image) }}" alt="{{ $product->name }}"></a>
                          <a class="aa-add-card-btn" href="javascript:void(0)" onclick="home_add_to_cart({{ $product->id }},'{{ $product_attr[$product->id][0]->size }}','{{ $product_attr[$product->id][0]->color}}')"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                          <figcaption>
                            <h4 class="aa-product-title"><a href="{{ url('product/'.$product->slug) }}">{{ $product->name }}</a></h4>
                            <span class="aa-product-price">Rs {{ $product_attr[$product->id][0]->price }}</span>
                            <span class="aa-product-price"><del>Rs {{ $product_attr[$product->id][0]->mrp }}</del></span>
                          </figcaption>
                        </figure>                         
                      </li>                        
                    @endforeach
                  @else
                    <li>
                      <figure>
                        No Data Found
                      </figure>
                    </li>
                  @endif
               </ul>
             </div>
           </div>
         </div>
         <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
           <aside class="aa-sidebar">
             <!-- single sidebar -->
             <div class="aa-sidebar-widget">
               <h3>Category</h3>
               <ul class="aa-catg-nav">
                 @foreach ($categories_left as $item)
                  @if ($slug==$item->category_slug)
                    <li><a href="{{ url('category/'.$item->category_slug) }}" class="left_cat_active">{{ $item->category_name }}</a></li>
                  @else
                    <li><a href="{{ url('category/'.$item->category_slug) }}">{{ $item->category_name }}</a></li>
                  @endif
                 @endforeach
               </ul>
             </div>
             <!-- single sidebar -->
             <div class="aa-sidebar-widget">
               <h3>Shop By Price</h3>              
               <!-- price range -->
               <div class="aa-sidebar-price-range">
                <form action="">
                   <div id="skipstep" class="noUi-target noUi-ltr noUi-horizontal noUi-background">
                   </div>
                   <span id="skip-value-lower" class="example-val">30.00</span>
                  <span id="skip-value-upper" class="example-val">100.00</span>
                  <button class="aa-filter-btn" type="button" onclick="sort_price_filter()">Filter</button>
                </form>
               </div>              
 
             </div>
             <!-- single sidebar -->
             <div class="aa-sidebar-widget">
               <h3>Shop By Color</h3>
               <div class="aa-color-tag">
                 @foreach ($colors as $item)
                  @if(in_array($item->id,$colorFilterArr))
                    <a class="aa-color-{{ $item->color }} active_color" href="javascript:void(0)" onclick="setColor('{{ $item->id }}','1')"></a> 
                  @else
                    <a class="aa-color-{{ $item->color }}" href="javascript:void(0)" onclick="setColor('{{ $item->id }}','0')"></a> 
                  @endif 
                 @endforeach
               </div>                            
             </div>
           </aside>
         </div>
       </div>
     </div>
   </section>
   <!-- / product category -->

   <input type="hidden" name="qty" id="qty" value="1">  
   <form action="" id="frmAddToCart">
     @csrf
    <input type="hidden" id="size_id" name="size_id">
    <input type="hidden" id="color_id" name="color_id">
    <input type="hidden" id="pqty" name="pqty">
    <input type="hidden" id="product_id" name="product_id">
   </form>

   <form action="" id="categoryfilter">
    <input type="hidden" id="sort" name="sort" value="{{ $sort }}">
    <input type="hidden" id="filter_price_start" name="filter_price_start" value="{{ $filter_price_start }}">
    <input type="hidden" id="filter_price_end" name="filter_price_end" value="{{ $filter_price_end }}">
    <input type="hidden" id="color_filter" name="color_filter" value="{{ $color_filter }}">
  </form>



@endsection