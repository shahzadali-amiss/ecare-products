@extends('layouts.seller')
@section('content')

<!-- Content-->
<section class="col-lg-8 pt-lg-4 pb-4 mb-3">
  <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
    @include('inc.session-message')
    <h2 class="h3 py-2 text-center text-sm-start">Pending Orders</h2>
    <div class="table-responsive">
      
      <table class="table table-layout-fixed fs-sm mb-0 set-table">
        <thead>
          <tr>
            <th width="10%">Image</th>
            <th width="20%">Product</th>
            <th width="10%">Quantity</th>
            <th width="10%">Attributes</th>
            <th width="15%">OrderId</th>
            <th width="20%">Delivery Address</th>
            <th width="10%">Ordered Date</th>
            <th width="15%">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach( getSupplierOrders('pending') as $order)
          <tr>
            <td><img src="{{ asset('product_images') }}/{{ getProduct($order->product_id)->image }}" width="55px"></td>
            <td>{{ getProduct($order->product_id)->name }}</td>
            <td>{{ $order->quantity }}</td>
            <td>
              @if($order->attributes)
                @foreach( json_decode($order->attributes) as $a => $v)
                  <div class="fs-sm"><span class="text-muted me-2">{{ucwords($a)}}:</span>{{ucwords($v)}}</div>
                @endforeach
              @endif
            </td>
            <td>{{ $order->order_id }}</td>
            <td>{{ $order->delivery_address }}</td>
            <td>{{ date('d M Y', strtotime($order->order_time)) }}</td>
            <td>
              <form action="{{route('move-to-complete-order')}}" method="post">
                @csrf
                <input type="hidden" name="orderId" value="{{$order->id}}">
                <button class="btn btn-primary px-2 py-1" type="submit">
                  <small>Move to completed orders</small>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <hr class="mb-grid-gutter">

    <!-- Pagination-->
    {!! getSupplierOrders('pending')->links() !!}
    <!-- <nav class="d-md-flex justify-content-between align-items-center text-center text-md-start" aria-label="Page navigation">
      <div class="d-md-flex align-items-center w-100"><span class="fs-sm text-muted me-md-3">Showing 10 of 52 records</span>
        <div class="progress w-100 my-3 mx-auto mx-md-0" style="max-width: 10rem; height: 4px;">
          <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
      <button class="btn btn-outline-primary btn-sm" type="button">More records</button>
    </nav> -->
  </div>
</section>

@endsection

@push('styles')
  <style>
    nav .pagination{
        justify-content: center;
      }

    .set-table{
      width:150%!important;
    }

    @media (max-width: 560px){
      .set-table{
        width:350%!important;
      }      
    }
  </style>
@endpush