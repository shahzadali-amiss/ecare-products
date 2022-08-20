  <div class="navbar-sticky header-bg">
  <div class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand d-none d-md-block me-3 flex-shrink-0" href="{{route('guest-home')}}">
        <img src="{{asset('img/logo-dark.png')}}" width="142" alt="AtaaHai">
      </a>
      <a class="navbar-brand d-md-none me-2" href="{{route('guest-home')}}">
        <img src="{{asset('img/logo-dark.png')}}" width="120" alt="AtaaHai">
      </a>
      <!-- Search-->
      <div class="input-group d-none d-lg-flex flex-nowrap mx-4"><i class="ci-search position-absolute top-50 start-0 translate-middle-y ms-3"></i>
        <input class="form-control rounded-start w-100" type="text" placeholder="Search for products">
        <select class="form-select flex-shrink-0" style="width: 11.5rem;">
          
          <option selected="">Select Category</option>
          
        </select>
      </div>
      <!-- Toolbar-->
      <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-tool navbar-stuck-toggler" href="#">
          <span class="navbar-tool-tooltip">Expand menu</span>
          <div class="navbar-tool-icon-box">
            <i class="navbar-tool-icon ci-menu"></i>
          </div>
        </a>
        @if(Session::has('customer'))
        <div class="navbar-tool dropdown ms-2">
          <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="{{route('home')}}">
            <i class="navbar-tool-icon ci-user"></i>
          </a>
          <a class="navbar-tool-text" href="#">
            <small>Hello, {{explode(' ',Session::get('customer.name'))[0]}}</small>
            My Account
          </a>
          <!-- Cart dropdown-->
          <div class="dropdown-menu dropdown-menu-end">
            <div class="widget widget-cart px-3 py-2" style="width: 13rem;">
              <div class="px-2 py-3 border-bottom">
                <div class="d-flex align-items-center">
                  <a href="{{ route('home') }}" class="text-dark"><i class="ci-user me-2 fs-base align-middle"></i>View Profile</a>
                </div>
              </div>
              <div class="px-2 py-3">
                <div class="d-flex align-items-center">
                  <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="text-dark logout-btn" type="submit">
                      <i class="ci-sign-out me-2 fs-base align-middle"></i>
                      Logout
                    </button>
                  </form>
                </div>
              </div>                        
            </div>
          </div>
        </div>
        <div class="navbar-tool {{ getCartQuantity()>0 ? 'dropdown ':''}}ms-2">
          <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="{{route('cart')}}">
            <span class="navbar-tool-label">{{ getCartQuantity() }}</span>
            <i class="navbar-tool-icon ci-cart"></i>
          </a>
          <a class="navbar-tool-text" href="{{route('cart')}}">
            <small>My Cart</small>
            ₹{{getCartSubTotal()}}
          </a>
          <!-- Cart dropdown-->
          @if(getCartQuantity()>0)
          <div class="dropdown-menu dropdown-menu-end">
            <div class="widget widget-cart px-3 pt-2 pb-3" style="width: 20rem;">
              <div style="height: 15rem;" data-simplebar data-simplebar-auto-hide="false">
                
                @foreach( getCartProducts() as $product )
                <div class="widget-cart-item py-2 border-bottom">
                  <a class="btn-close text-danger" href="{{ route('delete-cart-product', $product->id) }}" onclick="return confirm('Are you sure to remove this product?')" aria-label="Remove"><span aria-hidden="true">&times;</span></a>
                  <div class="d-flex align-items-center"><a class="d-block flex-shrink-0" href="{{route('single', $product->id)}}"><img src="{{ asset('product_images').'/'.$product->image }}" width="64" alt="Product"></a>
                    <div class="ps-2">
                      <h6 class="widget-product-title"><a href="{{route('single', $product->id)}}">{{ucwords($product->name)}}</a></h6>
                      <div class="widget-product-meta"><span class="text-accent me-2">₹{{ucwords($product->offer_price)}}</span><span class="text-muted">x {{getCartProductQuantity($product->id)}}</span></div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
                <div class="fs-sm me-2 py-2"><span class="text-muted">Subtotal:</span><span class="text-accent fs-base ms-1">₹{{getCartSubTotal()}}</span></div><a class="btn btn-outline-secondary btn-sm" href="shop-cart.php">Expand cart<i class="ci-arrow-right ms-1 me-n1"></i></a>
              </div><a class="btn btn-primary btn-sm d-block w-100" href="{{route('checkout-details')}}"><i class="ci-card me-2 fs-base align-middle"></i>Checkout</a>
            </div>
          </div>
          @endif
        </div>
        @else
        <div class="navbar-tool ms-2">
          <a class="navbar-tool-icon-box bg-secondary" href="{{route('customer_login')}}">
            <i class="navbar-sign-in ci-sign-in"></i>
          </a>
          <a class="navbar-tool-text" href="{{route('customer_login')}}">
            Login
          </a>
        </div>
        <div class="navbar-tool ms-2">
          <a class="navbar-tool-icon-box bg-secondary" href="{{route('customer_register')}}">
            <i class="navbar-tool-icon ci-add-user"></i>
          </a>
          <a class="navbar-tool-text" href="{{route('customer_register')}}">
            Register
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>
  <div class="navbar navbar-expand-lg navbar-light navbar-stuck-menu mt-n2 pt-0 pb-2">
    <div class="container">
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <!-- Search-->
        <div class="input-group d-lg-none my-3"><i class="ci-search position-absolute top-50 start-0 translate-middle-y ms-3"></i>
          <input class="form-control rounded-start" type="text" placeholder="Search for products">
        </div>
        <!-- Primary menu-->
        <ul class="navbar-nav ps-md-2 ms-md-1">
          <li class="nav-item active"><a class="nav-link" href="{{route('welcome')}}">Home</a>
          </li>
          <li class="nav-item"><a class="nav-link" href="{{ route('all-products') }}">New Arrivals</a>
          </li>
          <li class="nav-item"><a class="nav-link" href="{{ route('all-products') }}">Best Sellers</a>
          </li>
          <li class="nav-item"><a class="nav-link" href="{{ route('all-products') }}">Exclusive Offers</a>
          </li>
          
        </ul>
        <div class="col py-md-2 text-end"><a class="btn btn-primary btn-shadow rounded-pill" href="{{ route('get-supplier-mobile') }}">Become a Supplier</a></div>
      </div>
    </div>
  </div>
</div>