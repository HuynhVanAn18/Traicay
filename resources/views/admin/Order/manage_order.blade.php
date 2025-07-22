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
                              <!-- Filter Form Start -->
                              <div class="card mb-4" style="background: #f8f9fa; border: 1px solid #e3e6f0; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                <div class="card-body p-3">
                                  <form method="GET" action="">
                                    <div class="form-row align-items-center">
                                      <div class="col-auto mb-2 mb-sm-0">
                                        <input type="text" name="order_code" class="form-control" placeholder="Mã đơn hàng" value="{{ request('order_code') }}">
                                      </div>
                                      <div class="col-auto mb-2 mb-sm-0">
                                        <select name="order_status" class="form-control">
                                          <option value="">Tình trạng</option>
                                          <option value="1" {{ request('order_status') == '1' ? 'selected' : '' }}>Đơn hàng mới</option>
                                          <option value="2" {{ request('order_status') == '2' ? 'selected' : '' }}>Đã xử lý đơn hàng</option>
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
                                    </div>
                                  </form>
                                </div>
                              </div>
                              <!-- Filter Form End -->
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
                                                {{__('Đã xử lý đơn hàng')}}
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