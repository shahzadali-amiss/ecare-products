@extends('layouts.seller')
@section('content')
<section class="col-lg-8 pt-lg-4 pb-4 mb-3">
@include('inc.choose-category',['route_name' => 'choose_category'])
</section>
@endsection
@push('scripts')
@include('inc.choose-category-script')
@endpush