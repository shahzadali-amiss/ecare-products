@extends('layouts.seller') 
@section('content')

<!-- Content-->
<section class="col-lg-8 pt-lg-4 pb-4 mb-3">
  <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
    <!-- Title-->
    <div class="d-sm-flex flex-wrap justify-content-between align-items-center border-bottom">
      <h2 class="h3 py-2 me-2 text-center text-sm-start">Your products<span class="badge bg-faded-accent fs-sm text-body align-middle ms-2">{{count(getSupplierProducts())}}</span></h2>
      <!-- <div class="py-2">
        <div class="d-flex flex-nowrap align-items-center pb-3">
          <label class="form-label fw-normal text-nowrap mb-0 me-2" for="sorting">Sort by:</label>
          <select class="form-select form-select-sm me-2" id="sorting">
            <option>Date Created</option>
            <option>Product Name</option>
            <option>Price</option>
            <option>Your Rating</option>
            <option>Updates</option>
          </select>
          <button class="btn btn-outline-secondary btn-sm px-2" type="button"><i class="ci-arrow-up"></i></button>
        </div>
      </div> -->
    </div>
    @include('inc.session-message')
    @foreach( $products as $p )
    <!-- Product-->
    <div class="d-block d-sm-flex align-items-center py-4 border-bottom"><a class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" href="{{route('edit-product', $p->id)}}" style="width: 12.5rem;"><img class="rounded-3" src="{{asset('/product_images/'.$p->image)}}" alt="Product"></a>
      <div class="text-center text-sm-start">
        <h3 class="h6 product-title mb-2"><a href="{{route('edit-product', $p->id)}}">{{ ucwords($p->name) }}</a></h3>
        <div class="d-inline-block text-accent">
          <span class="h5 fw-normal text-accent">₹ {{ $p->offer_price}}
          </span>
          <del class="text-muted fs-sm me-3">₹ {{$p->mrp}}
          </del>
        </div>
        <!-- <div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">Sales: <span class="fw-medium">26</span></div>
        <div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">Earnings: <span class="fw-medium">$327.<small>60</small></span></div> -->
        <div class="d-flex justify-content-center justify-content-sm-start pt-3">
          <!-- <a class="btn bg-faded-accent btn-icon me-2" type="button" data-bs-toggle="tooltip" title="Download"><i class="ci-download text-accent"></i></a> -->
          <a class="btn bg-faded-info btn-icon me-2" href="{{route('edit-product', $p->id)}}" type="button" data-bs-toggle="tooltip" title="Edit"><i class="ci-edit text-info"></i></a>
          <a class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure to delete this product?')" href="{{ route('delete-product', $p->id) }}"><i class="ci-trash text-danger"></i></a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div>
  {!! $products->links() !!}
  </div> 
</section>

@endsection

@push('styles')
  <style>
    nav .pagination{
        justify-content: center;
      }
  </style>
@endpush