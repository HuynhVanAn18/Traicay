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
                    <table class="table">
                        <thead class="text-primary">
                          <th>
                            STT
                          </th>
                          <th>
                            {{ __('Mã Đơn Hàng') }}
                          </th>
                          <th>
                            {{ __('Ngày Đặt Hàng') }}
                          </th>
                          <th>
                            {{ __('Tình Trạng Đơn Hàng') }}
                          </th>
                          <th>
                          </th>
                        </thead>
                        <tbody>
                         @php
                            $i = 0;
                         @endphp
                         @foreach($getorder as $key =>$order)
                         @php
                            $i++;
                         @endphp
                          <tr class="table-warning">
                            <td>{{$i}}</td>
                            <td>{{$order->order_code}}</td>
                            <td>{{date('d-m-Y H:i:s', strtotime($order->created_at))}}</td>
                            <td><?php
                                  if ($order->order_status==1) {

                                    ?>
                                    {{ __('Đơn của bạn đang chờ xử lí') }}
                                    <?php
                                  }else{
                                    ?>
                                    {{ __('Đã đơn hàng của bạn đã được xử lí') }}
                                    <?php 
                                  }      
                                  ?>
                            </td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" class="btn btn-info btn-round">
                                <a class="material-icons" href="{{URL::to('/view-history-order/'.$order->order_code)}}" data-original-title="Update">{{ __('Xem chi tiết đơn hàng') }}</a>
                              </button>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-12">
              <span>{!!$getorder->links()!!}</span>
            </div>
        </div>
        
    </section>
    <!-- Featured Section End -->
@endsection