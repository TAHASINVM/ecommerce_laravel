@extends('front.layout');
@section('page_title','Cart Page')
@section('container')

 <!-- catg header banner section -->
 <section id="aa-catg-head-banner">
  <div class="aa-catg-head-banner-area">
    <div class="container">
     
    </div>
  </div>
 </section>
 <!-- / catg header banner section -->

<!-- Cart view section -->
<section id="cart-view">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="cart-view-area">
          <div class="cart-view-table">
            <form action="">
              @if (isset($list[0]))
              <div class="table-responsive">
                 <table class="table">
                   <thead>
                     <tr>
                       <th></th>
                       <th></th>
                       <th>Product</th>
                       <th>Price</th>
                       <th>Quantity</th>
                       <th>Total</th>
                     </tr>
                   </thead>
                    <tbody>
                      @foreach ($list as $item)
                        <tr id="cart_box_{{ $item->attr_id }}">
                          <td><a class="remove" href="javascript:void(0)" onclick="deleteCartProduct({{ $item->pid }},'{{ $item->size }}','{{ $item->color }}',{{ $item->attr_id }})"><fa class="fa fa-close"></fa></a></td>
                          <td><a href="{{ url('product/'.$item->slug) }}"><img src="{{ asset('storage/media/'.$item->image) }}" alt="img"></a></td>
                          <td><a class="aa-cart-title" href="{{ url('product/'.$item->slug) }}">{{ $item->name }}</a>
                            @if ($item->size!='')
                              <br>SIZE : {{ $item->size }}
                            @endif
                            @if ($item->color!='')
                              <br>COLOR : {{ $item->color }}
                            @endif
                          </td>
                          <td>${{ $item->price }}</td>
                          <td><input class="aa-cart-quantity" id="qty{{ $item->attr_id }}" type="number" value="{{ $item->qty }}" onchange="updateQty({{ $item->pid }},'{{ $item->size }}','{{ $item->color }}',{{ $item->attr_id }},{{ $item->price }})"></td>
                          <td id="total_price_{{ $item->attr_id }}">{{ $item->price * $item->qty }}</td>
                        </tr> 
                      @endforeach
                      <tr>
                        <td colspan="6" class="aa-cart-view-bottom">
                          <input class="aa-cart-view-btn" type="button" value="Checkout">
                        </td>
                      </tr>
                    </tbody>
                 </table>
               </div>
               @else
                  <h3>Cary Empty</h3>
               @endif
            </form>
            <!-- Cart Total view -->
            {{-- <div class="cart-view-total">
              <h4>Cart Totals</h4>
              <table class="aa-totals-table">
                <tbody>
                  <tr>
                    <th>Subtotal</th>
                    <td>$450</td>
                  </tr>
                  <tr>
                    <th>Total</th>
                    <td>$450</td>
                  </tr>
                </tbody>
              </table>
              <a href="#" class="aa-cart-view-btn">Proced to Checkout</a>
            </div> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- / Cart view section -->

<input type="hidden" name="qty" id="qty" value="1">  
<form action="" id="frmAddToCart">
  @csrf
 <input type="hidden" id="size_id" name="size_id">
 <input type="hidden" id="color_id" name="color_id">
 <input type="hidden" id="pqty" name="pqty">
 <input type="hidden" id="product_id" name="product_id">
</form>


@endsection