@extends('admin_layout')
@section('admin_content')
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
          <div class="widget-box">
                  <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <span class="label">
                         <?php
                                $message = Session::get('message');
                                if ($message) {
                                   echo '<span class="" >'.$message.'</span>';
                                   Session::put('message',null);
                                }
                         ?>
                    </span>
                  </div>
                   <div class="content">
                    <div class="container-fluid">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-12">
                          
                            <div class="card">
                              <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon">
                                  <i class="material-icons">assignment</i>
                                </div>
                                <h4 class="card-title ">{{__('Thông tin tài khoản người đặt')}}</h4>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table">
                                    <thead class=" text-primary">
                                      <th>
                                        {{__('Tên khách hàng')}}
                                      </th>
                                      <th>
                                        {{__('Số điện thoại')}}
                                      </th>
                                      <th>
                                        {{__('Email')}}
                                      </th>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                          {{$customer->customer_name}}
                                        </td>
                                        <td>
                                          {{$customer->customer_phone}}
                                        </td>
                                        <td>
                                          {{$customer->customer_email}}
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                                   <div class="content">
                    <div class="container-fluid">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="card">
                              <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon">
                                  <i class="material-icons">assignment</i>
                                </div>
                                <h4 class="card-title ">{{__('Thông tin vận chuyển')}}</h4>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table">
                                    <thead class=" text-primary">
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
                                      <tr>
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
                                        <td>@if($shipping->shipping_method==0) thanh toán online{{__('')}} @else thanh toán tiền mặt{{__('')}} @endif
                                        </td>
                                        <td>
                                          {{$shipping->shipping_note}}
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="content">
                    <div class="container-fluid">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="card">
                              <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon">
                                  <i class="material-icons">assignment</i>
                                </div>
                                <h4 class="card-title ">{{__('Chi tiết đơn hàng')}}</h4>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table">
                                    <thead class=" text-primary">
                                      <th>
                                        STT
                                      </th>
                                      <th>
                                        {{__('Tên Sản Phẩm')}}
                                      </th>
                                       <th>
                                        {{__('Số Lượng Kho Còn')}}
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
                                      <tr class="color_qty_{{$details->product_id}}">
                                        <td>
                                          {{$i}}
                                        </td>
                                        <td>
                                          {{$details->product_name}}
                                        </td>
                                        <td>
                                          {{$details->product->product_qty}}
                                        </td>
                                        <td>
                                          <input type="number" min="1" {{$order_status==2?'disabled':''}} class="order_qty_{{$details->product_id}}" name="product_qty" value="{{$details->product_sales_quantity}}">
                                          <input type="hidden" name="order_product_id" class="order_product_id" value="{{$details->product_id}}">
                                          <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$details->product_id}}" value="{{$details->product->product_qty}}">
                                          <input type="hidden" name="order_code" class="order_code" value="{{$details->order_code}}">
                                          @if($order_status != 2)
                                          <button class="btn btn-default update_qty_order" data-product_id="{{$details->product_id}}" name="update_qty_order">{{__('Cập Nhập')}}</button>
                                          @endif
                                        </td>
                                        <td>
                                          {{number_format($details->product_price,0,',','.').' '.'VNĐ'}}
                                        </td>
                                        <td> {{number_format($details->product_feeship,0,',','.').' '.'VNĐ'}}</td>
                                        <td>
                                          @if($details->product_coupon!='no')
                                              {{$details->product_coupon}}
                                          @else
                                             {{__('không')}}
                                          @endif
                                        </td>
                                        <td>
                                          {{number_format($details->product_price*$details->product_sales_quantity,0,',','.').' '.'VNĐ'}}
                                        </td>
                                      </tr>
                                     @endforeach 
                                    </tbody>
                                  </table>
                                    <tr>
                                      <td colspan="6" style="margin-left: 600px;">
                                        @foreach($order as $key =>$or)
                                        @if($or->order_status==1)
                                        <form>
                                          @csrf
                                          <select class="form-control order_details">
                                            <option id="{{$or->order_id}}" selected value="1">{{__('Chưa xử lý')}}</option>
                                            <option id="{{$or->order_id}}" value="2">{{__('Đã xử lí-Đã Giao Hàng')}}</option>
                                          </select>
                                        </form>
                                        @else
                                        <form>
                                          @csrf
                                          <select class="form-control order_details">
                                            <option disabled id="{{$or->order_id}}"  value="1">{{__('Chưa xử lý')}}</option>
                                            <option id="{{$or->order_id}}" selected value="2">{{__('Đã xử lí-Đã Giao Hàng')}}</option>
                                          </select>
                                        </form>
                                        @endif
                                        @endforeach
                                      </td>
                                    </tr>
                                    </br>
                                   @php
                                          $total_coupon = 0;
                                   @endphp
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
                                <div class="timeline-badge danger">
                                  <a target="_blank" href="{{url('/print-order/'.$details->order_code)}}" class="material-icons1" style="margin-left: 900px;">
                                    print
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<!--js phân trang tìm kiếm-->

<script src="{{asset('backend/js/jquery.min.js')}}"></script> 
<script src="{{asset('backend/js/matrix.tables.js')}}"></script>
@endsection