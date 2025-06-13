@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">{{__('Cập Nhập Mã Giảm Giá Sản Phẩm')}}</h4>
          </div>
          <span class="" style="margin-left: 800px;">
           <?php
           $message = Session::get('message');
           if ($message) {
             echo '<span class="badge badge-pill badge-danger" >'.$message.'</span>';
             Session::put('message',null);
           }
           ?>
         </span>
       </div>
       <br>
       <br>
       @if ($errors->any())
       <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      @foreach($edit_coupon as $key => $coupon)
      <form action="{{URL::to('/update-coupon',$coupon->coupon_id)}}" method="post" class="form-horizontal">
        {{csrf_field()}}
      <div class="card-body ">
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Tên Mã Giảm Giá')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" name="coupon_name" value="{{$coupon->coupon_name}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Mã Giảm Giá')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" name="coupon_code" class="form-control" value="{{$coupon->coupon_code}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Số Lượng Mã')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" name="coupon_qty" value="{{$coupon->coupon_qty}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Ngày Bắt Đầu')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" id="startcoupon" type="text" name="coupon_date_start" value="{{$coupon->coupon_date_start}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Ngày Kết Thúc')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" id="endcoupon" type="text" name="coupon_date_end" value="{{$coupon->coupon_date_end}}" />
            </div>
          </div>
        </div>
         <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Tính Nâng Mã')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <select class="selectpicker" data-style="btn btn-primary btn-round" name="coupon_condition" >
                @if($coupon->coupon_condition==0){
                <option  selected value="0">{{__('Giảm Theo Phần Trăm')}}</option>
                <option  value="1">{{__('Giảm Theo Tiền')}}</option>
                }
                @else{
                <option value="0">{{__('Giảm Theo Phần Trăm')}}</option>
                <option selected value="1">{{__('Giảm Theo Tiền')}}</option>
                }
                @endif
              </select>
          </div>
        </div>
      </div>
      <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Trạng thái mã')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <select class="selectpicker" data-style="btn btn-primary btn-round" name="coupon_status" >
                @if($coupon->coupon_status==0){
                    <option  selected value="0">{{__('Ẩn')}}</option>
                    <option  value="1">{{__('Hiện')}}</option>
                }@else{
                    <option  value="0">{{__('Ẩn')}}</option>
                    <option  selected value="1">{{__('Hiện')}}</option>
                }
                @endif
              </select>
          </div>
        </div>
      </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Số % / Số Tiền Giảm')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" name="coupon_number" value="{{$coupon->coupon_number}}"/>
            </div>
          </div>
        </div>
        <div class="">
        <center>
          <button type="submit" class="btn btn-rose" name="update_coupon">{{__('Cập Nhập Mã Giảm Giá')}}</button>
        </center>
    </div>
  </form>
  @endforeach
</div>
@endsection