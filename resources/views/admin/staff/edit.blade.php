@extends('admin_layout')
@section('admin_content')
<div class="container">
    <h2>Cập Nhật Nhân Viên</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('staff.update', $staff->admin_id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Tên nhân viên</label>
            <input type="text" name="admin_name" class="form-control" value="{{ $staff->admin_name }}" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="admin_email" class="form-control" value="{{ $staff->admin_email }}" required>
        </div>
        <div class="form-group">
            <label>Mật khẩu mới (bỏ trống nếu không đổi)</label>
            <input type="password" name="admin_password" class="form-control">
        </div>
        <div class="form-group">
            <label>Điện thoại</label>
            <input type="text" name="admin_phone" class="form-control" value="{{ $staff->admin_phone }}" required>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('staff.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
