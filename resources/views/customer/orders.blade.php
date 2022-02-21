@extends('layouts.user')
@section('content')
<!-- Content  -->
<section class="col-lg-8">
  <!-- Toolbar-->
  <div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">
    <!-- <div class="d-flex align-items-center">
      <label class="d-none d-lg-block fs-sm text-light text-nowrap opacity-75 me-2" for="order-sort">Sort orders:</label>
      <label class="d-lg-none fs-sm text-nowrap opacity-75 me-2" for="order-sort">Sort orders:</label>
      <select class="form-select" id="order-sort">
        <option>All</option>
        <option>Delivered</option>
        <option>In Progress</option>
        <option>Delayed</option>
        <option>Canceled</option>
      </select>
    </div> -->

    <a class="btn btn-primary btn-sm d-none d-lg-inline-block" href="{{ route('logout') }}"><i class="ci-sign-out me-2"></i>Sign out</a>
  </div>
  <!-- Orders list-->
  <div class="table-responsive fs-md mb-4">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Image</th>
          <th>Order #</th>
          <th>Date Purchased</th>
          <th>Status</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach(getOrders() as $order)
        <tr>
          <td>
            <!-- <a href="#order-details" data-bs-toggle="modal"> --><img src="{{ asset('product_images') }}/{{ getProduct($order->product_id)->image }}" width="55px"><!-- </a> -->
          </td>
          <td class="py-4"><!-- <a class="nav-link-style fw-medium fs-sm" href="#order-details" data-bs-toggle="modal"> -->{{$order->order_id}}<!-- </a> --></td>
          <td class="py-4">{{date('M d, Y',strtotime($order->order_time))}}</td>
          <td class="py-4">
            @if($order->status=='pending')
            <span class="badge bg-info m-0">In Progress</span>
            @elseif($order->status=='hold')
            <span class="badge bg-warning m-0">Hold</span>
            @else
            <span class="badge bg-success m-0">Completed</span>
            @endif
          </td>
          <td class="py-4">{{ $order->quantity*$order->final_price }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center mt-4">
        @if(!empty(getOrders()))
        {!! getOrders()->links() !!}
        @endif
    </div>            
  </div>
 <div class="modal fade" id="order-details">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Order No - 34VB5540K83</h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-0">
              <!-- Item-->
              <div class="d-sm-flex justify-content-between mb-4 pb-3 pb-sm-2 border-bottom">
                <div class="d-sm-flex text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto" href="shop-single-v1.html" style="width: 10rem;"><img src="img/shop/cart/01.jpg" alt="Product"></a>
                  <div class="ps-sm-4 pt-2">
                    <h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">Women Colorblock Sneakers</a></h3>
                    <div class="fs-sm"><span class="text-muted me-2">Size:</span>8.5</div>
                    <div class="fs-sm"><span class="text-muted me-2">Color:</span>White &amp; Blue</div>
                    <div class="fs-lg text-accent pt-2">$154.<small>00</small></div>
                  </div>
                </div>
                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                  <div class="text-muted mb-2">Quantity:</div>1
                </div>
                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                  <div class="text-muted mb-2">Subtotal</div>$154.<small>00</small>
                </div>
              </div>
              <!-- Item-->
              <div class="d-sm-flex justify-content-between my-4 pb-3 pb-sm-2 border-bottom">
                <div class="d-sm-flex text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto" href="shop-single-v1.html" style="width: 10rem;"><img src="img/shop/cart/02.jpg" alt="Product"></a>
                  <div class="ps-sm-4 pt-2">
                    <h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">TH Jeans City Backpack</a></h3>
                    <div class="fs-sm"><span class="text-muted me-2">Brand:</span>Tommy Hilfiger</div>
                    <div class="fs-sm"><span class="text-muted me-2">Color:</span>Khaki</div>
                    <div class="fs-lg text-accent pt-2">$79.<small>50</small></div>
                  </div>
                </div>
                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                  <div class="text-muted mb-2">Quantity:</div>1
                </div>
                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                  <div class="text-muted mb-2">Subtotal</div>$79.<small>50</small>
                </div>
              </div>
              <!-- Item-->
              <div class="d-sm-flex justify-content-between my-4 pb-3 pb-sm-2 border-bottom">
                <div class="d-sm-flex text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto" href="shop-single-v1.html" style="width: 10rem;"><img src="img/shop/cart/03.jpg" alt="Product"></a>
                  <div class="ps-sm-4 pt-2">
                    <h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">3-Color Sun Stash Hat</a></h3>
                    <div class="fs-sm"><span class="text-muted me-2">Brand:</span>The North Face</div>
                    <div class="fs-sm"><span class="text-muted me-2">Color:</span>Pink / Beige / Dark blue</div>
                    <div class="fs-lg text-accent pt-2">$22.<small>50</small></div>
                  </div>
                </div>
                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                  <div class="text-muted mb-2">Quantity:</div>1
                </div>
                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                  <div class="text-muted mb-2">Subtotal</div>$22.<small>50</small>
                </div>
              </div>
              <!-- Item-->
              <div class="d-sm-flex justify-content-between my-4">
                <div class="d-sm-flex text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto" href="shop-single-v1.html" style="width: 10rem;"><img src="img/shop/cart/04.jpg" alt="Product"></a>
                  <div class="ps-sm-4 pt-2">
                    <h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">Cotton Polo Regular Fit</a></h3>
                    <div class="fs-sm"><span class="text-muted me-2">Size:</span>42</div>
                    <div class="fs-sm"><span class="text-muted me-2">Color:</span>Light blue</div>
                    <div class="fs-lg text-accent pt-2">$9.<small>00</small></div>
                  </div>
                </div>
                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                  <div class="text-muted mb-2">Quantity:</div>1
                </div>
                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                  <div class="text-muted mb-2">Subtotal</div>$9.<small>00</small>
                </div>
              </div>
            </div>
            <!-- Footer-->
            <div class="modal-footer flex-wrap justify-content-between bg-secondary fs-md">
              <div class="px-2 py-1"><span class="text-muted">Subtotal:&nbsp;</span><span>$265.<small>00</small></span></div>
              <div class="px-2 py-1"><span class="text-muted">Shipping:&nbsp;</span><span>$22.<small>50</small></span></div>
              <div class="px-2 py-1"><span class="text-muted">Tax:&nbsp;</span><span>$9.<small>50</small></span></div>
              <div class="px-2 py-1"><span class="text-muted">Total:&nbsp;</span><span class="fs-lg">$297.<small>00</small></span></div>
            </div>
          </div>
        </div>
      </div>
</section>
@endsection

@push('styles')
<style type="text/css">
  .table-hover>tbody>tr:hover{
    --bs-table-accent-bg: none;
    box-shadow: 1px 0px 10px rgba(0,0,0,0.2);
  }
</style>
@endpush