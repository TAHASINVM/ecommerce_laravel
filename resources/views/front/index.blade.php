@extends('front.layout');
@section('page_title','Home Page')
@section('container')


  <!-- Start slider -->
  <section id="aa-slider">
    <div class="aa-slider-area">
      <div id="sequence" class="seq">
        <div class="seq-screen">
          <ul class="seq-canvas">
            <!-- single slide item -->
            @foreach ($result['home_banner'] as $item)
              <li>
                <div class="seq-model">
                  <img data-seq src="{{ asset('storage/media/banner/'.$item->image) }}" alt="" />
                </div>
                <div class="seq-title">
                  @if ($item->btn_text!="")
                    <a data-seq href="{{ $item->btn_link }}" target="_blank" class="aa-shop-now-btn aa-secondary-btn">{{ $item->btn_text }}</a>
                  @endif
                </div>
              </li>          
            @endforeach
          </ul>
        </div>
        <!-- slider navigation btn -->
        <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
          <a type="button" class="seq-prev" aria-label="Previous"><span class="fa fa-angle-left"></span></a>
          <a type="button" class="seq-next" aria-label="Next"><span class="fa fa-angle-right"></span></a>
        </fieldset>
      </div>
    </div>
  </section>
  <!-- / slider -->
  <!-- Start Promo section -->
  <section id="aa-promo">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-promo-area">
            <div class="row">
              <div class="col-md-12 no-padding">
                <div class="aa-promo-right">
                  @foreach ($result['home_categories'] as $item)
                    <div class="aa-single-promo-right">
                      <div class="aa-promo-banner">                      
                        <img src="{{ asset('storage/media/category/'.$item->category_image) }}" alt="img">                      
                        <div class="aa-prom-content">
                          <h4><a href="{{ url('category/'.$item->category_slug) }}">For {{ $item->category_name }}</a></h4>                        
                        </div>
                      </div>
                    </div>  
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Promo section -->
  <!-- Products section -->
  <section id="aa-product">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-product-area">
              <div class="aa-product-inner">
                <!-- start prduct navigation -->
                 <ul class="nav nav-tabs aa-products-tab">
                    @php
                      $loop_count=1;
                    @endphp
                   @foreach ($result['home_categories'] as $item)
                    @php
                      $cat_class="";
                      if($loop_count==1){
                        $cat_class="active";
                        $loop_count++;
                      }
                    @endphp
                    <li class="{{ $cat_class }}"><a href="#cat{{ $item->id }}" data-toggle="tab">{{ $item->category_name }}</a></li>
                   @endforeach
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                    @php
                      $loop_count=1;
                    @endphp
                    @foreach ($result['home_categories'] as $item)
                      @php
                        $cat_class="";
                        if($loop_count==1){
                          $cat_class="in active";
                          $loop_count++;
                        }
                      @endphp
                      <div class="tab-pane fade {{ $cat_class }}" id="cat{{ $item->id }}">
                        <ul class="aa-product-catg">
                          @if (isset($result['home_categories_product'][$item->id][0]))  
                            @foreach ($result['home_categories_product'][$item->id] as $product)
                              <li>
                                <figure>
                                  <a class="aa-product-img" href="{{ url('product/'.$product->slug) }}"><img src="{{ asset('storage/media/'.$product->image) }}" alt="{{ $product->name }}"></a>
                                  <a class="aa-add-card-btn"href="{{ url('product/'.$product->slug) }}"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                                  <figcaption>
                                    <h4 class="aa-product-title"><a href="{{ url('product/'.$product->slug) }}">{{ $product->name }}</a></h4>
                                    <span class="aa-product-price">Rs {{ $result['home_product_attr'][$product->id][0]->price }}</span>
                                    <span class="aa-product-price"><del>Rs {{ $result['home_product_attr'][$product->id][0]->mrp }}</del></span>
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
                    @endforeach
                  </div>             
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Products section -->
  <!-- banner section -->
  <section id="aa-banner">
    <div class="container">
      <div class="row">
        <div class="col-md-12">        
          <div class="row">
            <div class="aa-banner-area">
            <a href="#"><img src="{{ asset('front_assets/img/fashion-banner.jpg') }}" alt="fashion banner img"></a>
          </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- popular section -->
  <section id="aa-popular-category">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-popular-category-area">
              <!-- start prduct navigation -->
             <ul class="nav nav-tabs aa-products-tab">
                <li class="active"><a href="#featured" data-toggle="tab">Featured</a></li>
                <li><a href="#trending" data-toggle="tab">Trending</a></li>
                <li><a href="#discounted" data-toggle="tab">Discounded</a></li>                    
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <!-- Start men featured category -->
                <div class="tab-pane fade in active" id="featured">
                  <ul class="aa-product-catg aa-featured-slider">
                    <!-- start single product item -->
                    @if (isset($result['home_featured_product'][0]))  
                      @foreach ($result['home_featured_product'] as $item)
                        <li>
                          <figure>
                            <a class="aa-product-img" href="{{ url('product/'.$product->slug) }}"><img src="{{ asset('storage/media/'.$item->image) }}" alt="{{ $item->name }}"></a>
                            <a class="aa-add-card-btn"href="{{ url('product/'.$product->slug) }}"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="{{ url('product/'.$product->slug) }}">{{ $item->name }}</a></h4>
                              <span class="aa-product-price">{{ $result['home_featured_product_attr'][$item->id][0]->price }}</span>
                              <span class="aa-product-price"><del>{{ $result['home_featured_product_attr'][$item->id][0]->mrp }}</del></span>
                            </figcaption>
                          </figure>                     
                        </li>                                                                                 
                      @endforeach
                    @else
                        <li>
                          <figure>
                              No data Found
                          </figure>
                        </li>
                    @endif
                  </ul>
                </div>
                <!-- / featured product category -->
                
                <!-- start trending product category -->
                <div class="tab-pane fade" id="trending">
                 <ul class="aa-product-catg aa-trending-slider">
                    <!-- start single product item -->
                    @if (isset($result['home_trending_product'][0]))  
                      @foreach ($result['home_trending_product'] as $item)
                        <li>
                          <figure>
                            <a class="aa-product-img" href="{{ url('product/'.$product->slug) }}"><img src="{{ asset('storage/media/'.$item->image) }}" alt="{{ $item->name }}"></a>
                            <a class="aa-add-card-btn"href="{{ url('product/'.$product->slug) }}"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="{{ url('product/'.$product->slug) }}">{{ $item->name }}</a></h4>
                              <span class="aa-product-price">{{ $result['home_trending_product_attr'][$item->id][0]->price }}</span>
                              <span class="aa-product-price"><del>{{ $result['home_trending_product_attr'][$item->id][0]->mrp }}</del></span>
                            </figcaption>
                          </figure>                     
                        </li>                                                                                 
                      @endforeach
                    @else
                        <li>
                          <figure>
                              No data Found
                          </figure>
                        </li>
                    @endif                                                                              
                  </ul>
                </div>
                <!-- / trending product category -->

                <!-- start discounted product category -->
                <div class="tab-pane fade" id="discounted">
                  <ul class="aa-product-catg aa-discounted-slider">
                    <!-- start single product item -->
                    @if (isset($result['home_discounded_product'][0]))  
                    @foreach ($result['home_discounded_product'] as $item)
                      <li>
                        <figure>
                          <a class="aa-product-img" href="{{ url('product/'.$product->slug) }}"><img src="{{ asset('storage/media/'.$item->image) }}" alt="{{ $item->name }}"></a>
                          <a class="aa-add-card-btn"href="{{ url('product/'.$product->slug) }}"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                          <figcaption>
                            <h4 class="aa-product-title"><a href="{{ url('product/'.$product->slug) }}">{{ $item->name }}</a></h4>
                            <span class="aa-product-price">{{ $result['home_discounded_product_attr'][$item->id][0]->price }}</span>
                            <span class="aa-product-price"><del>{{ $result['home_discounded_product_attr'][$item->id][0]->mrp }}</del></span>
                          </figcaption>
                        </figure>                     
                      </li>                                                                                 
                    @endforeach
                  @else
                      <li>
                        <figure>
                            No data Found
                        </figure>
                      </li>
                  @endif                                                                                     
                  </ul>
                </div>
                <!-- / discounted product category -->              
              </div>
            </div>
          </div> 
        </div>
      </div>
    </div>
  </section>
  <!-- / popular section -->
  <!-- Support section -->
  <section id="aa-support">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-support-area">
            <!-- single support -->
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="aa-support-single">
                <span class="fa fa-truck"></span>
                <h4>FREE SHIPPING</h4>
                <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P>
              </div>
            </div>
            <!-- single support -->
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="aa-support-single">
                <span class="fa fa-clock-o"></span>
                <h4>30 DAYS MONEY BACK</h4>
                <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P>
              </div>
            </div>
            <!-- single support -->
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="aa-support-single">
                <span class="fa fa-phone"></span>
                <h4>SUPPORT 24/7</h4>
                <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Support section -->
  {{-- <!-- Testimonial -->
  <section id="aa-testimonial">  
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-testimonial-area">
            <ul class="aa-testimonial-slider">
              <!-- single slide -->
              <li>
                <div class="aa-testimonial-single">
                <img class="aa-testimonial-img" src="{{ asset('front_assets/img/testimonial-img-2.jpg') }}" alt="testimonial img">
                  <span class="fa fa-quote-left aa-testimonial-quote"></span>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt distinctio omnis possimus, facere, quidem qui!consectetur adipisicing elit. Sunt distinctio omnis possimus, facere, quidem qui.</p>
                  <div class="aa-testimonial-info">
                    <p>Allison</p>
                    <span>Designer</span>
                    <a href="#">Dribble.com</a>
                  </div>
                </div>
              </li>
              <!-- single slide -->
              <li>
                <div class="aa-testimonial-single">
                <img class="aa-testimonial-img" src="{{ asset('front_assets/img/testimonial-img-1.jpg') }}" alt="testimonial img">
                  <span class="fa fa-quote-left aa-testimonial-quote"></span>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt distinctio omnis possimus, facere, quidem qui!consectetur adipisicing elit. Sunt distinctio omnis possimus, facere, quidem qui.</p>
                  <div class="aa-testimonial-info">
                    <p>KEVIN MEYER</p>
                    <span>CEO</span>
                    <a href="#">Alphabet</a>
                  </div>
                </div>
              </li>
               <!-- single slide -->
              <li>
                <div class="aa-testimonial-single">
                <img class="aa-testimonial-img" src="{{ asset('front_assets/img/testimonial-img-3.jpg') }}" alt="testimonial img">
                  <span class="fa fa-quote-left aa-testimonial-quote"></span>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt distinctio omnis possimus, facere, quidem qui!consectetur adipisicing elit. Sunt distinctio omnis possimus, facere, quidem qui.</p>
                  <div class="aa-testimonial-info">
                    <p>Luner</p>
                    <span>COO</span>
                    <a href="#">Kinatic Solution</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Testimonial --> --}}

  {{-- <!-- Latest Blog -->
  <section id="aa-latest-blog">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-latest-blog-area">
            <h2>LATEST BLOG</h2>
            <div class="row">
              <!-- single latest blog -->
              <div class="col-md-4 col-sm-4">
                <div class="aa-latest-blog-single">
                  <figure class="aa-blog-img">                    
                    <a href="#"><img src="{{ asset('front_assets/img/promo-banner-1.jpg') }}" alt="img"></a>  
                      <figcaption class="aa-blog-img-caption">
                      <span href="#"><i class="fa fa-eye"></i>5K</span>
                      <a href="#"><i class="fa fa-thumbs-o-up"></i>426</a>
                      <a href="#"><i class="fa fa-comment-o"></i>20</a>
                      <span href="#"><i class="fa fa-clock-o"></i>June 26, 2016</span>
                    </figcaption>                          
                  </figure>
                  <div class="aa-blog-info">
                    <h3 class="aa-blog-title"><a href="#">Lorem ipsum dolor sit amet</a></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, ad? Autem quos natus nisi aperiam, beatae, fugiat odit vel impedit dicta enim repellendus animi. Expedita quas reprehenderit incidunt, voluptates corporis.</p> 
                    <a href="#" class="aa-read-mor-btn">Read more <span class="fa fa-long-arrow-right"></span></a>
                  </div>
                </div>
              </div>
              <!-- single latest blog -->
              <div class="col-md-4 col-sm-4">
                <div class="aa-latest-blog-single">
                  <figure class="aa-blog-img">                    
                    <a href="#"><img src="{{ asset('front_assets/img/promo-banner-3.jpg') }}" alt="img"></a>  
                      <figcaption class="aa-blog-img-caption">
                      <span href="#"><i class="fa fa-eye"></i>5K</span>
                      <a href="#"><i class="fa fa-thumbs-o-up"></i>426</a>
                      <a href="#"><i class="fa fa-comment-o"></i>20</a>
                      <span href="#"><i class="fa fa-clock-o"></i>June 26, 2016</span>
                    </figcaption>                          
                  </figure>
                  <div class="aa-blog-info">
                    <h3 class="aa-blog-title"><a href="#">Lorem ipsum dolor sit amet</a></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, ad? Autem quos natus nisi aperiam, beatae, fugiat odit vel impedit dicta enim repellendus animi. Expedita quas reprehenderit incidunt, voluptates corporis.</p> 
                     <a href="#" class="aa-read-mor-btn">Read more <span class="fa fa-long-arrow-right"></span></a>         
                  </div>
                </div>
              </div>
              <!-- single latest blog -->
              <div class="col-md-4 col-sm-4">
                <div class="aa-latest-blog-single">
                  <figure class="aa-blog-img">                    
                    <a href="#"><img src="{{ asset('front_assets/img/promo-banner-1.jpg') }}" alt="img"></a>  
                      <figcaption class="aa-blog-img-caption">
                      <span href="#"><i class="fa fa-eye"></i>5K</span>
                      <a href="#"><i class="fa fa-thumbs-o-up"></i>426</a>
                      <a href="#"><i class="fa fa-comment-o"></i>20</a>
                      <span href="#"><i class="fa fa-clock-o"></i>June 26, 2016</span>
                    </figcaption>                          
                  </figure>
                  <div class="aa-blog-info">
                    <h3 class="aa-blog-title"><a href="#">Lorem ipsum dolor sit amet</a></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, ad? Autem quos natus nisi aperiam, beatae, fugiat odit vel impedit dicta enim repellendus animi. Expedita quas reprehenderit incidunt, voluptates corporis.</p> 
                    <a href="#" class="aa-read-mor-btn">Read more <span class="fa fa-long-arrow-right"></span></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>    
      </div>
    </div>
  </section>
  <!-- / Latest Blog --> --}}

  <!-- Client Brand -->
  <section id="aa-client-brand">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-client-brand-area">
            <ul class="aa-client-brand-slider">
              @foreach ($result['home_brand'] as $item)
                <li><a href="#"><img  src="{{ asset('storage/media/brand/'.$item->image) }}" alt="{{ $item->name }}"></a></li>   
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Client Brand -->

  <!-- Subscribe section -->
  {{-- <section id="aa-subscribe">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-subscribe-area">
            <h3>Subscribe our newsletter </h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, velit!</p>
            <form action="" class="aa-subscribe-form">
              <input type="email" name="" id="" placeholder="Enter your Email">
              <input type="submit" value="Subscribe">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  <!-- / Subscribe section -->




@endsection