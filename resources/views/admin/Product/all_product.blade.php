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
    <!-- Filter Form Start -->
    <div class="card mb-3" style="background: #f8f9fa; border: 1px solid #e3e6f0; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
      <div class="card-body p-3">
        <form method="GET" action="" class="form-row align-items-center">
          <div class="col-auto mb-2 mb-sm-0">
            <input type="text" name="product_name" class="form-control" placeholder="Tên Sản Phẩm (VI)" value="{{ request('product_name') }}">
          </div>
          <div class="col-auto mb-2 mb-sm-0">
            <input type="text" name="product_name_en" class="form-control" placeholder="Tên Sản Phẩm (EN)" value="{{ request('product_name_en') }}">
          </div>
          <div class="col-auto mb-2 mb-sm-0">
            <input type="number" name="price_min" class="form-control" placeholder="Giá từ" value="{{ request('price_min') }}" min="0">
          </div>
          <div class="col-auto mb-2 mb-sm-0">
            <input type="number" name="price_max" class="form-control" placeholder="Giá đến" value="{{ request('price_max') }}" min="0">
          </div>
          <div class="col-auto mb-2 mb-sm-0">
            <select name="sort_qty" class="form-control">
              <option value="">Sắp xếp SL</option>
              <option value="asc" {{ request('sort_qty') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
              <option value="desc" {{ request('sort_qty') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
            </select>
          </div>
          <div class="col-auto mb-2 mb-sm-0">
            <select name="category_id" class="form-control">
              <option value="">Danh Mục</option>
              @if(isset($cate_product))
                @foreach($cate_product as $cate)
                  <option value="{{ $cate->category_id }}" {{ request('category_id') == $cate->category_id ? 'selected' : '' }}>{{ $cate->category_name }}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="col-auto mb-2 mb-sm-0">
            <select name="brand_id" class="form-control">
              <option value="">Thương Hiệu</option>
              @if(isset($brand_product))
                @foreach($brand_product as $brand)
                  <option value="{{ $brand->brand_id }}" {{ request('brand_id') == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="col-auto mb-2 mb-sm-0">
            <select name="product_status" class="form-control">
              <option value="">Trạng Thái</option>
              <option value="0" {{ request('product_status') === '0' ? 'selected' : '' }}>Hiển thị</option>
              <option value="1" {{ request('product_status') === '1' ? 'selected' : '' }}>Ẩn</option>
            </select>
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-filter"></i> Lọc
            </button>
            <a href="{{ url()->current() }}" class="btn btn-outline-secondary ml-2">
              <i class="fa fa-times"></i> Xóa lọc
            </a>
          </div>
        </form>
      </div>
    </div>
    <!-- Filter Form End -->
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
      <div class="toolbar"></div>
      <div class="material-datatables">
        <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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
              <td><span class="badge badge-info">{{number_format($pro->product_price,0,',','.')}} đ</span></td>
              <td>{{$pro->product_qty}}</td>
              <td><img src="{{asset('upload/product/'.$pro->product_image)}}" height="80" width="80" style="border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.08);" ></td>
              <td>{{$pro->category_name}}</td>
              <td>{{$pro->brand_name}}</td>
              <td>
                @if($pro->product_status==0)
                  <span class="badge badge-success">Hiển thị</span>
                  <a href="{{URL::to('/unactive-product/'.$pro->product_id)}}" class="ml-2" title="Ẩn"><span class="fa-eye-styling fa fa-eye-slash"></span></a>
                @else
                  <span class="badge badge-secondary">Ẩn</span>
                  <a href="{{URL::to('/active-product/'.$pro->product_id)}}" class="ml-2" title="Hiển thị"><span class="fa-eye-styling fa fa-eye" ></span></a>
                @endif
              </td>
              <td class="td-actions text-right">
                <a class="btn btn-success btn-sm" href="{{URL::to('/edit-product/'.$pro->product_id)}}" title="Cập nhật"><i class="material-icons">edit</i></a>
                <a class="btn btn-danger btn-sm" href="{{URL::to('/delete-product/'.$pro->product_id)}}" onclick="return confirm('Bạn Có Muốn Xoá?')" title="Xóa"><i class="material-icons">close</i></a>
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