@extends('admin_layout')
@section('admin_content')
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-icon card-header-rose">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
            <h4 class="card-title">{{__('Footer')}}</h4>
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
              <table  class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead class="text-primary">
                  <tr>
                    <th>{{__('Thông Tin Liên Hệ')}}</th>
                    <th>{{__('Bản Đồ')}}</th>
                    <th>Fanpage</th>
                    <th>{{__('Hình Logo')}}</th>
                    <th class="disabled-sorting text-right">{{__('Chỉnh Sửa')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($contact as $key => $c)
                  <tr>
                    <td>{!!$c->info_contact!!}</td>
                    <td style="height: 5%;width: 5%;">{!!$c->info_map!!}</td>
                    <td>{!!$c->info_fanpage!!}</td>
                    <td><img src="{{asset('upload/contact/'.$c->info_logo)}}" height="100" width="100" ></td>
                    <td class="td-actions text-right">
                      <button type="button" rel="tooltip" class="btn btn-success">
                        <a class="material-icons" href="{{URL::to('/edit-footer/'.$c->info_id)}}" data-original-title="Update">edit</a>
                      </button>
                      <button type="button" rel="tooltip" class="btn btn-danger">
                        <a class="material-icons" href="{{URL::to('/delete-footer/'.$c->info_id)}}" onclick="return confirm('Bạn Có Muốn Xoá?')" data-original-title="Delete">close</a>
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
      </div>
@endsection