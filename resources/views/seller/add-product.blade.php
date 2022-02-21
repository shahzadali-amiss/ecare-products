@extends('layouts.seller')
@section('content')

<!-- Content-->
<section class="col-lg-8 pt-lg-4 pb-4 mb-3">
  @include('inc.add-product',['route_name'=>'add-product'])
</section>

@endsection
@include('inc.add-product-scripts')