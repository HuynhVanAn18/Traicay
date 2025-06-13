@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
  <form action="{{URL::to('/save-footer')}}" enctype="multipart/form-data" method="post" class="form-horizontal">
    {{csrf_field()}}
    <div class="card">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">{{__('Thêm Thông Tin Footer')}}</h4>
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
            <label class="col-sm-2 col-form-label">{{__('Thông Tin Liên Hệ')}} :</label>
            <div class="col-sm-7">
              <div class="form-group">
               <textarea name="contact_info" id="ckeditor2" class="" rows="12" placeholder="{{__('Nhập Nội Thông Tin Liên Hệ')}}"></textarea>
             </div>
           </div>
         </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Bản Đồ')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <textarea class="form-control" type="text" name="map_info" placeholder="{{__('Link Bản Đồ')}}" ></textarea>
            </div>
          </div>
        </div>
         <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Fanpage')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
               <textarea class="form-control" type="text" name="fanpage_info" placeholder="Link Fanpage FaceBook" ></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Hình Ảnh Logo')}} :</label>
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
                  <input type="file" name="image_info" class="form-control" />
                </span>
                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
              </div>
            </div>
          </div>
        </div>
      <div class="">
        <center>
          <button type="submit" class="btn btn-rose" name="add_info">{{__('Thêm Thông Tin')}}</button>
        </center>
    </div>
  </form>
</div>
@endsection