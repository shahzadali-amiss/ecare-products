@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Orders</h4>
          <div class="row grid-margin">
            <div class="col-12">
              @include('admin.inc.session-message')
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="order-listing" class="table">
                  <thead>
                    <tr class="bg-primary text-white">
                        <th>#</th>
                        <th>Image</th>
                        <th>Order Id</th>
                        <th>Payment Id</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Quantity</th>
                        <th>Attributes</th>
                        <th>Price(in ₹)</th>
                        <th>Delivery Address</th>
                        <th>In Cart</th>
                        <th>Ordered Date</th>
                        <th>Status</th>
                        <!-- <th>Actions</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($orders as $key => $order)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><img src="{{ asset('product_images') }}/{{ getProduct($order->product_id)->image }}" width="55px"></td>
                        <td>{{$order->order_id}}</td>
                        <td>{{$order->pmt_id}}</td>
                        <td>{{getProduct($order->product_id)->name}}({{$order->product_id}})</td>
                        <td>{{ucwords(getUserById($order->user_id)->name)}}({{$order->user_id}})</td>
                        <td>{{$order->quantity}}</td>
                        <td>
                          @if($order->attributes)
                            @foreach( json_decode($order->attributes) as $a => $v)
                              <div class="fs-sm"><span class="text-muted me-2">{{ucwords($a)}}:</span>{{ucwords($v)}}</div>
                            @endforeach
                          @endif
                        </td>
                        <td>{{$order->final_price}}</td>
                        <td>{{$order->delivery_address}}</td>
                        <td>
                          @if($order->is_in_cart)
                          <label class="badge badge-success">Yes</label>
                          @else
                          <label class="badge badge-danger">No</label>
                          @endif
                        </td>
                        <td>
                          @if(!is_null($order->order_time))
                            {{date('d M Y', strtotime($order->order_time))}}
                          @endif
                        </td>
                        <td>
                          @if($order->status=='pending')
                          <label class="badge badge-info">Pending</label>
                          @elseif($order->status=='hold')
                          <label class="badge badge-danger">Hold</label>
                          @elseif($order->status=='delivered')
                          <label class="badge badge-success">Delivered</label>
                          @endif
                        </td>
                        <!-- <td class="text-right">
                          <a href="" class="btn btn-light">
                            <i class="ti-eye text-primary"></i>View
                          </a>
                          <a href="" class="btn btn-light">
                            <i class="ti-pencil-alt text-warning"></i>Edit
                          </a>
                          <a href="" class="btn btn-light">
                            <i class="ti-close text-danger"></i>Remove
                          </a>
                        </td> -->
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection