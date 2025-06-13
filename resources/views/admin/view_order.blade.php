@extends('admin_layout')
@section('admin_content')
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
          <div class="widget-box">
                  <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>Thông Tin Khách Hàng</h5>
                  </div>
                  <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                      <thead>
                        <tr>
                          <th>Tên Khách Hàng</th>
                          <th>Số Điện Thoại</th>
                          <th>Email</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="gradeX">
                          <td>{{$order_by_id->customer_name}}</td>
                          <td>{{$order_by_id->customer_phone}}</td>
                          <td>{{$order_by_id->customer_email}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
          </div>
        </div>
      </div>
    </div>




<br>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
          <div class="widget-box">
                  <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>Thông Tin Vận Chuyển</h5>
                  </div>
                  <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                      <thead>
                        <tr>
                          <th>Tên Người Nhận</th>
                          <th>Địa Chỉ</th>
                          <th>Số Điện Thoại</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="gradeX">
                          <td>{{$order_by_id->shipping_name}}</td>
                          <td>{{$order_by_id->shipping_address}}</td>
                          <td>{{$order_by_id->shipping_phone}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
          </div>
        </div>
      </div>
    </div>




<br>

<div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
          <div class="widget-box">
                  <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>Chi Tiết Đơn Hàng</h5>
                  </div>
                  <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                      <thead>
                        <tr>
                          <th>Tên Sản Phẩm</th>
                          <th>Số Lượng</th>
                          <th>Giá</th>
                          <th>Tổng Giá Tiền</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="gradeX">
                          <td>{{$order_by_id->product_name}}</td>
                          <td>{{$order_by_id->product_sales_quantity}}</td>
                          <td>{{$order_by_id->product_price}}</td>
                          <td>{{number_format($order_by_id->product_price*$order_by_id->product_sales_quantity).' '.'VNĐ'}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
          </div>
        </div>
      </div>
</div>





<!--js phân trang tìm kiếm-->

{{-- <script src="{{asset('public/backend/js/jquery.min.js')}}"></script> 
<script src="{{asset('public/backend/js/matrix.tables.js')}}"></script> --}}
@endsection