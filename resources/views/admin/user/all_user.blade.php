@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header card-header-rose">
                <h4 class="card-title">{{__('Danh Sách Người Dùng')}}</h4>
                <p class="card-category">{{__('Quản lý tất cả người dùng trong hệ thống')}}</p>
            </div>
            <div class="card-body">
                @if(session('message'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{session('message')}}
                    </div>
                @endif
                
                <!-- Filter Form -->
                <form method="GET" action="" class="mb-3">
                    <div class="form-row align-items-end">
                        <div class="col-md-3">
                            <label for="filter_name">{{__('Tên User')}}</label>
                            <input type="text" class="form-control" id="filter_name" name="filter_name" value="{{ request('filter_name') }}" placeholder="Nhập tên user">
                        </div>
                        <div class="col-md-3">
                            <label for="filter_email">{{__('Email')}}</label>
                            <input type="text" class="form-control" id="filter_email" name="filter_email" value="{{ request('filter_email') }}" placeholder="Nhập email">
                        </div>
                        <div class="col-md-3">
                            <label for="filter_role">{{__('Vai Trò')}}</label>
                            <select class="form-control" id="filter_role" name="filter_role">
                                <option value="">-- {{__('Tất cả')}} --</option>
                                <option value="admin" {{ request('filter_role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ request('filter_role') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="staff" {{ request('filter_role') == 'staff' ? 'selected' : '' }}>Staff</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">{{__('Lọc')}}</button>
                            <a href="{{ url()->current() }}" class="btn btn-secondary ml-2">{{__('Đặt lại')}}</a>
                        </div>
                    </div>
                </form>
                <!-- End Filter Form -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="text-warning">
                            <tr>
                                <th>{{__('ID')}}</th>
                                <th>{{__('Tên User')}}</th>
                                <th>{{__('Email')}}</th>
                                <th>{{__('Số Điện Thoại')}}</th>
                                <th>{{__('Vai Trò')}}</th>
                                <th>{{__('Thao Tác')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admin as $key => $user)
                            <tr>
                                <td>{{$user->admin_id}}</td>
                                <td>{{$user->admin_name}}</td>
                                <td>{{$user->admin_email}}</td>
                                <td>{{$user->admin_phone}}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-primary">{{$role->name}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#assignRoleModal{{$user->admin_id}}">
                                        <i class="material-icons">edit</i> {{__('Phân Quyền')}}
                                    </button>
                                    @if(Auth::id() != $user->admin_id)
                                        <a href="{{URL::to('/delete-user-roles/'.$user->admin_id)}}" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('{{__('Bạn có chắc muốn xóa user này?')}}')">
                                            <i class="material-icons">delete</i> {{__('Xóa')}}
                                        </a>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Phân Quyền -->
                            <div class="modal fade" id="assignRoleModal{{$user->admin_id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{URL::to('/assign-roles')}}" method="POST">
                                            {{csrf_field()}}
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{__('Phân Quyền cho')}} {{$user->admin_name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="admin_id" value="{{$user->admin_id}}">
                                                <input type="hidden" name="admin_name" value="{{$user->admin_name}}">
                                                
                                                <div class="form-group">
                                                    <label>{{__('Chọn Vai Trò:')}}</label>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" name="admin_role" value="1"
                                                                @if($user->roles->contains('name', 'admin')) checked @endif>
                                                            {{__('Admin')}}
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" name="user_role" value="1"
                                                                @if($user->roles->contains('name', 'user')) checked @endif>
                                                            {{__('User')}}
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" name="staff_role" value="1"
                                                                @if($user->roles->contains('name', 'staff')) checked @endif>
                                                            {{__('Staff')}}
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Đóng')}}</button>
                                                <button type="submit" class="btn btn-primary">{{__('Lưu Thay Đổi')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Phân trang -->
                <div class="d-flex justify-content-center">
                    {!! $admin->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.badge {
    margin-right: 5px;
}
.modal-body .form-check {
    margin-bottom: 10px;
}
</style>
@endsection
