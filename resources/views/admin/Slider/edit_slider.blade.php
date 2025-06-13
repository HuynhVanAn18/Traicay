@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">{{__('Cập Nhập Slider')}}</h4>
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
      @foreach($slider as $key => $s)
      <form action="{{URL::to('/update-slider/'.$s->slider_id)}}" enctype="multipart/form-data" method="post" class="form-horizontal">
      {{csrf_field()}}
      <div class="card-body ">
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Tên Slider')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" id="slug" name="slider_name" value="{{$s->slider_name}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Mô Tả Slider')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" name="slider_desc" class="form-control" value="{{$s->slider_desc}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Hình Ảnh')}} :</label>
          <div class="col-sm-7">
            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
              <div class="fileinput-new thumbnail">
                <img src="{{URL::to('upload/slider/'.$s->slider_image)}}" alt="...">
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
            <select class="selectpicker" data-style="btn btn-primary btn-round" name="slider_status" >
              @if($s->slider_status == 0){
                  <option selected value="0">{{__('Ẩn')}}</option>
                  <option value="1">{{__('Hiện')}}</option>
               }
              @else{
                  <option value="0">{{__('Ẩn')}}</option>
                  <option selected  value="1">{{__('Hiện')}}</option>
              }
              @endif
            </select>
          </div>
        </div>
      </div>
      <div class="">
        <center>
          <button type="submit" class="btn btn-rose" name="update_slider">{{__('Cập Nhập Slider')}}</button>
        </center>
    </div>
  </form>
  @endforeach
</div>
@endsection