@extends('admin_layout')
@section('admin_content')
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
          <div class="widget-box">
                  <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <span class="label">
                         <?php
                                $message = Session::get('message');
                                if ($message) {
                                   echo '<span class="" >'.$message.'</span>';
                                   Session::put('message',null);
                                }
                         ?>
                    </span>
                  </div>
                  <div class="content">
                    <div class="container-fluid">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="card">
                              <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon">
                                  <i class="material-icons">assignment</i>
                                </div>
                                <h4 class="card-title ">{{__('Chi tiết đơn hàng')}}</h4>
                              </div>
                              <div class="widget-content nopadding">
                                <table class="table table-bordered data-table">
                                  <thead>
                                    <tr>
                                      <th>{{__('STT')}}</th>
                                      <th>{{__('Mã đơn hàng')}}</th>
                                      <th>{{__('Tình trạng đơn hàng')}}</th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @php
                                    $i = 0;
                                    @endphp
                                    @foreach($order as $key => $ord)
                                    @php
                                    $i++;
                                    @endphp
                                    <tr class="gradeX">
                                      <td>{{$i}}</td>
                                      <td>{{$ord->order_code}}</td>
                                      <td><?php
                                              if ($ord->order_status==1) {

                                                ?>
                                                {{__('Đơn hàng mới')}}
                                                <?php
                                              }else{
                                                ?>
                                                {{__('Đã xử lí đơn hàng')}}
                                                <?php 
                                              }      
                                              ?>
                                      </td>
                                      <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-info btn-round">
                                          <a class="material-icons" href="{{URL::to('/view-order/'.$ord->order_code)}}" data-original-title="Update">edit</a>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                          <a class="material-icons" href="{{URL::to('/delete-order/'.$ord->order_id)}}" onclick="return confirm('Bạn Có Muốn Xoá?')" data-original-title="Delete">close</a>
                                        </button>
                                      </td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              {!!$order->links()!!}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
<!--js phân trang tìm kiếm-->
@endsection