@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-icon card-header-rose">
      <div class="card-icon">
        <i class="material-icons">assignment</i>
      </div>
      <h4 class="card-title ">All Ads</h4>
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
              {{__('Tên Quảng Cáo')}}
            </th>
            <th>
              {{__('Ảnh Quảng Cáo')}}
            </th>
            <th>
              {{__('Link Quảng Cáo')}}
            </th>
            <th>
              {{__('Mô tả Quảng Cáo')}}
            </th>
            <th>
              {{__('Trạng Thái Quảng Cáo')}}
            </th>
            <th>
             {{__('Chỉnh Sửa')}}
            </th>
          </thead>
          <tbody>
            @foreach($all_ads as $key => $ads)
            <tr class="table-warning">
              <td>{{$ads->ads_name}}</td>
              <td><img src="{{asset('upload/qc/'.$ads->ads_image)}}" height="200" width="300" ></td>
              <td>{{$ads->ads_link}}</td>
              <td>{{$ads->ads_desc}}</td>
              <td>
                  <?php
                  if($ads->ads_status==0)
                  {
                    ?>
                    <a href="{{URL::to('/unactive-ads/'.$ads->ads_id)}}"><span class="fa-eye-styling fa fa-eye-slash"></span></a>
                    <?php 
                  }else{
                    ?>
                    <a href="{{URL::to('/active-ads/'.$ads->ads_id)}}"><span class="fa-eye-styling fa fa-eye" ></span></a>
                    <?php
                  }
                  ?>
              </td>
              <td class="td-actions">
                <button type="button" rel="tooltip" class="btn btn-success btn-round">
                  <a class="material-icons" href="{{URL::to('/edit-ads/'.$ads->ads_id)}}" data-original-title="Update">edit</a>
                </button>
                <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                  <a class="material-icons" href="{{URL::to('/delete-ads/'.$ads->ads_id)}}" onclick="return confirm('Bạn Có Muốn Xoá?')" data-original-title="Delete">close</a>
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
    {!!$all_ads->links()!!}
  </div>
</div>
@endsection