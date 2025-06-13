@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">{{__('Cập Nhập Danh Mục Blog')}}</h4>
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
      <form action="{{URL::to('/update-category-blog',$edit_category_blog->cate_blog_id)}}" method="post" class="form-horizontal">
        {{csrf_field()}}
      <div class="card-body ">
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Tên Danh Mục')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" onkeyup="ChangeToSlug();" id="slug" name="cate_blog_name" value="{{$edit_category_blog->cate_blog_name}}"/>
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Slug Danh Mục')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" id="convert_slug" name="cate_blog_slug" value="{{$edit_category_blog->cate_blog_slug}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Mô Tả Danh Mục')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <textarea style="resize: none;" name="cate_blog_desc" class="form-control" rows="6">{{$edit_category_blog->cate_blog_desc}}</textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Hiện Ẩn')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <select class="selectpicker" data-style="btn btn-primary btn-round" name="cate_blog_status" >
                @if($edit_category_blog->cate_blog_status==0)
                <option selected value="0">{{__('Ẩn')}}</option>
                <option value="1">{{__('Hiện')}}</option>
                @else
                <option value="0">{{__('Ẩn')}}</option>
                <option selected value="1">{{__('Hiện')}}</option>
                @endif
              </select>
            </div>
          </div>
        </div>
      <div class="">
        <center>
          <button type="submit" class="btn btn-rose" name="update_category_blog">{{__('Cập Nhật Danh Mục')}}</button>
        </center>
    </div>
  </form>
</div>
@endsection