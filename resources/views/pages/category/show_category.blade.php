@extends('layout')
@section('content')
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        @foreach($category_name as $key =>$category_by_name)
                        <?php
                        $language = Session::get('language');
                        if ($language == 'en') {
                            ?>
                             <h2>{{($category_by_name->category_name_en)}}</h2>
                            <?php
                        }else{
                            ?>
                             <h2>{{($category_by_name->category_name)}}</h2>
                            <?php
                        }
                        ?>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                @foreach($category_by_id as $key => $product)
                <div class="col-lg-4 col-md-4 col-sm-6 mix">
                    <div class="featured__item">
                      <form>
                        @csrf();
                        <div class="featured__item__pic set-bg" data-setbg="{{URL::to('upload/product/'.$product->product_image)}}">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="{{URL::to('chi-tiet-san-pham/'.$product->product_slug)}}"><i class="fa fa-bookmark"></i></a></li>
                                <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                <?php
                                $language = Session::get('language');
                                if ($language == 'en') {
                                    ?>
                                    <input type="hidden" value="{{$product->product_name_en}}" class="cart_product_name_{{$product->product_id}}">
                                    <?php
                                }else{
                                    ?>
                                    <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                    <?php
                                }
                                ?>
                                <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
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
            </div>

        </div>
    </section>
    <!-- Featured Section End -->
@endsection