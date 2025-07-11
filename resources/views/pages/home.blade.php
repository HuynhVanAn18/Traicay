@extends('layout')
@section('content')
<!-- Hero Section Begin -->
<style type="text/css">
    .abc:hover {
     /*background: blue;*/
     color: black;
}
</style>
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>{{__('Sản Phẩm')}}</span>
                        </div>
                        @foreach($category as $key =>$cate)
                            <ul>
                                <?php
                                $language = Session::get('language');
                                if ($language == 'en') {
                                    ?>
                                    <li><a href="{{URL::to('danh-muc-san-pham/'.$cate->category_slug)}}">{{$cate->category_name_en}}</a></li>
                                  <?php
                                }else{
                                    ?>
                                    <li><a href="{{URL::to('danh-muc-san-pham/'.$cate->category_slug)}}">{{$cate->category_name}}</a></li>
                                    <?php
                                }
                                    ?>
                            </ul>
                        @endforeach
                    </div>
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>{{__('Sản Phẩm Yêu Thích')}}</span>
                        </div>
                        <div  id="row_wishlist"></div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="{{URL::to('/tim-kiem')}}" autocomplete="off" method="POST">
                                {{csrf_field()}}
                                <input type="text" id="keywords" placeholder="{{__('Tìm Kiếm ?')}}" name="keywords_submit">
                                <button name="seach_items" type="submit" class="site-btn">{{__('Tìm')}}</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>0379145253</h5>
                                <span>{{__('hỗ trợ')}} 24/7</span>
                            </div>
                        </div>
                    </div>
                    @foreach($slider_home as $key =>$slider)
                    <div class="hero__item set-bg" data-setbg="{{URL::to('upload/slider/'.$slider->slider_image)}}">
                        <div class="hero__text">
                            <span></span>
                            <h2></h2>
                            <p></p>
                            </br></br></br></br></br></br></br></br>
                            <a href="{{URL::to('/trang-chu')}}" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section>
        <!--Shipping area start-->
                <div class="shipping_area shipping_three ">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="shipping_list d-flex justify-content-between" style="">
                                    <div class="single_shipping_box d-flex">
                                        <div class="shipping_icon">
                                            <img src="{{URL::to('frontend/image/ship/1.png')}}" alt="shipping icon">
                                        </div>
                                        <div class="shipping_content">
                                            <h6>{{__('Hỗ Trợ Vận Chuyển Nhiều Tỉnh Thành')}}</h6>
                                            <p>{{__('Vận Chuyển Siêu Nhanh')}}</p>
                                        </div>
                                    </div>
                                    <div class="single_shipping_box one d-flex ">
                                        <div class="shipping_icon">
                                            <img src="{{URL::to('frontend/image/ship/2.png')}}" alt="shipping icon">
                                        </div>
                                        <div class="shipping_content">
                                            <h6>{{__('Giá Siêu Rẻ')}}</h6>
                                            <p>{{__('Tiết Kiệm')}}</p>
                                        </div>
                                    </div>
                                    <div class="single_shipping_box d-flex">
                                        <div class="shipping_icon">
                                            <img src="{{URL::to('frontend/image/ship/4.png')}}" alt="shipping icon">
                                        </div>
                                        <div class="shipping_content">
                                            <h6>{{__('Tư Vấn Nhiệt Tình')}}</h6>
                                            <p>{{__('Hỗ Trợ Khách Hàng 24/7')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Shipping area end-->
    </section>
    <!-- Hero Section End -->
    </br></br></br></br></br>
    <!-- Categories Section Begin -->
      <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <form>
                        @foreach($product_sold as $key =>$sold)
                        <div class="col-lg-3">
                        <span class="new-product">{{__('Bán Chạy')}}</span>
                        <div class="categories__item set-bg" data-setbg="{{URL::to('upload/product/'.$sold->product_image)}}">
                            <?php
                                $language = Session::get('language');
                                if ($language == 'en') {
                                    ?>
                                    <h5><a href="{{URL::to('chi-tiet-san-pham/'.$sold->product_slug)}}">{{$sold->product_name_en}}</a></h5>
                                  <?php
                                }else{
                                    ?>
                                    <h5><a href="{{URL::to('chi-tiet-san-pham/'.$sold->product_slug)}}">{{$sold->product_name}}</a></h5>
                                    <?php
                                }
                                    ?>
                        </div>
                        </div>
                    </form>
                        @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>{{ __('Sản Phẩm Nổi Bậc') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                @foreach($all_product as $key => $product)
                <div class="col-lg-4 col-md-4 col-sm-6 mix">
                    <div class="featured__item">
                      <form>
                        @csrf
                        <span class="new-product">{{__('Mới')}}</span>
                        <div class="featured__item__pic set-bg" data-setbg="{{URL::to('upload/product/'.$product->product_image)}}">
                           <img id="wishlist_productimage{{$product->product_id}}" src ="{{URL::to('upload/product/'.$product->product_image)}}">
                            <ul class="featured__item__pic__hover">
                                <li><a class="button_wishlist"  id="{{$product->product_id}}" onclick="add_wistlist(this.id);"><i class="fa fa-heart"></i></a></li>
                                <li><a href="{{URL::to('chi-tiet-san-pham/'.$product->product_slug)}}"><i class="fa fa-bookmark"></i></a></li>
                                <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                 <?php
                                $language = Session::get('language');
                                if ($language == 'en') {
                                    ?>
                                        <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name_en}}" class="cart_product_name_{{$product->product_id}}">
                                    <?php
                                }else{
                                    ?>
                                     <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                    <?php
                                }
                                    ?>
                                <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                {{-- en --}}
                                 <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name_en}}" class="cart_product_name_{{$product->product_id}}">
                                {{-- end --}}
                                <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                 <input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{number_format($product->product_price,0,',','.')}} VNĐ">
                                <input type="hidden" value="{{$product->product_qty}}" class="cart_product_quantity_{{$product->product_id}}">

                                <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                                        <li><a type="button" class="add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart"><i  class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                      </form>
                        <div class="featured__item__text">
                            <?php
                                $language = Session::get('language');
                                if ($language == 'en') {
                                    ?>
                                    <h6><a id="wishlist_producturl{{$product->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$product->product_slug)}}">{{($product->product_name_en)}}</a></h6>
                                    <?php
                                }else{
                                    ?>
                                    <h6><a id="wishlist_producturl{{$product->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$product->product_slug)}}">{{($product->product_name)}}</a></h6>
                                    <?php
                                }
                                    ?>
                            
                            <h5>{{number_format($product->product_price).' '.'VNĐ'}}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-lg-12">
                    {!!$all_product->links()!!}
                </div>
            </div>

        </div>
    </section>
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>{{__('Sản Phẩm Theo Thương Hiệu')}}</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            @foreach($brand as $key =>$brand)
                            <?php
                                $language = Session::get('language');
                                if ($language == 'en') {
                                    ?>
                                    <li><a href="{{URL::to('thuong-hieu-san-pham/'.$brand->brand_slug)}}">{{$brand->brand_name_en}}</a></li>
                                  <?php
                                }else{
                                    ?>
                                    <li><a href="{{URL::to('thuong-hieu-san-pham/'.$brand->brand_slug)}}">{{$brand->brand_name}}</a></li>
                                    <?php
                                }
                                    ?>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Featured Section End -->
    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                @foreach($ads_home as $key =>$ads)
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <a href="{{$ads->ads_link}}"><image width="500" height="250" href="#" src="{{URL::to('upload/qc/'.$ads->ads_image)}}" alt="{{$ads->ads_desc}}"></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <br>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>{{__('Sản Phẩm Mới Nhất')}}</h4>
                        <div class="latest-product__slider owl-carousel">
                            @foreach($all_product as $key => $product)
                            <div class="latest-prdouct__slider__item">
                                <a href="{{URL::to('chi-tiet-san-pham/'.$product->product_slug)}}" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <image src="{{URL::to('upload/product/'.$product->product_image)}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <?php
                                        $language = Session::get('language');
                                        if ($language == 'en') {
                                            ?>
                                            <h6>{{$product->product_name_en}}</h6>
                                            <?php
                                        }else{
                                            ?>
                                            <h6>{{$product->product_name}}</h6>
                                            <?php
                                        }
                                        ?>
                                        <span>{{number_format($product->product_price).' '.'VNĐ'}}</span>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>{{__('Sản Phẩm Bán Chạy')}}</h4>
                        <div class="latest-product__slider owl-carousel">
                            @foreach($product_sold as $key => $sold)
                            <div class="latest-prdouct__slider__item">
                               <a href="{{URL::to('chi-tiet-san-pham/'.$sold->product_slug)}}" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <image src="{{URL::to('upload/product/'.$sold->product_image)}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <?php
                                        $language = Session::get('language');
                                        if ($language == 'en') {
                                            ?>
                                            <h6>{{$product->product_name_en}}</h6>
                                            <?php
                                        }else{
                                            ?>
                                            <h6>{{$product->product_name}}</h6>
                                            <?php
                                        }
                                        ?>
                                        <span>{{number_format($sold->product_price).' '.'VNĐ'}}</span>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>{{__('Sản Phẩm Top')}}</h4>
                        <div class="latest-product__slider owl-carousel">
                            @foreach($product_price as $key => $price)
                            <div class="latest-prdouct__slider__item">
                                <a href="{{URL::to('chi-tiet-san-pham/'.$price->product_slug)}}" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <image src="{{URL::to('upload/product/'.$price->product_image)}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <?php
                                        $language = Session::get('language');
                                        if ($language == 'en') {
                                            ?>
                                            <h6>{{$product->product_name_en}}</h6>
                                            <?php
                                        }else{
                                            ?>
                                            <h6>{{$product->product_name}}</h6>
                                            <?php
                                        }
                                        ?>
                                        <span>{{number_format($price->product_price).' '.'VNĐ'}}</span>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  
@endsection