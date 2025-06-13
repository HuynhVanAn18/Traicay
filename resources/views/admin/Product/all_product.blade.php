@extends('admin_layout')
@section('admin_content')
     <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-icon card-header-rose">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
            <h4 class="card-title">{{__('Danh Sách Sản Phẩm')}}</h4>
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
          <div class="card-body">
            <div class="toolbar">
            </div>
            <div class="material-datatables">
              <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead class="text-primary">
                  <tr>
                    <th>{{__('Tên Sản Phẩm')}}</th>
                    <th>{{__('Tên Sản Phẩm En')}}</th>
                    <th>{{__('Slug Sản Phẩm')}}</th>
                    <th>{{__('Giá')}}</th>
                    <th>{{__('Số Lượng')}}</th>
                    <th>{{__('Hình Ảnh')}}</th>
                    <th>{{__('Danh Mục')}}</th>
                    <th>{{__('Thương Hiệu')}}</th>
                    <th>{{__('Hiển Thị')}}</th>
                    <th class="disabled-sorting text-right">{{__('Chỉnh Sửa')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($all_product as $key => $pro)
                  <tr>
                    <td>{{$pro->product_name}}</td>
                    <td>{{$pro->product_name_en}}</td>
                    <td>{{$pro->product_slug}}</td>
                    <td>{{$pro->product_price}}</td>
                    <td>{{$pro->product_qty}}</td>
                    <td><img src="{{asset('upload/product/'.$pro->product_image)}}" height="100" width="100" ></td>
                    <td>{{$pro->category_name}}</td>
                    <td>{{$pro->brand_name}}</td>
                    <td>
                      <?php
                      if($pro->product_status==0)
                      {
                        ?>
                        <a href="{{URL::to('/unactive-product/'.$pro->product_id)}}"><span class="fa-eye-styling fa fa-eye-slash"></span></a>
                        <?php 
                      }else{
                        ?>
                        <a href="{{URL::to('/active-product/'.$pro->product_id)}}"><span class="fa-eye-styling fa fa-eye" ></span></a>
                        <?php
                      }
                      ?>
                    </td>
                    <td class="td-actions text-right">
                      <button type="button" rel="tooltip" class="btn btn-success">
                        <a class="material-icons" href="{{URL::to('/edit-product/'.$pro->product_id)}}" data-original-title="Update">edit</a>
                      </button>
                      <button type="button" rel="tooltip" class="btn btn-danger">
                        <a class="material-icons" href="{{URL::to('/delete-product/'.$pro->product_id)}}" onclick="return confirm('Bạn Có Muốn Xoá?')" data-original-title="Delete">close</a>
                      </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
        <div class="col-lg-12">
          {!!$all_product->links()!!}
        </div>
      </div>
      <!-- end col-md-12 -->
@endsection