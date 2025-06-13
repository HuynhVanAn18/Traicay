@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
  <form action="{{URL::to('/save-slider')}}" enctype="multipart/form-data" method="post" class="form-horizontal">
    {{csrf_field()}}
    <div class="card">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">{{__('Thêm Slider')}}</h4>
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
          <label class="col-sm-2 col-form-label">{{__('Tên Slider')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" id="slug" name="slider_name" placeholder="{{__('Nhập Tên Slider')}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Mô Tả Slider')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" name="slider_desc" class="form-control" placeholder="{{__('Nhập Mô Tả Slider')}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Hình Ảnh')}} :</label>
          <div class="col-sm-7">
            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
              <div class="fileinput-new thumbnail">
                <img src="{{asset('backend/assets/img/image_placeholder.jpg')}}" alt="...">
              </div>
              <div class="fileinput-preview fileinput-exists thumbnail"></div>
              <div>
                <span class="btn btn-rose btn-round btn-file">
                  <span class="fileinput-new">Select image</span>
                  <span class="fileinput-exists">Change</span>
                  <input type="file" name="slider_image" class="form-control" />
                </span>
                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
              </div>
            </div>
          </div>
        </div>
      <div class="row">
        <label class="col-sm-2 col-form-label">{{__('Trạng Thái')}} :</label>
        <div class="col-sm-7">
          <div class="form-group">
            <select class="selectpicker" data-style="btn btn-primary btn-round" name="{{__('slider_status')}}" >
              <option value="0">{{__('Ẩn')}}</option>
              <option  selected value="1">{{__('Hiện')}}</option>
            </select>
          </div>
        </div>
      </div>
      <div class="">
        <center>
          <button type="submit" class="btn btn-rose" name="add_slider">{{__('Thêm Slider')}}</button>
        </center>
    </div>
  </form>
</div>
@endsection