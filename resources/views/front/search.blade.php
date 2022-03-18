@extends('front.layout');
@section('page_title','Search')
@section('container')

   <!-- product category -->
   <section id="aa-product-category">
     <div class="container">
       <div class="row">
         <div class="col-lg-9 col-md-9 col-sm-8">
           <div class="aa-product-catg-content">
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
@endsection