@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">{{__('Chỉnh Sủa Thông Tin Footer')}}</h4>
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
        @foreach($contact as $key => $c)
        <form action="{{URL::to('/update-footer/'.$c->info_id)}}" enctype="multipart/form-data" method="post" class="form-horizontal">
        {{csrf_field()}}
         <div class="row">
            <label class="col-sm-2 col-form-label">{{__('Thông Tin Liên Hệ')}} :</label>
            <div class="col-sm-7">
              <div class="form-group">
               <textarea name="contact_info" id="ckeditor2" class="" rows="12">{{$c->info_contact}}</textarea>
             </div>
           </div>
         </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Bản Đồ')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <textarea class="form-control" type="text" name="map_info" placeholder="Link Bản Đồ" >{{$c->info_map}}</textarea>
            </div>
          </div>
        </div>
         <div class="row">
          <label class="col-sm-2 col-form-label">Fanpage :</label>
          <div class="col-sm-7">
            <div class="form-group">
               <textarea class="form-control" type="text" name="fanpage_info" placeholder="Link Fanpage FaceBook" >{{$c->info_fanpage}}</textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Hình Ảnh Logo')}} :</label>
          <div class="col-sm-7">
            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
              <div class="fileinput-new thumbnail">
                <img src="{{URL::to('upload/contact/'.$c->info_logo)}}" alt="...">
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
          <button type="submit" class="btn btn-rose" name="add_info">{{__('Cập Nhập Thông Tin')}}</button>
        </center>
    </div>
  </form>
  @endforeach
</div>
@endsection