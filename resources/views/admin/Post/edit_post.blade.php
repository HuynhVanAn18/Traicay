@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">{{__('Sửa Bài Viết')}}</h4>
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
      @foreach($edit_post as $key => $edit)
      <form action="{{URL::to('/update-post/'.$edit->post_id)}}" method="post" class="form-horizontal" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="card-body ">
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Tên Bài Viết')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" onkeyup="ChangeToSlug();" id="slug" name="post_title" value="{{$edit->post_title}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Slug Bài Viết')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" name="post_slug" id="convert_slug" value="{{$edit->post_slug}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Keywords Bài Viết')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" name="post_keywords" value="{{$edit->post_keywords}}" />
            </div>
          </div>
        </div>
         <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Meta Bài Viết')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" name="post_meta_desc" value="{{$edit->post_meta_desc}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Hình Ảnh Bài Viết')}} :</label>
          <div class="col-sm-7">
            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
              <div class="fileinput-new thumbnail">
                <img src="{{URL::to('upload/post/'.$edit->post_image)}}" alt="...">
              </div>
              <div class="fileinput-preview fileinput-exists thumbnail"></div>
              <div>
                <span class="btn btn-rose btn-round btn-file">
                  <span class="fileinput-new">Select image</span>
                  <span class="fileinput-exists">Change</span>
                  <input type="file" name="post_image" class="form-control" />
                </span>
                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Mô Tả Bài Viết')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <textarea style="resize: none;" name="post_desc" class="form-control" rows="6">{{$edit->post_desc}}</textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Nội Dung Bài Viết')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <textarea style="resize: none;" id="ckeditor1" name="post_content" class="form-control" rows="6">{{$edit->post_content}}</textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Danh Mục Bài Viết')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <select class="selectpicker" data-style="btn btn-primary btn-round" name="cate_blog_id" >
                @foreach($cate_post as $key => $cate)
                <option value="{{$cate->cate_blog_id}}">{{$cate->cate_blog_name}}</option>
                @endforeach
              </select>
          </div>
        </div>
      </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Hiện Ẩn')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <select class="selectpicker" data-style="btn btn-primary btn-round" name="post_status" >
                @if($edit->post_status == 0)
                  <option selected value="0">{{__('Ẩn')}}</option>
                  <option value="1">{{__('Hiện')}}</option>
                @else
                  <option  value="0">{{__('Ẩn')}}</option>
                  <option selected value="1">{{__('Hiện')}}</option>
                @endif
              </select>
          </div>
        </div>
      </div>
      @endforeach
      <div class="">
        <center>
          <button type="submit" class="btn btn-rose" name="update_post">{{__('Cập Nhập Bài Viết')}}</button>
        </center>
    </div>
  </form>
</div>
@endsection