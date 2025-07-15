@extends('admin_layout')
@section('admin_content')
<div class="col-md-12">
  <form action="{{ route('save-stock-transaction') }}" method="POST" class="form-horizontal">
    @csrf
    <div class="card">
      <div class="card-header card-header-rose card-header-text">
        <div class="card-text">
          <h4 class="card-title">Import Stock Transaction</h4>
        </div>
      </div>
      <div class="card-body ">
        <div class="row">
          <label class="col-sm-2 col-form-label">Product</label>
          <div class="col-sm-7">
            <div class="form-group">
              <select name="product_id" class="form-control" required>
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                  <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <!-- Category and Brand fields are hidden for stock import -->
        <div class="row">
          <label class="col-sm-2 col-form-label">Quantity</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input type="number" name="quantity" class="form-control" min="1" required>
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">Type</label>
          <div class="col-sm-7">
            <div class="form-group">
              <select name="type" class="form-control" required>
                <option value="import">Import</option>
                <option value="export">Export</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">Note</label>
          <div class="col-sm-7">
            <div class="form-group">
              <input type="text" name="note" class="form-control">
            </div>
          </div>
        </div>
        <div class="">
          <center>
            <button type="submit" class="btn btn-success">Save Transaction</button>
            <a href="{{ route('all-stock-transactions') }}" class="btn btn-secondary">Back</a>
          </center>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection