@extends('layout')
@section('content')
<!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>{{__('Chi tiết thanh toán')}}</h2>
                     </div>
                    <h6><span class="icon_tag_alt"></span>{{__('Có phiếu giảm giá ?')}} <a href="{{URL::to('/gio-hang')}}">{{__('Click here ?')}}</a> {{__('to enter your code')}}
                    </h6>
                </div>
            </div>
            <div class="checkout__form">
                <form >
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>{{__('Họ & Tên')}}<span>*</span></p>
                                        <input type="text" placeholder="{{__('Vui lòng nhập họ và tên')}}" id="shipping_name" name="shipping_name" class="shipping_name" value="{{ Session::get('shipping_name', '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>{{__('Tỉnh/Thành phố')}}<span>*</span></p>
                                <input type="text" placeholder="{{__('Vui lòng nhập tỉnh/Thành phố')}}" name="shipping_city" class="shipping_city" value="{{ Session::get('shipping_city', '') }}">
                            </div>
                            <div class="checkout__input">
                                <p>{{__('Địa Chỉ')}}<span>*</span></p>
                                <input type="text" placeholder="{{__('Tên đường, Số nhà, Xã/Phường, Quận/Huyện')}}" class="shipping_address" name="shipping_address"  id="shipping_address" value="{{ Session::get('shipping_address', '') }}">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>{{__('Số Điện Thoại')}}<span>*</span></p>
                                        <input type="text" placeholder="{{__('Vui lòng nhập số điện thoại')}}" id="shipping_phone" name="shipping_phone" class="shipping_phone" value="{{ Session::get('shipping_phone', '') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text" placeholder="{{__('Vui lòng nhập địa chỉ email')}}" id="shipping_email" name="shipping_email" class="shipping_email" value="{{ Session::get('shipping_email', '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>{{__('Ghi Chú')}}<span></span></p>
                                <input type="text"placeholder="{{__('Vui lòng nhập ghi chú của bạn')}}" name="shipping_note" class="shipping_note" value="{{ Session::get('shipping_note', '') }}">
                            </div>
                            <div class="checkout__input__checkbox">
                                <p>{{__('Phương Thức Thanh Toán')}}<span>*</span></p>
                                <label for="payment">
                                                {{ __('Thanh toán VNPAY')}}
                                                <input id="payment" type="radio" name ="payment" class="payment" value="0" {{ Session::get('payment') == '0' ? 'checked' : '' }}>
                                                
                                                <img src="{{asset('frontend/image/payment2.png')}}" width="40px" height="30px">
                                                <span class="checkmark"></span>
                                </label>
                                <label for="paypal">
                                                {{ __('Thanh toán khi nhận hàng') }}
                                                <input id="paypal" type="radio" name ="payment" class="payment" value="1" {{ Session::get('payment') == '1' || !Session::get('payment') ? 'checked' : '' }}>

                                                <img src="{{asset('frontend/image/payment1.png')}}" width="30px" height="30px">
                                                <span class="checkmark"></span>
                                </label>
                            </div>
                            <input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
                            @if(Session::get('coupon'))
                                @foreach(Session::get('coupon') as $key => $cou)
                                    <input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
                                @endforeach
                            @else
                                <input type="hidden" name="order_coupon" class="order_coupon" value="no">
                            @endif
                            <div class="shoping__cart__btns">
                                <a href="{{URL::to('/trang-chu')}}" class="primary-btn cart-btn">{{__('TIẾP TỤC MUA SẮM')}}</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="checkout__order">
                                <center>
                                    <h4>{{__('Phí Vận Chuyển')}}</h4>
                                <form >
                                    @csrf
                                    <div class="">
                                        <label class="">{{__('Chọn Tỉnh/Thành Phố')}}</label>
                                            <div>
                                              <select class="form-control input-sm m-bot15 choose city" name="city" id="city">
                                                <option value="">-----{{__('Chọn Tỉnh/Thành Phố')}}-----</option>
                                                @foreach($city as $key => $ci)
                                                <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                                @endforeach
                                              </select>
                                          </div>
                                      </div>
                                      <div class="">
                                        <label class="">{{__('Chọn Quận/Huyện')}}</label>
                                            <div>
                                              <select  name="province" id="province" class="form-control input-sm m-bot15 choose province"  >
                                                <option value="">-----{{__('Chọn Quận/Huyện')}}-----</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="">
                                        <label class="">{{__('Chọn Xã/Phường')}}</label>
                                            <div>
                                              <select name="wards" id="wards" class=" form-control input-sm m-bot15 wards" >
                                                <option value="">-----{{__('Chọn Xã/Phường')}}-----</option>
                                              </select>
                                          </div>
                                      </div>
                                      @if(Session::get('customer_id'))
                                        @if(Session::get('cart'))
                                            <button name="calculate" id="calculate" type="button" class="site-btn calculate">{{__('Tính Phí')}}</button>
                                        @else
                                            <button name="null-cart" type="button" class="site-btn null-cart">{{__('Tính Phí')}}</button>
                                        @endif   
                                      @else
                                            <button name="null-customer" type="button" class="site-btn null-customer">{{__('Tính Phí')}}</button>
                                      @endif
                                </form>
                                </center>
                                
                            </div>
                            <div class="checkout__order">
                                <h4>{{__('Đơn Hàng Của Bạn')}}</h4>
                                <div class="checkout__order__products">{{__('Sản Phẩm')}}<span>Total</span></div>
                                @php
                                $subtotal = 0;
                                $total = 0;
                                @endphp
                                @if(Session::get('cart')==true)
                                    @foreach(Session::get('cart') as $key => $cart)
                                        @php
                                            $subtotal = $cart['product_price']*$cart['product_qty'];
                                            $total+=$subtotal;
                                        @endphp
                                        <ul>
                                            <div class="checkout__order__subtotal">{{$cart['product_name']}}<span>{{number_format($subtotal,0,',','.').' '.'VNĐ'}}</span></div>
                                        </ul>
                                    @endforeach
                                @endif
                                <div class="checkout__order__subtotal">{{__('Tổng Cộng')}}<span>{{number_format($total,0,',','.').' '.'VNĐ'}}</span></div>
                                @if(Session::get('coupon'))
                                    @foreach(Session::get('coupon') as $key =>$cou)
                                       @if($cou['coupon_condition']==0)
                                            <div class="checkout__order__products"><a class="cart_quantity_delete" href="{{url('/unset-coupon')}}"><i class="fa fa-times"></i></a>{{__('Mã Giảm Giá')}}: <span>{{$cou['coupon_number']}} %</span></div>
                                            @php
                                                $total_after_coupon = ($total * $cou['coupon_number'])/100;
                                            @endphp
                                        @else
                                            <div class="checkout__order__products"><a class="cart_quantity_delete" href="{{url('/unset-coupon')}}"><i class="fa fa-times"></i></a>{{__('Mã Giảm Giá')}}: <span>{{$cou['coupon_number']}} VNĐ</span></div>
                                            @php
                                                $total_after_coupon = $total - $cou['coupon_number'];
                                            @endphp

                                        @endif
                                    @endforeach
                                @endif
                                <div class="checkout__order__products"><a class="cart_quantity_delete" href="{{url('/del-fee')}}"><i class="fa fa-times"></i></a>{{__('Phí Ship')}}: <span id="shipping-fee">{{ number_format(Session::get('fee', 0), 0, ',', '.') }} VNĐ</span>
                                </div>
                                <?php $total_after_fee = $total + (Session::get('fee', 0)); ?>
                                        <div class="checkout__order__products">{{__('Tổng Tiền Còn')}} :
                                            <span>
                                            @php 
                                            if(Session::get('fee') && !Session::get('coupon')){
                                                $total_after = $total_after_fee;
                                                echo number_format($total_after,0,',','.').' '.'VNĐ';
                                            }elseif(!Session::get('fee') && Session::get('coupon')){
                                                $total_after = $total_after_coupon;
                                                echo number_format($total_after,0,',','.').' '.'VNĐ';
                                            }elseif(Session::get('fee') && Session::get('coupon')){
                                                $total_after = $total_after_coupon;
                                                $total_after = $total_after + Session::get('fee');
                                                echo number_format($total_after,0,',','.').' '.'VNĐ';
                                            }elseif(!Session::get('fee') && !Session::get('coupon')){
                                                $total_after = $total;
                                                echo number_format($total_after,0,',','.').' '.'VNĐ';
                                            }

                                            @endphp
                                          </span>
                                         </div>    
                                @if(Session::get('customer_id'))
                                    @if(Session::has('fee'))
                                        <button type="button" class="send-order site-btn" name="send-order">{{__('Thanh Toán')}}</button>
                                    @else 
                                        <button type="button" class="site-btn null-fee" name="null-fee">{{__('Thanh Toán')}}</button>
                                    @endif
                                @else 
                                    <button type="button" class="site-btn null-customer" name="null-customer">{{__('Thanh Toán')}}</button>
                                @endif  
                            </div>
                                
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>
    </section>
    <!-- Checkout Section End -->
@endsection

<script>
function printLocationCodes() {
    const city = document.getElementById('city').value;
    const province = document.getElementById('province').value;
    const ward = document.getElementById('wards').value;
    console.log('City/Province code:', city);
    console.log('District (Province) code:', province);
    console.log('Ward code:', ward);
}

document.getElementById('city').addEventListener('change', printLocationCodes);
document.getElementById('province').addEventListener('change', printLocationCodes);
document.getElementById('wards').addEventListener('change', printLocationCodes);
</script>