@extends('layouts.shop')
@section('content')
  <div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
      <!-- List of items-->
      <section class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-4 pb-sm-5 mt-1">
          <h2 class="h6 text-light mb-0">Products</h2><a class="btn btn-primary btn-sm ps-2" href="{{route('all-products')}}"><i class="ci-arrow-left me-2"></i>Continue shopping</a>
        </div>
        <!-- Item-->
        @include('inc.session-message')
        <form action="{{ route('cart') }}" method="post" id="cart-quantity-form">
        @csrf
        @foreach( getCartProducts() as $key => $product )
        <div class="d-sm-flex justify-content-between align-items-center my-2 pb-3 border-bottom calc-amount">
          <div class="d-block d-sm-flex align-items-center text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto me-sm-4" href="{{route('single', $product->id)}}"><img src="{{ asset('product_images').'/'.$product->image }}" width="160" alt="Product"></a>
            <div class="pt-2">
              <h3 class="product-title fs-base mb-2"><a href="{{route('single', $product->id)}}">{{ucwords($product->name)}}</a></h3>
              @if(getCartProductAttributes($product->id))
              @foreach( getCartProductAttributes($product->id) as $a => $v )
              <div class="fs-sm"><span class="text-muted me-2">{{ucwords($a)}}:</span>{{ucwords($v)}}</div>
              @endforeach
              @endif
              <div class="fs-lg text-accent pt-2 ">₹<span class="product-price">{{ucwords($product->offer_price)}}</span></div>
            </div>
          </div>
          <div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-start" style="max-width: 9rem;">
            <label class="form-label" for="quantity1">Quantity</label>
            <input class="form-control" type="number" oninput="calculateSubtotal()" min="1" max="5" value="{{getCartProductQuantity($product->id)}}" name="quantity[{{$key}}]" />
            <a class="btn btn-link px-0 text-danger" href="{{ route('delete-cart-product', $product->id) }}" onclick="return confirm('Are you sure to remove this product?')"><i class="ci-close-circle me-2"></i><span class="fs-sm">Remove</span></a>
          </div>
        </div>
        @endforeach
        </form>
        <!-- <button class="btn btn-outline-accent d-block w-100 mt-4" type="button"><i class="ci-loading fs-base me-2"></i>Update cart</button> -->
      </section>
      <!-- Sidebar-->
      <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
        <div class="bg-white rounded-3 shadow-lg p-4">
          <div class="py-2 px-xl-2">
            <div class="text-center mb-4 pb-3 border-bottom">
              <h2 class="h6 mb-3 pb-1">Subtotal</h2>
              <h3 class="fw-normal">₹<span id="sub-total">{{ getCartSubTotal() }}</span></h3>
            </div>
            <!-- <div class="mb-3 mb-4">
              <label class="form-label mb-3" for="order-comments"><span class="badge bg-info fs-xs me-2">Note</span><span class="fw-medium">Additional comments</span></label>
              <textarea class="form-control" rows="6" id="order-comments"></textarea>
            </div> -->
            <!-- <div class="accordion" id="order-options">
              <div class="accordion-item">
                <h3 class="accordion-header"><a class="accordion-button" href="#promo-code" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="promo-code">Apply promo code</a></h3>
                <div class="accordion-collapse collapse show" id="promo-code" data-bs-parent="#order-options">
                  <form class="accordion-body needs-validation" method="post" novalidate>
                    <div class="mb-3">
                      <input class="form-control" type="text" placeholder="Promo code" required>
                      <div class="invalid-feedback">Please provide promo code.</div>
                    </div>
                    <button class="btn btn-outline-primary d-block w-100" type="submit">Apply promo code</button>
                  </form>
                </div>
              </div>
              <div class="accordion-item">
                <h3 class="accordion-header"><a class="accordion-button collapsed" href="#shipping-estimates" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="shipping-estimates">Shipping estimates</a></h3>
                <div class="accordion-collapse collapse" id="shipping-estimates" data-bs-parent="#order-options">
                  <div class="accordion-body">
                    <form class="needs-validation" novalidate>
                      <div class="mb-3">
                        <select class="form-select" required>
                          <option value="">Choose your country</option>
                          <option value="Australia">Australia</option>
                          <option value="Belgium">Belgium</option>
                          <option value="Canada">Canada</option>
                          <option value="Finland">Finland</option>
                          <option value="Mexico">Mexico</option>
                          <option value="New Zealand">New Zealand</option>
                          <option value="Switzerland">Switzerland</option>
                          <option value="United States">United States</option>
                        </select>
                        <div class="invalid-feedback">Please choose your country!</div>
                      </div>
                      <div class="mb-3">
                        <select class="form-select" required>
                          <option value="">Choose your city</option>
                          <option value="Bern">Bern</option>
                          <option value="Brussels">Brussels</option>
                          <option value="Canberra">Canberra</option>
                          <option value="Helsinki">Helsinki</option>
                          <option value="Mexico City">Mexico City</option>
                          <option value="Ottawa">Ottawa</option>
                          <option value="Washington D.C.">Washington D.C.</option>
                          <option value="Wellington">Wellington</option>
                        </select>
                        <div class="invalid-feedback">Please choose your city!</div>
                      </div>
                      <div class="mb-3">
                        <input class="form-control" type="text" placeholder="ZIP / Postal code" required>
                        <div class="invalid-feedback">Please provide a valid zip!</div>
                      </div>
                      <button class="btn btn-outline-primary d-block w-100" type="submit">Calculate shipping</button>
                    </form>
                  </div>
                </div>
              </div>
            </div> -->
            <button class="btn btn-primary btn-shadow d-block w-100 mt-4" type="button" onclick="jQuery('#cart-quantity-form').submit();"><i class="ci-card fs-lg me-2"></i>Proceed to Checkout</button>
          </div>
        </div>
      </aside>
    </div>
  </div>
</main>
@endsection

@push('scripts')
  <script type="text/javascript">
    function calculateSubtotal(){
      var anchors = document.getElementsByClassName('calc-amount');
      var subtotal=0;
      for(var i = 0; i < anchors.length; i++) {
          var anchor = anchors[i];
          // Get product price
          var price=anchor.querySelector('span.product-price').innerHTML;
          // Get quantity
          var quantity=anchor.querySelector('input').value;
          // Adding product price to subtotal
          subtotal+=price*quantity;
      }
      // set the subtotal to element
      document.getElementById('sub-total').innerHTML=subtotal;   
    }
  </script>
@endpush