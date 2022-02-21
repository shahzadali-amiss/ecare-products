<div class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand d-none d-sm-block flex-shrink-0 me-4 order-lg-1" href="{{ route('guest-home') }}">
      <h1>MAHIR BHARAT</h1>
      <!-- <img src="{{asset('img/logo-dark.png')}}" width="142" alt="Cartzilla"> -->
    </a>
    <a class="navbar-brand d-sm-none me-2 order-lg-1" href="{{ route('guest-home') }}">
      <!-- <img src="{{asset('img/logo-dark.png')}}" width="74"> -->
      <h1>MAHIR BHARAT</h1>
    </a>
    <!-- Toolbar-->
    <div class="navbar-toolbar d-flex align-items-center order-lg-3">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-tool d-none d-lg-flex" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#searchBox" role="button" aria-expanded="false" aria-controls="searchBox">
        <span class="navbar-tool-tooltip">Search</span>
        <div class="navbar-tool-icon-box">
          <i class="navbar-tool-icon ci-search"></i>
        </div>
      </a>
      @if(Session::has('supplier'))
      <!-- <a class="navbar-tool d-none d-lg-flex" href="dashboard-favorites.html">
        <span class="navbar-tool-tooltip">Favorites</span>
        <div class="navbar-tool-icon-box">
          <i class="navbar-tool-icon ci-heart"></i>
        </div>
      </a> -->
      @php
      $supplier_details=getSupplierDetails();
      @endphp
      <div class="navbar-tool dropdown ms-2">
        <a class="navbar-tool-icon-box border dropdown-toggle" href="#" style="overflow: hidden;">
          <img src="{{ asset('supplier_images') }}/{{ $supplier_details ? $supplier_details->image : 'default.jpg' }}" width="50px" alt="@if(is_null(Session::get('supplier.name')))
            {{ explode('@',Session::get('supplier.email'))[0] }}
          @else
            {{ucwords(Session::get('supplier.name'))}}
          @endif">
        </a>
        <a class="navbar-tool-text ms-n1" href="dashboard-sales.html">
          <small>
          @if(is_null(Session::get('supplier.name')))
            {{ explode('@',Session::get('supplier.email'))[0] }}
          @else
            {{ucwords(Session::get('supplier.name'))}}
          @endif
          </small>₹9,156
        </a>
        <div class="dropdown-menu dropdown-menu-end"> 
          <div style="min-width: 14rem;">
            <h6 class="dropdown-header">Account</h6>
            <!-- <a class="dropdown-item d-flex align-items-center" href="settings.php">
              <i class="ci-settings opacity-60 me-2"></i>Settings
            </a> -->
            <a class="dropdown-item d-flex align-items-center" href="{{ route('seller-account') }}">
              <i class="ci-user opacity-60 me-2"></i>My Account
            </a>
            <!-- <a class="dropdown-item d-flex align-items-center" href="dashboard-purchases.html">
              <i class="ci-basket opacity-60 me-2"></i>Purchases
            </a>
            <a class="dropdown-item d-flex align-items-center" href="favorites.php">
              <i class="ci-heart opacity-60 me-2"></i>Favorites
              <span class="fs-xs text-muted ms-auto">4</span>
            </a> -->
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Seller Dashboard</h6>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('seller-home') }}">
              <i class="ci-dollar opacity-60 me-2"></i>Dashboard
              <span class="fs-xs text-muted ms-auto">₹9,156</span>
            </a>
            <a class="dropdown-item d-flex align-items-center" href="{{route('supplier_products')}}">
              <i class="ci-package opacity-60 me-2"></i>Products
              <span class="fs-xs text-muted ms-auto">{{count(getSupplierProducts())}}</span>
            </a>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('seller-upload-type') }}">
              <i class="ci-cloud-upload opacity-60 me-2"></i>Add New Product
            </a>
            <!-- <a class="dropdown-item d-flex align-items-center" href="payouts.php">
              <i class="ci-currency-exchange opacity-60 me-2"></i>Payouts
            </a> -->
            <div class="dropdown-divider"></div>
            <form action="{{ route('seller_logout') }}" method="post">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center">
                <i class="ci-sign-out opacity-60 me-2"></i>Sign Out
              </button>
            </form>
          </div>
        </div>
      </div>
      <!-- <div class="navbar-tool ms-4">
        <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="../shop-cart.php">
          <span class="navbar-tool-label">3</span>
          <i class="navbar-tool-icon ci-cart"></i>
        </a>
      </div> -->
      @endif
    </div>
    <div class="collapse navbar-collapse me-auto order-lg-2" id="navbarCollapse">
      <!-- Search-->
      <div class="input-group d-lg-none my-3">
        <i class="ci-search position-absolute top-50 start-0 translate-middle-y text-muted fs-base ms-3"></i>
        <input class="form-control rounded-start" type="text" placeholder="Search marketplace">
      </div>
      <!-- Categories dropdown-->
      <!-- <ul class="navbar-nav navbar-mega-nav pe-lg-2 me-lg-2">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle ps-lg-0" href="#" data-bs-toggle="dropdown">
            <i class="ci-menu align-middle mt-n1 me-2"></i>Categories
          </a>
          <ul class="dropdown-menu py-1">
            <li class="dropdown">
              <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Photos</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item product-title fw-medium">
                  <a href="marketplace-category.html">All Photos
                    <i class="ci-arrow-right fs-xs ms-1"></i>
                  </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Abstract</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Animals</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Architecture</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Beauty &amp; Fashion</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Business</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Education</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Food &amp; Drink</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Holidays</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Industrial</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">People</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Sports</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Technology</a>
                </li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Graphics</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item product-title fw-medium">
                  <a href="#">All Graphics
                    <i class="ci-arrow-right fs-xs ms-1"></i>
                  </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Icons</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Illustartions</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Patterns</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Textures</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Web Elements</a>
                </li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">UI Design</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item product-title fw-medium">
                  <a href="marketplace-category.html">All UI Design
                    <i class="ci-arrow-right fs-xs ms-1"></i>
                  </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">PSD Templates</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Sketch Templates</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Adobe XD Templates</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Figma Templates</a>
                </li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Web Themes</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item product-title fw-medium">
                  <a href="marketplace-category.html">All Web Themes
                    <i class="ci-arrow-right fs-xs ms-1"></i>
                  </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">WordPress Themes</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Bootstrap Themes</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">eCommerce Templates</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Muse Templates</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Plugins</a>
                </li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Fonts</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item product-title fw-medium">
                  <a href="marketplace-category.html">All Fonts
                    <i class="ci-arrow-right fs-xs ms-1"></i>
                  </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Blackletter</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Display</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Non Western</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Sans Serif</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Script</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Serif</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Slab Serif</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Symbols</a>
                </li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Add-Ons</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item product-title fw-medium">
                  <a href="marketplace-category.html">All Add-Ons
                    <i class="ci-arrow-right fs-xs ms-1"></i>
                  </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Photoshop Add-Ons</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Illustrator Add-Ons</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Sketch Plugins</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Procreate Brushes</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">InDesign Palettes</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Lightroom Presets</a>
                </li>
                <li>
                  <a class="dropdown-item" href="marketplace-category.html">Other Software</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul> -->
      <!-- Primary menu-->
      <!-- <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.html">Back to main demo</a>
        </li>
      </ul> -->
    </div>
  </div>
</div>
<!-- Search collapse-->
<div class="search-box collapse" id="searchBox">
  <div class="card pt-2 pb-4 border-0 rounded-0">
    <div class="container">
      <div class="input-group">
        <i class="ci-search position-absolute top-50 start-0 translate-middle-y text-muted fs-base ms-3"></i>
        <input class="form-control rounded-start" type="text" placeholder="Search marketplace">
      </div>
    </div>
  </div>
</div>