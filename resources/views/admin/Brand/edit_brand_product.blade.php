@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">{{__('Cập Nhập Thương Hiệu Sản Phẩm')}}</h4>
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
       @foreach($edit_brand_product as $key => $edit_value)
      <form action="{{URL::to('/update-brand-product',$edit_value->brand_id)}}" method="post" class="form-horizontal">
        {{csrf_field()}}
      <div class="card-body ">
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Tên Thương Hiệu')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" onkeyup="ChangeToSlug();" id="slug" name="brand_product_name" value="{{$edit_value->brand_name}}"/>
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Tên Thương Hiệu En')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" name="brand_product_name_en" class="form-control" value="{{$edit_value->brand_name_en}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Slug Thương Hiệu')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input class="form-control" type="text" id="convert_slug" name="brand_slug" value="{{$edit_value->brand_slug}}" />
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">{{__('Mô Tả Thương Hiệu')}} :</label>
          <div class="col-sm-7">
            <div class="form-group">
              <textarea style="resize: none;" name="brand_product_desc" class="form-control" rows="6">{{$edit_value->brand_desc}}</textarea>
            </div>
          </div>
        </div>
      @endforeach
      <div class="">
        <center>
          <button type="submit" class="btn btn-rose" name="update_brand_product">{{__('Cập Nhật Thương Hiệu')}}</button>
        </center>
    </div>
  </form>
</div>
@endsection