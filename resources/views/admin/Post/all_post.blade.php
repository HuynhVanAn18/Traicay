@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-icon card-header-rose">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
            <h4 class="card-title">{{__('Danh Sách Bài Viết')}}</h4>
          </div>
          <!-- Filter Form Start -->
          <div class="card mb-3" style="background: #f8f9fa; border: 1px solid #e3e6f0; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
            <div class="card-body p-3">
              <form method="GET" action="" class="form-row align-items-center">
                <div class="col-auto mb-2 mb-sm-0">
                  <input type="text" name="post_title" class="form-control" placeholder="Tên Bài Viết" value="{{ request('post_title') }}">
                </div>
                <div class="col-auto mb-2 mb-sm-0">
                  <select name="post_status" class="form-control">
                    <option value="">Trạng Thái</option>
                    <option value="1" {{ request('post_status') === '1' ? 'selected' : '' }}>Hiện</option>
                    <option value="0" {{ request('post_status') === '0' ? 'selected' : '' }}>Ẩn</option>
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
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
              <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead class="text-primary">
                  <tr>
                    <th>{{__('Tên Bài Viết')}}</th>
                    <th>{{__('Hình Ảnh')}}</th>
                    <th>{{__('Slug Bài Viết')}}</th>
                    <th>{{__('Mô Tả Bài Viết')}}</th>
                    <th>{{__('Từ Khóa')}}</th>
                    <th>{{__('Trạng Thái')}}</th>
                    <th class="disabled-sorting text-right">{{__('Chỉnh Sửa')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($all_post as $key => $post)
                  <tr>
                    <td>{{$post->post_title}}</td>
                    <td><img src="{{asset('upload/post/'.$post->post_image)}}" height="100" width="100" ></td>
                    <td>{{$post->post_slug}}</td>
                    <td>{{$post->post_desc}}</td>
                    <td>{{$post->post_keywords}}</td>
                    <td>
                      <?php
                      if($post->post_status==0)
                      {
                        ?>
                          {{__('Ẩn')}}
                        <?php 
                      }else{
                        ?>
                          {{__('Hiện')}}
                        <?php
                      }
                      ?>
                    </td>
                    <td class="td-actions text-right">
                      <button type="button" rel="tooltip" class="btn btn-success">
                        <a class="material-icons" href="{{URL::to('/edit-post/'.$post->post_id)}}" data-original-title="Update">edit</a>
                      </button>
                      <button type="button" rel="tooltip" class="btn btn-danger">
                        <a class="material-icons" href="{{URL::to('/delete-post/'.$post->post_id)}}" onclick="return confirm('Bạn Có Muốn Xoá?')" data-original-title="Delete">close</a>
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
          {!!$all_post->links()!!}
        </div>
      </div>
      <!-- end col-md-12 -->
@endsection