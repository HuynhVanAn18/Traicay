@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h3>Đặt hàng thành công!</h3>
        </div>
        <div class="card-body">
            <p>Cảm ơn bạn đã đặt hàng tại <strong>Fresh Fruit</strong>.</p>
            <p>Thông tin đơn hàng của bạn đã được ghi nhận và sẽ được xử lý sớm nhất.</p>
            <hr>
            <h5>Thông tin đơn hàng:</h5>
            <ul>
                <li><strong>Mã đơn hàng:</strong> {{ $order_code ?? 'N/A' }}</li>
                <li><strong>Họ tên:</strong> {{ $shipping['shipping_name'] ?? 'N/A' }}</li>
                <li><strong>Địa chỉ:</strong> {{ $shipping['shipping_address'] ?? 'N/A' }}</li>
                <li><strong>Số điện thoại:</strong> {{ $shipping['shipping_phone'] ?? 'N/A' }}</li>
                <li><strong>Email:</strong> {{ $shipping['shipping_email'] ?? 'N/A' }}</li>
                <li><strong>Ghi chú:</strong> {{ $shipping['shipping_note'] ?? 'N/A' }}</li>
            </ul>
            <h5>Sản phẩm đã đặt:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($cart) && count($cart) > 0)
                        @foreach($cart as $item)
                            <tr>
                                <td>{{ $item['product_name'] }}</td>
                                <td>{{ $item['product_qty'] }}</td>
                                <td>{{ number_format($item['product_price'], 0, ',', '.') }} đ</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="3">Không có sản phẩm nào.</td></tr>
                    @endif
                </tbody>
            </table>
            <a href="/" class="btn btn-primary">Quay về trang chủ</a>
        </div>
    </div>
</div>
@endsection