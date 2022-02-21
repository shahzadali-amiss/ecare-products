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
          <a class="step-item active" href="{{route('cart')}}">
            <div class="step-progress">
              <span class="step-count">1</span>
            </div>
            <div class="step-label">
              <i class="ci-cart"></i>Cart
            </div>
          </a>
          <a class="step-item active current" href="{{route('checkout-details')}}">
            <div class="step-progress">
              <span class="step-count">2</span>
            </div>
            <div class="step-label">
              <i class="ci-user-circle"></i>Shipping Details
            </div>
          </a>
          <a class="step-item" href="#">
            <div class="step-progress">
              <span class="step-count">3</span>
            </div>
            <div class="step-label">
              <i class="ci-check-circle"></i>Order Review
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
        <!-- Autor info-->
        <!-- <div class="d-sm-flex justify-content-between align-items-center bg-secondary p-4 rounded-3 mb-grid-gutter">
          <div class="d-flex align-items-center">
            <div class="img-thumbnail rounded-circle position-relative flex-shrink-0"><span class="badge bg-warning position-absolute end-0 mt-n2" data-bs-toggle="tooltip" title="Reward points">384</span><img class="rounded-circle" src="{{asset('img/shop/account/avatar.jpg')}}" width="90" alt="Susan Gardner"></div>
            <div class="ps-3">
              <h3 class="fs-base mb-0">Susan Gardner</h3><span class="text-accent fs-sm">s.gardner@example.com</span>
            </div>
          </div><a class="btn btn-light btn-sm btn-shadow mt-3 mt-sm-0" href="account-profile.html"><i class="ci-edit me-2"></i>Edit profile</a>
        </div> -->
        <!-- Shipping address-->
        @include('inc.session-message')
        <form action="{{ route('checkout-details') }}" method="post" id="address-form">
          @csrf
        <input type="hidden" name="is_update" value="{{ isset($address) ? $address->id : '' }}">
        <h2 class="h6 pt-1 pb-3 mb-3 border-bottom">Reciever's Details</h2>
        <div class="row">
          <div class="col-sm-6">
            <div class="mb-3">
              <label class="form-label" for="checkout-fn">Name</label>
              <input class="form-control" type="text" id="checkout-fn" name="name" value="{{ucwords( isset($address) ? $address->name : Session::get('customer.name'))}}" required>
            </div>
          </div>
          <!-- <div class="col-sm-6">
            <div class="mb-3">
              <label class="form-label" for="checkout-ln">Last Name</label>
              <input class="form-control" type="text" id="checkout-ln">
            </div>
          </div> -->
          <div class="col-sm-6">
            <div class="mb-3">
              <label class="form-label" for="checkout-email">E-mail Address</label>
              <input class="form-control" type="email" id="checkout-email" name="email" value="@if( isset($address) && Session::has('customer.email')){{$address->email}}@elseif(!isset($address) && Session::has('customer.email')){{Session::get('customer.email')}}@elseif(isset($address) && !Session::has('customer.email')){{$address->email}}@endif" required>
            </div>
          </div>
        </div>
        <!-- <div class="row">
          <div class="col-sm-6">
            <div class="mb-3">
              <label class="form-label" for="checkout-company">Company</label>
              <input class="form-control" type="text" id="checkout-company">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="mb-3">
              <label class="form-label" for="checkout-country">Country</label>
              <select class="form-select" id="checkout-country">
                <option>Choose country</option>
                <option>Australia</option>
                <option>Canada</option>
                <option>France</option>
                <option>Germany</option>
                <option>Switzerland</option>
                <option>USA</option>
              </select>
            </div>
          </div>
        </div> -->
        <div class="row">
          <div class="col-sm-6">
            <div class="mb-3">
              <label class="form-label" for="checkout-phone">Mobile Number</label>
              <input class="form-control" type="text" id="checkout-phone" name="mobile" value="{{ isset($address) ? $address->mobile : Session::get('customer.mobile') }}" required>
            </div>
          </div>
        </div>

        <h2 class="h6 py-3 pt-4 mb-3 border-bottom">Shipping address</h2>

        <div class="row">
          <div class="col-sm-6">
            <div class="mb-3">
              <label class="form-label" for="checkout-state">State</label>
              <select class="form-select" id="checkout-state" name="state" required="">
                <option value="">Select state</option>
                @foreach($states as $state)
                <option value="{{$state->id}}" @if(isset($address)){{ $address->state==$state->id ? 'selected' : '' }}@endif>{{ucwords($state->name)}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="mb-3">
              <label class="form-label" for="checkout-city">City</label>
              <select class="form-select" id="checkout-city" name="city" required="">
                <option value="">Select city</option>
                @if(isset($address))
                  <option value="{{$address->city}}" selected>{{ucwords(getCityName($address->city))}}</option>
                @endif
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="mb-3">
              <label class="form-label" for="house">House No. / Street Name / Locality</label>
              <input class="form-control" type="text" id="house" name="house" value="{{ isset($address) ? $address->house : '' }}">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="mb-3">
              <label class="form-label" for="area">Village / Town / Area</label>
              <input class="form-control" type="text" id="area" name="area" value="{{ isset($address) ? $address->area : '' }}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="mb-3">
              <label class="form-label" for="checkout-landmark">Landmark</label>
              <input class="form-control" type="text" id="checkout-landmark" name="landmark" value="{{ isset($address) ? $address->landmark : '' }}">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="mb-3">
              <label class="form-label" for="checkout-zip">ZIP Code</label>
              <input class="form-control" type="text" maxlength="6" id="checkout-zip" name="zipcode" value="{{ isset($address) ? $address->pincode : '' }}">
            </div>
          </div>
        </div>
        </form>
        <!-- <h6 class="mb-3 py-3 border-bottom">Billing address</h6>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" checked id="same-address">
          <label class="form-check-label" for="same-address">Same as shipping address</label>
        </div> -->
        <!-- Navigation (desktop)-->
        <div class="d-none d-lg-flex pt-4 mt-3">
          <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{route('cart')}}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Back to Cart</span><span class="d-inline d-sm-none">Back</span></a></div>
          <div class="w-50 ps-2"><button class="btn btn-primary d-block w-100" onclick="jQuery('#address-form').submit();"><span class="d-none d-sm-inline">Proceed to Order Review</span><span class="d-inline d-sm-none">Next</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></button></div>
        </div>
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
          <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{route('home',['shop','cart'])}}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Back to Cart</span><span class="d-inline d-sm-none">Back</span></a></div>
          <div class="w-50 ps-2"><button class="btn btn-primary d-block w-100" onclick="jQuery('#address-form').submit();"><span class="d-none d-sm-inline">Proceed to Order Review</span><span class="d-inline d-sm-none">Next</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></button></div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

@push('scripts')
  <script type="text/javascript">
  jQuery(document).ready(function($){
    $('#checkout-state').on('change', function(){
      if($(this).val() != ""){
        var url = '/api/get-cities-from-state/'+($(this).val());
        $.get(url, function(data, status){
          if(data.status==true){
            
            //console.log(data.data);
            bindParentCategory(data.data,'checkout-city');
          }    
        });
      }
    });

    function bindParentCategory(data, element){  
      var sel=document.getElementById(element);
      sel.innerText = "";
      var opt = document.createElement('option');
      opt.innerHTML = 'Select city';
      opt.value = "";
      // opt.setAttribute('data-display', 'Please Select');
      sel.appendChild(opt);

          //console.log(data.length);
      // ITERATE TO BIND OPTIONS
      for(var i = 0; i < data.length; i++) {
          var opt = document.createElement('option');
          opt.innerHTML = data[i].city;
          opt.value = data[i].id;
          sel.appendChild(opt);
      }
    }
  });
  </script>
@endpush