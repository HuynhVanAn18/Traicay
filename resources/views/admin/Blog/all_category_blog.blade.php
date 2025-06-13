@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-icon card-header-rose">
      <div class="card-icon">
        <i class="material-icons">assignment</i>
      </div>
      <h4 class="card-title "> {{__('Liệt Kê Danh Mục Blog')}}</h4>
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
              {{__('Tên Danh Mục')}}
            </th>
            <th>
              {{__('Mô Tả Danh Mục')}}
            </th>
            <th>
              {{__('Slug Danh Mục')}}
            </th>
            <th>
              {{__('Chỉnh Sửa')}}
            </th>
          </thead>
          <tbody>
            @foreach($all_category_blog as $key => $cate_blog)
            <tr class="table-danger">
              <td>{{$cate_blog->cate_blog_name}}</td>
              <td>{{$cate_blog->cate_blog_desc}}</td>
              <td>{{$cate_blog->cate_blog_slug}}</td>
              <td class="td-actions">
                <button type="button" rel="tooltip" class="btn btn-success btn-round">
                  <a class="material-icons" href="{{URL::to('/edit-category-blog',$cate_blog->cate_blog_id)}}" data-original-title="Update">edit</a>
                </button>
                <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                  <a class="material-icons" href="{{URL::to('/delete-category-blog',$cate_blog->cate_blog_id)}}" onclick="return confirm('Bạn Có Muốn Xoá?')" data-original-title="Delete">close</a>
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div style="margin-left: 700px">
          <table>
           <form action="{{url('/import-cateblog')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".xlsx"><br>
            <input type="submit" value="Import File Excel" name="import_excel" class="btn btn-warning">
          </form>
          <form action="{{url('/export-cateblog')}}" method="POST">
            @csrf
            <input type="submit" value="Export File Excel" name="export_excel" class="btn btn-success">
          </form>
        </table>
      </div>
      </div>
    </div>
  </div>
</div>
<div class="col-lg-12">
  {!!$all_category_blog->links()!!}
</div>
@endsection