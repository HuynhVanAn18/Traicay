@extends('layout')
@section('content')
     <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg owl-carousel owl-loaded owl-drag" style="margin-left: 100px;width: 1150px;height: 150px;" data-setbg="{{URL::to('frontend/image/breadcrumb.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <div class="breadcrumb__option">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
<!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                @foreach($chitiet_product as $key => $value)
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="{{URL::to('upload/product/'.$value->product_image)}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                         <?php
                                $language = Session::get('language');
                                if ($language == 'en') {
                                    ?>
                                    <h3>{{($value->product_name_en)}}</h3>
                                    <?php
                                }else{
                                    ?>
                                    <h3>{{($value->product_name)}}</h3>
                                    <?php
                                }
                                    ?>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div>


                        <form  method="POST">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">
                            <?php
                            $language = Session::get('language');
                            if ($language == 'en') {
                                ?>
                                 <input type="hidden" value="{{$value->product_name_en}}" class="cart_product_name_{{$value->product_id}}">
                                <?php
                            }else{
                                ?>
                                 <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">
                                <?php
                            }
                            ?>
                           
                            <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">
                            <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">
                            <input type="hidden" value="{{$value->product_qty}}" class="cart_product_quantity_{{$value->product_id}}">

                            <div class="product__details__price">{{number_format($value->product_price).' '.'VNĐ'}}</div>
                            {{-- <p>{{($value->product_desc)}}</p> --}}
                            <div class="buttons_added">
                              <input class="minus is-form" type="button" value="-"/>
                              <input name="qty" class="input-qty cart_product_qty_{{$value->product_id}}" max="1000" min="1" type="number" value="1"/>
                              <input type="hidden" name="productid_hidden" value="{{$value->product_id}}"/>
                              <input class="plus is-form" type="button" value="+"/>
                            </div>
                            <input type="button" class="primary-btn add-to-cart" data-id_product="{{$value->product_id}}" value="{{__('THÊM VÀO GIỎ')}}"  name="add-to-cart">
                        </form>

                        




                        <ul>
                            <li><b>{{__('Tình Trạng')}}:</b> <span><?php
                                if ($value->product_qty >0) {
                                    ?>
                                    <span>{{__('Còn Hàng')}}</span>
                                    <?php
                                }else{
                                    ?>
                                    <span>{{__('Hết Hàng')}}</span>
                                    <?php
                                }
                                    ?></span></li>
                            <li><b>{{__('Mã Sản Phẩm')}}:</b> <span>{{($value->product_id)}}</span></li>
                            <li><b>{{__('Danh Mục')}}:</b> 
                                <?php
                                $language = Session::get('language');
                                if ($language == 'en') {
                                    ?>
                                    <span>{{($value->category_name_en)}}</span>
                                    <?php
                                }else{
                                    ?>
                                    <span>{{($value->category_name)}}</span>
                                    <?php
                                }
                                    ?>
                            </li>
                            <li><b>{{__('Thương Hiệu')}}:</b>
                                <?php
                                $language = Session::get('language');
                                if ($language == 'en') {
                                    ?>
                                    <span>{{($value->brand_name_en)}}</span>
                                    <?php
                                }else{
                                    ?>
                                    <span>{{($value->brand_name)}}</span>
                                    <?php
                                }
                                    ?> 
                                </li>
                            <li><b>{{__('Chia Sẻ')}}:</b>
                                <div class="share">
                                    <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">{{__('Mô Tả')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">{{__('Đánh Giá')}} <span>(1)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>{{__('Thông Tin Sản Phẩm')}}</h6>
                                <?php
                                $language = Session::get('language');
                                if ($language == 'en') {
                                    ?>
                                    <p>{!!$value->product_content_en!!}</p>
                                    <?php
                                }else{
                                    ?>
                                    <p>{!!$value->product_content!!}</p>
                                    <?php
                                }
                                    ?>



                                    
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>{{__('Các Đánh Giá')}}</h6>
                                    <div class="fb-comments" data-href="{{$url_canonical}}" data-width="800" data-numposts="5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Sản Phẩm Liên Quan</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($related_product as $key => $lienquan)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <form>
                            @csrf();
                            <div class="product__item__pic set-bg" data-setbg="{{URL::to('upload/product/'.$lienquan->product_image)}}">
                            <ul class="product__item__pic__hover">
                                <input type="hidden" value="{{$lienquan->product_id}}" class="cart_product_id_{{$lienquan->product_id}}">
                                <?php
                                $language = Session::get('language');
                                if ($language == 'en') {
                                    ?>
                                    <input type="hidden" value="{{$lienquan->product_name_en}}" class="cart_product_name_{{$lienquan->product_id}}">
                                    <?php
                                }else{
                                    ?>
                                    <input type="hidden" value="{{$lienquan->product_name}}" class="cart_product_name_{{$lienquan->product_id}}">
                                    <?php
                                }
                                    ?>
                                <input type="hidden" value="{{$lienquan->product_image}}" class="cart_product_image_{{$lienquan->product_id}}">
                                <input type="hidden" value="{{$lienquan->product_price}}" class="cart_product_price_{{$lienquan->product_id}}">
                                <input type="hidden" value="{{$lienquan->product_qty}}" class="cart_product_quantity_{{$lienquan->product_id}}">
                                <input type="hidden" value="1" class="cart_product_qty_{{$lienquan->product_id}}">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="{{URL::to('chi-tiet-san-pham/'.$lienquan->product_slug)}}"><i class="fa fa-bookmark"></i></a>
                                <li><a type="button" class="add-to-cart" data-id_product="{{$lienquan->product_id}}" name="add-to-cart"><i  class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                            </div>
                        </form>
                        <div class="featured__item__text">
                            <?php
                                $language = Session::get('language');
                                if ($language == 'en') {
                                    ?>
                                    <h6><a href="{{URL::to('chi-tiet-san-pham/'.$lienquan->product_slug)}}">{{($lienquan->product_name_en)}}</a></h6>
                                    <?php
                                }else{
                                    ?>
                                    <h6><a href="{{URL::to('chi-tiet-san-pham/'.$lienquan->product_slug)}}">{{($lienquan->product_name)}}</a></h6>
                                    <?php
                                }
                                    ?>
                            
                            <h5>{{number_format($lienquan->product_price).' '.'VNĐ'}}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
