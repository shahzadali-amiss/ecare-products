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
          <a class="step-item active" href="{{route('checkout-details')}}">
            <div class="step-progress">
              <span class="step-count">2</span>
            </div>
            <div class="step-label">
              <i class="ci-user-circle"></i>Shipping Details
            </div>
          </a>
          <a class="step-item active" href="{{route('checkout-review')}}">
            <div class="step-progress">
              <span class="step-count">3</span>
            </div>
            <div class="step-label">
              <i class="ci-check-circle"></i>Review
            </div>
          </a>
          <a class="step-item active current" href="{{route('checkout-payment')}}">
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
        <!-- Payment methods accordion-->
        @include('inc.session-message')
        <h2 class="h3 pb-3 mb-2">Choose payment method</h2>
        <form action="{{ route('checkout-payment') }}" method="post" class="py-md-5" id="payment_form">
          @csrf
          <div class="px-md-5 pb-5">
            <div class="form-check">
              <input class="form-check-input" type="radio" id="ex-radio-1" value="online" name="payment_type" checked>
              <label class="h5" for="ex-radio-1">Online Payment</label>
              <p class="fs-sm">We accept following credit cards:&nbsp;&nbsp;<img class="d-inline-block align-middle" src="{{asset('img/cards.png')}}" width="187" alt="Cerdit Cards"></p>
            </div>
            <!-- <div class="form-check">
              <input class="form-check-input" type="radio" id="ex-radio-2" name="radio" checked>
              <label class="form-check-label" for="ex-radio-2">Toggle this radio</label>
            </div> -->
            <div class="form-check mt-4">
              <input class="form-check-input" type="radio" id="ex-radio-3" value="cash" name="payment_type" disabled>
              <label class="form-check-label" for="ex-radio-3">Cash on delivery</label>
            </div>
          </div>






          <!-- <div class="accordion mb-2" id="payment-method">
            <div class="accordion-item">
              <h3 class="accordion-header"><a class="accordion-button" href="#card" data-bs-toggle="collapse"><i class="ci-card fs-lg me-2 mt-n1 align-middle"></i>Pay with Credit Card</a></h3>
              <div class="accordion-collapse collapse show" id="card" data-bs-parent="#payment-method">
                <div class="accordion-body">
                  <p class="fs-sm">We accept following credit cards:&nbsp;&nbsp;<img class="d-inline-block align-middle" src="{{asset('img/cards.png')}}" width="187" alt="Cerdit Cards"></p>
                  <div class="credit-card-wrapper"></div>
                  <form class="credit-card-form row">
                    <div class="mb-3 col-sm-6">
                      <input class="form-control" type="text" name="number" placeholder="Card Number" required>
                    </div>
                    <div class="mb-3 col-sm-6">
                      <input class="form-control" type="text" name="name" placeholder="Full Name" required>
                    </div>
                    <div class="mb-3 col-sm-3">
                      <input class="form-control" type="text" name="expiry" placeholder="MM/YY" required>
                    </div>
                    <div class="mb-3 col-sm-3">
                      <input class="form-control" type="text" name="cvc" placeholder="CVC" required>
                    </div>
                    <div class="col-sm-6">
                      <button class="btn btn-outline-primary d-block w-100 mt-0" type="submit">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h3 class="accordion-header"><a class="accordion-button collapsed" href="#paypal" data-bs-toggle="collapse"><i class="ci-paypal me-2 align-middle"></i>Pay with PayPal</a></h3>
              <div class="accordion-collapse collapse" id="paypal" data-bs-parent="#payment-method">
                <div class="accordion-body fs-sm">
                  <p><span class='fw-medium'>PayPal</span> - the safer, easier way to pay</p>
                  <form class="row needs-validation" method="post" novalidate>
                    <div class="col-sm-6">
                      <div class="mb-3">
                        <input class="form-control" type="email" placeholder="E-mail" required>
                        <div class="invalid-feedback">Please enter valid email address</div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="mb-3">
                        <input class="form-control" type="password" placeholder="Password" required>
                        <div class="invalid-feedback">Please enter your password</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-flex flex-wrap justify-content-between align-items-center"><a class="nav-link-style" href="#">Forgot password?</a>
                        <button class="btn btn-primary" type="submit">Log In</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h3 class="accordion-header"><a class="accordion-button collapsed" href="#points" data-bs-toggle="collapse"><i class="ci-gift me-2"></i>Redeem Reward Points</a></h3>
              <div class="accordion-collapse collapse" id="points" data-bs-parent="#payment-method">
                <div class="accordion-body">
                  <p>You currently have<span class="fw-medium">&nbsp;384</span>&nbsp;Reward Points to spend.</p>
                  <div class="form-check d-block">
                    <input class="form-check-input" type="checkbox" id="use_points">
                    <label class="form-check-label" for="use_points">Use my Reward Points to pay for this order.</label>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <!-- Navigation (desktop)-->
          <div class="d-none d-lg-flex pt-4">
            <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{route('checkout-review')}}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Back to Review</span><span class="d-inline d-sm-none">Back</span></a></div>
            <div class="w-50 ps-2"><form class="d-block w-100" action="{{ route('checkout-payment') }}" method="post" id="payment_form">@csrf<button class="btn btn-primary w-100"><span class="d-none d-sm-inline">Complete Payment</span><span class="d-inline d-sm-none">Complete</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></button></form></div>
          </div>
        </form>
      </section>
      <!-- Sidebar-->
      <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
        <div class="bg-white rounded-3 shadow-lg p-4 ms-lg-auto">
          <div class="py-2 px-xl-2">
            <div class="widget mb-3">
              <h2 class="widget-title text-center">Order summary</h2>
              @foreach( getCartProducts() as $product )
              <div class="d-flex align-items-center pb-2 border-bottom"><a class="d-block flex-shrink-0" href="{{route('single', $product->id)}}"><img src="{{ asset('product_images').'/'.$product->image }}" width="64" alt="Product"></a>
                <div class="ps-2">
                  <h6 class="widget-product-title"><a href="{{route('single', $product->id)}}">{{ucwords($product->name)}}</a></h6>
                  <div class="widget-product-meta"><span class="text-accent me-2">₹{{ucwords($product->offer_price)}}</span><span class="text-muted">x {{getCartProductQuantity($product->id)}}</span></div>
                </div>
              </div>
              @endforeach
            </div>
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
          <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{route('checkout-review')}}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Back to Review</span><span class="d-inline d-sm-none">Back</span></a></div>
          <div class="w-50 ps-2"><button class="btn btn-primary d-block w-100" type="button" onclick="jQuery('#payment_form').submit();"><span class="d-none d-sm-inline">Complete your order</span><span class="d-inline d-sm-none">Complete order</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></button></div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

@push('styles')

@endpush