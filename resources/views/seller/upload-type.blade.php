@extends('layouts.seller')
@section('content')

<!-- Content-->
<section class="col-lg-8 pt-lg-4 pb-4 mb-3">
  <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
    <!-- Title-->
    <div class="d-sm-flex flex-wrap justify-content-between align-items-center pb-2">
      <h2 class="h3 py-2 me-2 text-center text-sm-start">Add New Product</h2>
    </div>
    @if(Session::has('error'))
    <div class="alert alert-danger" role="alert">
            {{Session::get('error')}} 
        </div>
    @endif
    @if(Session::has('status'))
    <div class="alert alert-danger" role="alert">
            {{Session::get('status')}}  
        </div>
    @endif
    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
            {{Session::get('success')}}  
        </div>
    @endif
    <div class="row mt-5 py-5">
      <h4 class="text-center mb-5">Select Product Upload Type</h4>
      <div class="col-lg-6">
        <a class="btn btn-primary d-block w-100" href="{{ route('choose_category', 'single') }}"><i class="ci-cloud-upload fs-lg me-2"></i>Single Product Upload</a>
      </div>
      <div class="col-lg-6 mt-4 mt-lg-0">
        <a class="btn btn-primary d-block w-100" href="#{{-- route('choose_category', 'bulk') --}}"><i class="ci-cloud-upload fs-lg me-2"></i>Bulk Product Upload</a>
      </div>
    </div>
    </div>
  </div>
</section>

@endsection