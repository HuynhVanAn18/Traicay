@extends('admin_layout')
@section('admin_content')
<div class="container">
    <h2>Thêm Nhân Viên</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('staff.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Tên nhân viên</label>
            <input type="text" name="admin_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="admin_email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" name="admin_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Điện thoại</label>
            <input type="text" name="admin_phone" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Thêm</button>
        <a href="{{ route('staff.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
