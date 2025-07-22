@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-icon card-header-rose">
      <div class="card-icon">
        <i class="material-icons">assignment</i>
      </div>
      <h4 class="card-title ">{{__('Liệt Kê Thương Hiệu Sản Phẩm')}}</h4>
    </div>
    <!-- Filter Form Start -->
    <div class="card mb-3" style="background: #f8f9fa; border: 1px solid #e3e6f0; box-shadow: none;">
      <div class="card-body p-3">
        <form method="GET" action="/all-brand-product-filtered" class="form-row align-items-center">
          <div class="col-auto mb-2 mb-sm-0">
            <input type="text" name="brand_name" class="form-control" placeholder="Tên Thương Hiệu (VI)" value="{{ request('brand_name') }}">
          </div>
          <div class="col-auto mb-2 mb-sm-0">
            <input type="text" name="brand_name_en" class="form-control" placeholder="Tên Thương Hiệu (EN)" value="{{ request('brand_name_en') }}">
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
   <br>
       <br>
       {{-- validate --}}
       @if ($errors->any())
       <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
    <div class="card-body table-full-width table-hover">
      <div class="table-responsive">
        {{-- validate import ex --}}
      @if(session()->has('failures'))
        <div>
           <table class="table table-danger">
               <thead class="text-primary">
                   <th>{{__('Hàng Lỗi')}}</th>
                   <th>{{__('Cột Lỗi')}}</th>
                   <th>{{__('Lỗi')}}</th>
                   <th>{{__('Giá Trị')}}</th>
               </thead>
                @foreach(session()->get('failures') as $erroo)
                <tr>
                    <td>{{ $erroo->row() }}</td>
                    <td>{{ $erroo->attribute() }}</td>
                    <td>
                        <ul>
                            @foreach($erroo->errors() as $e)
                                <li>{{$e}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        {{ $erroo->values()[$erroo->attribute()] }}
                    </td>
                </tr>
                @endforeach
           </table>
        </div>
        @endif
       {{-- validate import ex --}}
        <table class="table">
          <thead class="text-primary">
            <th>
              {{__('Tên Thương Hiệu')}}
            </th>
            <th>
              {{__('Tên Thương Hiệu En')}}
            </th>
            <th>
             {{__('Slug Thương Hiệu')}}
            </th>
            <th>
             {{__('Hiển Thị')}}
            </th>
            <th>
             {{__('Chỉnh Sửa')}}
            </th>
          </thead>
          <tbody>
            @foreach($all_brand_product as $key => $cate_pro)
            <tr class="table-warning">
              <td>{{$cate_pro->brand_name}}</td>
              <td>{{$cate_pro->brand_name_en}}</td>
              <td>{{$cate_pro->brand_slug}}</td>
              <td>
                  <?php
                  if($cate_pro->brand_status==0)
                  {
                    ?>
                    <a href="{{URL::to('/unactive-brand-product/'.$cate_pro->brand_id)}}"><span class="fa-eye-styling fa fa-eye-slash"></span></a>
                    <?php 
                  }else{
                    ?>
                    <a href="{{URL::to('/active-brand-product/'.$cate_pro->brand_id)}}"><span class="fa-eye-styling fa fa-eye" ></span></a>
                    <?php
                  }
                  ?>
              </td>
              <td class="td-actions">
                <button type="button" rel="tooltip" class="btn btn-success btn-round">
                  <a class="material-icons" href="{{URL::to('/edit-brand-product',$cate_pro->brand_id)}}" data-original-title="Update">edit</a>
                </button>
                <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                  <a class="material-icons" href="{{URL::to('/delete-brand-product',$cate_pro->brand_id)}}" onclick="return confirm('Bạn Có Muốn Xoá?')" data-original-title="Delete">close</a>
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div style="margin-left: 700px">
          <table>
           <form action="{{url('/import-brand')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".xlsx"><br>
            <input type="submit" value="Import File Excel" name="import_excel" class="btn btn-warning">
          </form>
          <form action="{{url('/export-brand')}}" method="POST">
            @csrf
            <input type="submit" value="Export File Excel" name="export_excel" class="btn btn-success">
          </form>
        </table>
      </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12">
    {!!$all_brand_product->links()!!}
  </div>
</div>
@endsection