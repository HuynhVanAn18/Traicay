@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
  <form action="{{URL::to('/save-brand-product')}}" method="post" class="form-horizontal">
    {{csrf_field()}}
    <div class="card">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">{{__('Thêm Thương Hiệu Sản Phẩm')}}</h4>
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
      <div class="card-body ">
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Tên Thương Hiệu')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" onkeyup="ChangeToSlug();" id="slug" name="brand_product_name" placeholder="{{__('Nhập Tên Thương Hiệu Sản Phẩm')}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Tên Thương Hiệu En')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" name="brand_product_name_en" class="form-control" placeholder="{{__('Nhập Tên Danh Mục En')}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Slug Thương Hiệu')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" id="convert_slug" name="brand_slug" placeholder="{{__('Nhập Tên Slug Thương Hiệu không dấu')}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Mô Tả Thương Hiệu')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <textarea style="resize: none;" name="brand_product_desc" class="form-control" rows="6" placeholder="{{__('Nhập Mô Tả Danh Mục')}}"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Hiện Ẩn')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <select class="selectpicker" data-style="btn btn-primary btn-round" name="brand_product_status" >
                <option value="0">{{__('Ẩn')}}</option>
                <option selected value="1">{{__('Hiện')}}</option>
              </select>
          </div>
        </div>
      </div>
      <div class="">
        <center>
          <button type="submit" class="btn btn-rose" name="add_brand_product">{{__('Thêm Thương Hiệu')}}</button>
        </center>
    </div>
  </form>
</div>
@endsection