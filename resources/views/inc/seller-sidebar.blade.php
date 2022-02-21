<aside class="col-lg-4 pe-xl-5">
  <!-- Account menu toggler (hidden on screens larger 992px)-->
  <div class="d-block d-lg-none p-4">
    <a class="btn btn-outline-accent d-block" href="#account-menu" data-bs-toggle="collapse"><i class="ci-menu me-2"></i>Account menu</a>
  </div>
  <!-- Actual menu-->
  <div class="h-100 border-end mb-2">
    <div class="d-lg-block collapse" id="account-menu">
      <div class="bg-secondary p-4">
        <h3 class="fs-sm mb-0 text-muted">Seller Dashboard</h3>
      </div>
      <ul class="list-unstyled mb-0">
        <li class="border-bottom mb-0">
          <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('seller-home') }}"><i class="ci-rupee opacity-60 me-2"></i>Dashboard<span class="fs-sm text-muted ms-auto">₹9,156</span></a>
        </li>
        <li class="border-bottom mb-0">
          <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{route('supplier_products')}}"><i class="ci-package opacity-60 me-2"></i>Products<span class="fs-sm text-muted ms-auto">{{count(getSupplierProducts())}}</span></a>
        </li>
        <li class="border-bottom mb-0">
          <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('seller-upload-type') }}"><i class="ci-cloud-upload opacity-60 me-2"></i>Add New Product</a>
        </li>
        <!-- <li class="border-bottom mb-0">
          <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('seller-payouts') }}"><i class="ci-currency-exchange opacity-60 me-2"></i>Payouts</a>
        </li> -->
        <li class="border-bottom mb-0 ">
          <a class="nav-link-style d-flex align-items-center px-4 py-3 dropdown-btn" type="button" ><i class="ci-basket-alt opacity-60 me-2"></i>Orders<i class="fa fa-caret-down"></i><i class="fa fa-caret-up"></i></a>
          <ul class="dropdown-container">
            <li class="border-bottom mb-0">
              <a class="nav-link-style d-flex align-items-center py-3" href="{{ route('seller-orders','p') }}">Pending<span class="fs-sm text-muted ms-auto me-3">{{getSupplierOrdersQuantity('pending')}}</span></a>
            </li>
            <li class="border-bottom mb-0">
              <a class="nav-link-style d-flex align-items-center py-3" href="{{ route('seller-orders','c') }}">Completed<span class="fs-sm text-muted ms-auto me-3">{{getSupplierOrdersQuantity('delivered')}}</span></a>
            </li>
          </ul>
        </li>

        
      </ul>
      <div class="bg-secondary p-4">
        <h3 class="fs-sm mb-0 text-muted">Account</h3>
      </div>
      <ul class="list-unstyled mb-0">
        <li class="border-bottom mb-0">
          <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('seller-account') }}"><i class="ci-user opacity-60 me-2"></i>My Account</a><!-----------add active class to anchor tag to make it active------------>
        </li>
        {{--<li class="border-bottom mb-0">
          <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('seller-settings') }}"><i class="ci-settings opacity-60 me-2"></i>Settings</a><!-----------add active class to anchor tag to make it active------------>
        </li>--}}
        <!-- <li class="border-bottom mb-0">
          <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('seller-purchases') }}"><i class="ci-basket opacity-60 me-2"></i>Purchases</a>
        </li>
        <li class="mb-0">
          <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('seller-favorites') }}"><i class="ci-heart opacity-60 me-2"></i>Favorites<span class="fs-sm text-muted ms-auto">4</span></a>
        </li> -->
        <li class="mb-0">
          <div class="nav-link-style d-flex align-items-center px-4 py-3" onclick="jQuery('#logout-form').submit();"><i class="ci-sign-out opacity-60 me-2"></i>Sign out</div>
        </li>
      </ul>
      <form action="{{route('seller_logout')}}" method="post" id="logout-form">
        @csrf
      </form>
      <hr>
    </div>
  </div>
</aside>

