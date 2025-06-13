@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-icon card-header-rose">
      <div class="card-icon">
        <i class="material-icons">assignment</i>
      </div>
      <h4 class="card-title ">All Slider</h4>
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
    <div class="card-body table-full-width table-hover">
      <div class="table-responsive">
        <table class="table">
          <thead class="text-primary">
            <th>
              {{__('Tên Slider')}}
            </th>
            <th>
              {{__('Hình Ảnh')}}
            </th>
            <th>
              {{__('Mô Tả Slider')}}
            </th>
            <th>
              {{__('Trạng Thái')}}
            </th>
            <th>
              {{__('Chỉnh Sửa')}}
            </th>
          </thead>
          <tbody>
            @foreach($all_slider as $key => $slider)
            <tr class="table-warning">
              <td>{{$slider->slider_name}}</td>
              <td><img src="{{asset('upload/slider/'.$slider->slider_image)}}" height="200" width="300" ></td>
              <td>{{$slider->slider_desc}}</td>
              <td>
                  <?php
                  if($slider->slider_status==0)
                  {
                    ?>
                    <a href="{{URL::to('/unactive-slider/'.$slider->slider_id)}}"><span class="fa-eye-styling fa fa-eye-slash"></span></a>
                    <?php 
                  }else{
                    ?>
                    <a href="{{URL::to('/active-slider/'.$slider->slider_id)}}"><span class="fa-eye-styling fa fa-eye" ></span></a>
                    <?php
                  }
                  ?>
              </td>
              <td class="td-actions">
                <button type="button" rel="tooltip" class="btn btn-success btn-round">
                  <a class="material-icons" href="{{URL::to('/edit-slider/'.$slider->slider_id)}}" data-original-title="Update">edit</a>
                </button>
                <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                  <a class="material-icons" href="{{URL::to('/delete-slider/'.$slider->slider_id)}}" onclick="return confirm('Bạn Có Muốn Xoá?')" data-original-title="Delete">close</a>
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-12">
    {!!$all_slider->links()!!}
  </div>
</div>
@endsection