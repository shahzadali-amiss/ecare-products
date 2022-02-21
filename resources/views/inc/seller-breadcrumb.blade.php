@php
$supplier_details=getSupplierDetails();
@endphp
<div class="page-title-overlap bg-accent pt-4">
  <div class="container d-flex flex-wrap flex-sm-nowrap justify-content-center justify-content-sm-between align-items-center pt-2">
    <div class="d-flex align-items-center pb-3">
      <div class="img-thumbnail rounded-circle position-relative flex-shrink-0" style="width: 6.375rem;"><img class="rounded-circle" src="{{ asset('supplier_images') }}/{{ $supplier_details ? $supplier_details->image : 'default.jpg' }}" alt=""></div>
      <div class="ps-3">
        <h3 class="text-light fs-lg mb-0">
          @if(is_null(Session::get('supplier.name')))
            {{ explode('@',Session::get('supplier.email'))[0] }}
          @else
            {{ucwords(Session::get('supplier.name'))}}
          @endif
        </h3><span class="d-block text-light fs-ms opacity-60 py-1">Joined on {{ date('d M, Y',strtotime(Session::get('supplier.created_at'))) }}</span>
      </div>
    </div>
    <div class="d-flex">
      <div class="text-sm-end me-5">
        <div class="text-light fs-base">Total sales</div>
        <h3 class="text-light">426</h3>
      </div>
      <div class="text-sm-end">
        <div class="text-light fs-base">Seller rating</div>
        <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star"></i>
        </div>
        <div class="text-light opacity-60 fs-xs">Based on 98 reviews</div>
      </div>
    </div>
  </div>
</div>