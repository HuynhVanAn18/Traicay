@extends('admin_layout')
@section('admin_content')
<div class="container">
    <h2>Danh Sách Nhân Viên</h2>
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <form method="GET" action="{{ route('staff.index') }}">
        <div class="form-row align-items-center mb-3">
            <div class="col-auto mb-2 mb-sm-0">
                <input type="text" name="name" class="form-control" placeholder="Tên nhân viên" value="{{ request('name') }}">
            </div>
            <div class="col-auto mb-2 mb-sm-0">
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="{{ request('phone') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-filter"></i> Lọc
                </button>
                <a href="{{ route('staff.index') }}" class="btn btn-outline-secondary ml-2">
                    <i class="fa fa-times"></i> Xóa lọc
                </a>
            </div>
        </div>
    </form>
    <a href="{{ route('staff.create') }}" class="btn btn-primary mb-3">Thêm Nhân Viên</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffs as $staff)
            <tr>
                <td>{{ $staff->admin_id }}</td>
                <td>{{ $staff->admin_name }}</td>
                <td>{{ $staff->admin_email }}</td>
                <td>{{ $staff->admin_phone }}</td>
                <td>
                    <a href="{{ route('staff.edit', $staff->admin_id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('staff.destroy', $staff->admin_id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa nhân viên này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
