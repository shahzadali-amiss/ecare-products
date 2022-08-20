@extends('layouts.common')
@section('content')
  <div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
      <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
            <li class="breadcrumb-item"><a class="text-nowrap" href="index.html"><i class="ci-home"></i>Home</a></li>
            <li class="breadcrumb-item text-nowrap"><a href="shop-grid-ls.html">Shop</a>
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
          <a class="step-item active" href="{{route('checkout')}}">
            <div class="step-progress">
              <span class="step-count">2</span>
            </div>
            <div class="step-label">
              <i class="ci-user-circle"></i>Shipping Details
            </div>
          </a>
          <a class="step-item active current" href="{{route('checkout-review')}}">
            <div class="step-progress">
              <span class="step-count">3</span>
            </div>
            <div class="step-label">
              <i class="ci-check-circle"></i>Review
            </div>
          </a>
          <a class="step-item" href="#">
            <div class="step-progress">
              <span class="step-count">4</span>
            </div>
            <div class="step-label">
              <i class="ci-card"></i>Payment
            </div>
          </a>
          <a class="step-item" href="#">
            <div class="step-progress">
              <span class="step-count">5</span>
            </div>
            <div class="step-label">
              <i class="ci-card"></i>Order Status
            </div>
          </a>
        </div>
        <!-- Order details-->
        <h2 class="h6 pt-1 pb-3 mb-3 border-bottom">Review your order</h2>
        <!-- Item-->
        @foreach( getCartProducts() as $product )
        <div class="d-sm-flex justify-content-between my-4 pb-3 border-bottom">
          <div class="d-sm-flex text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto me-sm-4" href="{{route('single', $product->id)}}"><img src="{{ asset('product_images').'/'.$product->image }}" width="160" alt="Product"></a>
            <div class="pt-2">
              <h3 class="product-title fs-base mb-2"><a href="{{route('single', $product->id)}}">{{ucwords($product->name)}}</a></h3>
              @if(getCartProductAttributes($product->id))
              @foreach(getCartProductAttributes($product->id) as $a => $v)
              <div class="fs-sm"><span class="text-muted me-2">{{ucwords($a)}}:</span>{{ucwords($v)}}</div>
              @endforeach
              @endif
              <div class="fs-lg text-accent pt-2">₹{{$product->offer_price*getCartProductQuantity($product->id)}}</div>
            </div>
          </div>
          <div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-end" style="max-width: 9rem;">
            <p class="mb-0"><span class="text-muted fs-sm">Quantity:</span><span>&nbsp;{{getCartProductQuantity($product->id)}}</span></p>
            <!-- <button class="btn btn-link px-0" type="button"><i class="ci-edit me-2"></i><span class="fs-sm">Edit</span></button> -->
          </div>
        </div>
        @endforeach
        
        <!-- Client details-->
        <div class="bg-secondary rounded-3 px-4 pt-4 pb-2">
          <div class="row">
            <div class="col-sm-12">
              <h4 class="h6">Shipping to:</h4>
              <ul class="list-unstyled fs-sm">
                <li><span class="text-muted">Customer:&nbsp;</span>{{ucwords(getShippingAddress(Session::get('customer.id'))->name)}}</li>
                <li><span class="text-muted">Address:&nbsp;</span>{{ucwords(getShippingAddress()->house)}}, {{ucwords(getShippingAddress()->area)}}, {{ucwords(getShippingAddress()->landmark)}}, {{ucwords(getCityName(getShippingAddress()->city))}}, {{ucwords(strtolower(getStateName(getShippingAddress()->state)))}} - {{ucwords(getShippingAddress()->pincode)}}</li>
                <li><span class="text-muted">Phone:&nbsp;</span>+91 {{getShippingAddress(Session::get('customer.id'))->mobile}}</li>
              </ul>
            </div>
          </div>
        </div>
        <!-- Navigation (desktop)-->
        <div class="d-none d-lg-flex pt-4">
          <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{route('checkout')}}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Back to Shipping Details</span><span class="d-inline d-sm-none">Back</span></a></div>
          <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{ route('checkout-payment') }}"><span class="d-none d-sm-inline">Select Payment Method</span><span class="d-inline d-sm-none">Complete</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
        </div>
      </section>
      <!-- Sidebar-->
      <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
        <div class="bg-white rounded-3 shadow-lg p-4 ms-lg-auto">
          <div class="py-2 px-xl-2">
            <h2 class="h6 text-center mb-4">Order summary</h2>
            <ul class="list-unstyled fs-sm pb-2 border-bottom">
              <li class="d-flex justify-content-between align-items-center"><span class="me-2">Subtotal:</span><span class="text-end">₹{{getCartSubTotal()}}</span></li>
              <li class="d-flex justify-content-between align-items-center"><span class="me-2">Shipping:</span><span class="text-end">—</span></li>
              <!-- <li class="d-flex justify-content-between align-items-center"><span class="me-2">Taxes:</span><span class="text-end">$9.<small>50</small></span></li>
              <li class="d-flex justify-content-between align-items-center"><span class="me-2">Discount:</span><span class="text-end">—</span></li> -->
            </ul>
            <h3 class="fw-normal text-center my-4">₹{{getCartSubTotal()}}</h3>
            <!-- <form class="needs-validation" method="post" novalidate>
              <div class="mb-3">
                <input class="form-control" type="text" placeholder="Promo code" required>
                <div class="invalid-feedback">Please provide promo code.</div>
              </div>
              <button class="btn btn-outline-primary d-block w-100" type="submit">Apply promo code</button>
            </form> -->
          </div>
        </div>
      </aside>
    </div>
    <!-- Navigation (mobile)-->
    <div class="row d-lg-none">
      <div class="col-lg-8">
        <div class="d-flex pt-4 mt-3">
          <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('checkout') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Back to Shipping Details</span><span class="d-inline d-sm-none">Back</span></a></div>
          <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{ route('checkout-payment') }}"><span class="d-none d-sm-inline">Select Payment Method</span><span class="d-inline d-sm-none">Complete</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection