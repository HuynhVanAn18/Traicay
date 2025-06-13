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