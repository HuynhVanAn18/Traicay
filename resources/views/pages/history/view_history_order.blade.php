@extends('layout')
@section('content')
<!-- Hero Section Begin -->
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
                        <div id="row_wishlist"></div>
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
                                <h5>0564811836</h5>
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
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                  <div class="section-title">
                        <h2>{{ __('Lịch Sử Mua Hàng') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <div class="col-lg-12">
                   <h4 class="card-title ">{{__('Thông tin vận chuyển')}}</h4>
                    <table class="table">
                        <thead class="text-primary">
                          <th>
                            {{__('Tên Người Nhận')}}
                          </th>
                          <th>
                            {{__('Địa chỉ')}}
                          </th>
                          <th>
                            {{__('Số điện thoại')}}
                          </th>
                          <th>
                            {{__('Email')}}
                          </th>
                          <th>
                            {{__('Hình thức thanh toán')}}
                          </th>
                          <th>
                            {{__('Ghi chú')}}
                          </th>
                        </thead>
                        <tbody>
                          <tr class="table-warning">
                            <td>
                              {{$shipping->shipping_name}}
                            </td>
                            <td>
                              {{$shipping->shipping_address}}
                            </td>
                            <td>
                              {{$shipping->shipping_phone}}
                            </td>
                            <td>
                              {{$shipping->shipping_email}}
                            </td>
                            <td>@if($shipping->shipping_method==0) {{__('thanh toán online')}} @else {{__('thanh toán tiền mặt')}} @endif
                            </td>
                            <td>
                              {{$shipping->shipping_note}}
                            </td>
                          </tr>
                      </tbody>
                    </table>
                </div>
                <div class="col-lg-12">
                   <h4 class="card-title ">{{__('Thông Đơn Hàng')}}</h4>
                    <table class="table">
                      <thead class=" text-primary">
                          <th>
                            {{__('STT')}}
                          </th>
                          <th>
                           {{__('Tên Sản Phẩm')}}
                         </th>
                        <th>
                          {{__('Số Lượng Đặt')}}
                        </th>
                        <th>
                          {{__('Giá')}}
                        </th>
                        <th>
                          {{__('Phí vận Chuyển')}}
                        </th>
                        <th>
                          {{__('Mã Giảm Giá')}}
                        </th>
                        <th>
                          {{__('Tổng Tiền')}}
                        </th>
                      </thead>
                      <tbody>
                       @php
                       $i=0;
                       $total=0;
                       @endphp
                       @foreach($order_details as $key => $details)
                       @php
                       $i++;
                       $subtotal = $details->product_price*$details->product_sales_quantity;
                       $total+=$subtotal ;
                       @endphp
                       <tr class="table-warning">
                        <td>
                          {{$i}}
                        </td>
                        <td>
                          {{$details->product_name}}
                        </td>
                        <td>
                         {{$details->product_sales_quantity}}
                        </td>
                        <td>
                          {{number_format($details->product_price,0,',','.').' '.'VNĐ'}}
                        </td>
                        <td> {{number_format($details->product_feeship,0,',','.').' '.'VNĐ'}}</td>
                        <td>
                          @if($details->product_coupon!='no')
                          {{$details->product_coupon}}
                          @else
                          không{{__('hỗ trợ')}}
                          @endif
                        </td>
                        <td>
                          {{number_format($details->product_price*$details->product_sales_quantity,0,',','.').' '.'VNĐ'}}
                        </td>
                      </tr>
                    @endforeach
                      <tr>
                        <tr>
                             @if($coupon_condition == 0)
                             @php
                             $total_after_coupon = ($total*$coupon_number)/100;
                             echo '<div class = "badge badge-pill badge-success">Tổng Giảm : '.number_format($total_after_coupon,0,',','.').' '.'VNĐ</div>' ;
                             $total_coupon =  $total - $total_after_coupon;
                             @endphp
                             @else
                             @php
                             echo '<div class = "badge badge-pill badge-success">Tổng Giảm : '.number_format($coupon_number,0,',','.').' '.'VNĐ</div>' ;
                             $total_coupon =  $total - $coupon_number;
                             @endphp
                             @endif
                       </tr>
                       <div class="badge badge-pill badge-info">{{__('Phí Vận Chuyển')}}: {{number_format($details->product_feeship,0,',','.').' '.'VNĐ'}}</div>
                       <div class="badge badge-pill badge-danger">{{__('Tổng Tiền Thanh Toán')}}: {{number_format($total_coupon+$details->product_feeship,0,',','.').' '.'VNĐ'}}</div>
                     </div>
                      </tr> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
    </section>
    <!-- Featured Section End -->
@endsection