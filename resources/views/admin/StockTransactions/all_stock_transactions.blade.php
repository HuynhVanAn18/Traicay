@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-rose card-header-text">
      <div class="card-text">
        <h4 class="card-title">Danh Sách Giao Dịch Kho</h4>
      </div>
    </div>
    <div class="card-body ">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
          <thead class="text-primary">
            <tr>
              <th>{{__('Tên Sản Phẩm')}}</th>
              <th>{{__('Số Lượng')}}</th>
              <th>{{__('Loại')}}</th>
              <th>{{__('Ghi chú')}}</th>
              <th>{{__('Người nhập')}}</th>
              <th>{{__('Ngày tạo')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transactions as $transaction)
            <tr>
              <td>{{ $transaction->product ? $transaction->product->product_name : '' }}</td>
              <td>{{ $transaction->quantity }}</td>
              <td>
                @if($transaction->type == 'import')
                  <span class="badge badge-success">Nhập kho</span>
                @else
                  <span class="badge badge-warning">Xuất kho</span>
                @endif
              </td>
              <td>{{ $transaction->note }}</td>
              <td>{{ $transaction->admin_id }}</td>
              <td>{{ $transaction->created_at }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="col-lg-12">
        {!! $transactions->links() !!}
      </div>
    </div>
  </div>
</div>
@endsection