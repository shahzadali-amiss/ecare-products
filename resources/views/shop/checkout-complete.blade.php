@extends('layouts.common')
@section('content')
  <div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
      <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
            <li class="breadcrumb-item"><a class="text-nowrap"><i class="ci-home"></i>Home</a></li>
            <li class="breadcrumb-item text-nowrap"><a>Shop</a>
            </li>
            <li class="breadcrumb-item text-nowrap active" aria-current="page">Checkout</li>
          </ol>
        </nav>
      </div>
      <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
        <h1 class="h3 text-light mb-0">Checkout</h1>
      </div>
    </div>
  </div>
  <div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
      <section class="col-lg-8">
        <!-- Steps-->
        <div class="steps steps-light pt-2 pb-3 mb-5">
          <a class="step-item active" href="{{ route('cart') }}">
            <div class="step-progress">
              <span class="step-count">1</span>
            </div>
            <div class="step-label">
              <i class="ci-cart"></i>Cart
            </div>
          </a>
          <a class="step-item active" href="#">
            <div class="step-progress">
              <span class="step-count">2</span>
            </div>
            <div class="step-label">
              <i class="ci-user-circle"></i>Shipping Details
            </div>
          </a>
          <a class="step-item active" href="#">
            <div class="step-progress">
              <span class="step-count">3</span>
            </div>
            <div class="step-label">
              <i class="ci-check-circle"></i>Review
            </div>
          </a>
          <a class="step-item active" href="#">
            <div class="step-progress">
              <span class="step-count">4</span>
            </div>
            <div class="step-label">
              <i class="ci-card"></i>Payment
            </div>
          </a>
          <a class="step-item active current" href="#">
            <div class="step-progress">
              <span class="step-count">5</span>
            </div>
            <div class="step-label">
              <i class="ci-card"></i>Order Status
            </div>
          </a>
        </div>
        <!-- Payment methods accordion-->
        @include('inc.session-message')



        <div class="card py-3 my-sm-3 mb-sm-5">
          <div class="card-body text-center">
            <h2 class="h4 pb-3 text-success">Thank you for your order!</h2>
            <p class="fs-sm mb-2">Your order has been placed and will be processed as soon as possible.</p>
            <p class="fs-sm mb-2">Make sure you make note of your payment id, which is 
              <span class='fw-medium'>{{$payment->pmt_id}}</span>
            </p>
            <p class="fs-sm">You will be receiving an email shortly with confirmation of your order.</p>
            {{-- <a class="btn btn-secondary mt-3 me-3" href="{{route('home-pages','orders')}}">Check Your Orders</a><a class="btn btn-primary mt-3" href="{{route('order-tracking')}}"><i class="ci-location"></i>&nbsp;Track order</a> --}}
          </div>
        </div>
        <h2 class="h3 pb-3 mb-2 text-center text-md-start">Your Orders</h2>
        @foreach( $orders as $order )
        <div class="d-sm-flex justify-content-between my-4 pb-3 border-bottom">
          <div class="d-sm-flex text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto me-sm-4" href="{{route('single', getProduct($order->product_id)->id)}}"><img src="{{ asset('product_images').'/'.getProduct($order->product_id)->image }}" width="160" alt="Product"></a>
            <div class="pt-2">
              <h3 class="product-title fs-base m-2"><a href="{{route('single', getProduct($order->product_id)->id)}}">{{ucwords(getProduct($order->product_id)->name)}}</a></h3>
              

              @if(getCartProductAttributes($order->product_id))
              @foreach(getCartProductAttributes($order->product_id) as $a => $v)
              <div class="fs-sm"><span class="text-muted me-2">{{ucwords($a)}}:</span>{{ucwords($v)}}</div>
              @endforeach
              @endif
              
              <div class="fs-lg text-accent pt-2">₹{{getProduct($order->product_id)->offer_price*$order->quantity}}</div>
              <div class="fs-sm pt-2">
                <span class="text-accent">Order Id: </span>{{$order->order_id}}
              </div>
              <div class="fs-sm pt-2">
                <span class="text-accent">Order Date: </span>{{date('d M, Y',strtotime($order->order_time))}}
              </div>
            </div>
          </div>
          <div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-end" style="max-width: 9rem;">
            <p class="mb-0"><span class="text-muted fs-sm">Quantity:</span><span>&nbsp;{{$order->quantity}}</span></p>
            <!-- <button class="btn btn-link px-0" type="button"><i class="ci-edit me-2"></i><span class="fs-sm">Edit</span></button> -->
          </div>
        </div>
        @endforeach


      </section>
      <!-- Sidebar-->
      <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
        <div class="bg-white rounded-3 shadow-lg p-4 ms-lg-auto">
          <div class="py-2 px-xl-2">
            <div class="widget mb-3">
              <h2 class="widget-title text-center">Shipping to</h2>
            </div>
            <div class="bg-secondary rounded-3 px-4 pt-4 pb-2">
              <ul class="list-unstyled fs-sm">
                <li><span class="text-muted">Customer:&nbsp;</span>{{ucwords(getShippingAddress(Session::get('customer.id'))->name)}}</li>
                <li><span class="text-muted">Address:&nbsp;</span>{{ucwords(getShippingAddress()->house)}}, {{ucwords(getShippingAddress()->area)}}, {{ucwords(getShippingAddress()->landmark)}}, {{ucwords(getCityName(getShippingAddress()->city))}}, {{ucwords(strtolower(getStateName(getShippingAddress()->state)))}} - {{ucwords(getShippingAddress()->pincode)}}</li>
                <li><span class="text-muted">Phone:&nbsp;</span>+91 {{getShippingAddress(Session::get('customer.id'))->mobile}}</li>
              </ul>
            </div>
            <h6 class="fw-normal text-center mt-4">Total order value</h6>
            <h3 class="fw-normal text-center mb-4">₹{{$payment->amount}}</h3>
          </div>
        </div>
      </aside>
    </div>
  </div>
</main>
@endsection

@push('styles')
<style type="text/css">
  .steps-light .step-item.active .step-count, .steps-light .step-item.active .step-progress{
    background-color: #027e09;
  }
</style>
@endpush