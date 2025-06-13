@extends('layout')
@section('content')
 <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                     <div class="section-title related__product__title">
                        <h2>{{__('Giỏ Hàng')}}</h2>
                        <br>
                        <span class="" style="margin-left: 800px;">
                           <?php
                           $message = Session::get('message');
                           if ($message) {
                             echo '<span class="badge badge-pill badge-danger" >'.$message.'</span>';
                             Session::put('message',null);
                             }
                             ?>
                        </span>
                        <br>
                         @if(session()->has('message'))
		                    <div class="alert alert-success">
		                        {!! session()->get('message') !!}
		                    </div>
		                @elseif(session()->has('error'))
		                     <div class="alert alert-danger">
		                        {!! session()->get('error') !!}
		                    </div>
		                @endif
                     </div>
                    <div class="shoping__cart__table">
                        {{-- lấy ra những gì đã thềm vào giỏ hàng --}}
                        {{-- <?php
                        $content = Cart::content();
                        
                        ?> --}}
                        {{--  --}}
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">{{__('Sản Phẩm')}}</th>
                                    <th>{{__('Giá')}}</th>
                                    <th>{{__('Số Lượng')}}</th>
                                    <th>{{__('Tổng Giá')}}</th>
                                    <th><a class="site-btn" type="submit" href="{{URL::to('/delete-all-cart')}}">{{__('Xóa Tất Cả')}}</a></th>
                                </tr>
                            </thead>
                            <form action="{{URL::to('/update-cart')}}" method="POST">
                    		{{csrf_field()}}
                            <tbody>
                            	
                            	@php
								$total = 0;
								@endphp
								@if(Session::get('cart')==true)
								@foreach(Session::get('cart') as $key => $cart)
									@php
									$subtotal = $cart['product_price']*$cart['product_qty'];
									$total+=$subtotal;
									@endphp
                               {{--  @foreach($content as $v_content) --}}
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="{{URL::to('upload/product/'.$cart['product_image'])}}" width="100px" height="100px" alt="">
                                        <h5>{{$cart['product_name']}}</h5>

                                    </td>
                                    <td class="shoping__cart__price">
                                        {{number_format($cart['product_price'],0,',','.')}}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                            <div class="buttons_added">
                                              <input class="minus is-form" type="button" value="-"/>

                                              <input name="cart_qty[{{$cart['session_id']}}]" class="input-qty" max="1000" min="1" type="number" value="{{$cart['product_qty']}}"/>


                                              <input class="plus is-form" type="button" value="+"/>
                                            <input class="site-btn" type="submit" name="update_qty" value="{{__('Cập Nhập')}}">
                                            </div>
                                        
                                    </td>
                                    <td class="shoping__cart__total">
                                        {{number_format($subtotal,0,',','.')}}
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <a class="icon_close" href="{{URL::to('/delete-cart/'.$cart['session_id'])}}"></a> 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </form>
                            @else
                            		<td colspan="5" ><center>
                            			 @php
                                        	echo "Giỏ Hàng Của Bạn Đang Trống !";
                                        @endphp
                            		</center> 
                                    </td>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="{{URL::to('/trang-chu')}}" class="primary-btn cart-btn">{{__('TIẾP TỤC MUA SẮM')}}</a>
                    </div>
                </form>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>{{__('Mã Khuyến Mãi')}}</h5>
                            @if(Session::get('cart'))
                            <form action="{{URL::to('/check-coupon')}}" method="POST">
                                {{csrf_field()}}
                                <input type="text" placeholder="Enter your coupon code" name="coupon"
                                  >
                                <button type="submit" style="text-align: center;" class="site-btn" name="check_coupon">{{__('Nhập')}}</button>
                                <a class="site-btn" style="text-align: center;" href="{{URL::to('/unset-coupon')}}">{{__('Xóa')}}</a>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>{{__('Tổng Tiền Giỏ Hàng')}}</h5>
                        <ul>
                            <li>{{__('Sản Phẩm')}}<span>{{number_format($total,0,',','.').' '.'VNĐ'}}</span></li>
                        </ul>
                        {{-- <ul>
                            <li>{{__('Phí Ship')}}<span>0</span></li>
                        </ul>
                        <ul>
                            <li>{{__('Thuế')}}<span>{{Cart::discount(0)}}</span></li>
                        </ul> --}}
                        <ul>
                            <li>{{__('Tổng Cộng')}}<span>{{number_format($total,0,',','.').' '.'VNĐ'}}</span></li>
                        </ul>                        
                        <ul>
                                @if(Session::get('coupon'))
                                    @foreach(Session::get('coupon') as $key =>$cou)
                                        @if($cou['coupon_condition']==0)
                                            <ul><li>{{__('Mã Giảm Giá')}}: <span>{{$cou['coupon_number']}} %</span></li></ul>
                                            @php
                                                $total_coupon = ($total * $cou['coupon_number'])/100;
                                                echo '<li>Tổng Giảm:<span>'.number_format($total_coupon,0,',','.').' '.'VNĐ</span></li>';

                                            @endphp
                                            
                                        @else
                                            <ul><li>{{__('Mã Giảm Giá')}}: <span>{{$cou['coupon_number']}} VNĐ</span></li></ul>
                                            @php
                                                $total_coupon = $total - $cou['coupon_number'];
                                                echo '<li>Tổng Giảm:<span>'.number_format($total_coupon,0,',','.').' '.'VNĐ</span></li>';
                                            @endphp

                                        @endif
                                    @endforeach
                                @endif
                        </ul>
                        {{-- kiểm tra id khách hàng nếu chưa bắt đăng nhập --}}
                        <?php
                                    $customer_id = Session::get('customer_id');
                                    if ($customer_id != NULL) {

                                        ?>
                                        <a href="{{URL::to('/checkout')}}" class="primary-btn">{{__('XÁC NHẬN')}}</a>
                                        <?php
                                    }else{
                                        ?>

                                        <a href="{{URL::to('/login-checkout')}}" class="primary-btn">{{__('XÁC NHẬN')}}</a>
                                        <?php 
                                    }      
                                        ?>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@endsection