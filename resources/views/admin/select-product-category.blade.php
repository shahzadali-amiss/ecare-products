@extends('layouts.admin')
@section('content')

  <div class="content-wrapper">
    @include('inc.choose-category', ['route_name'=>'showProductCategories'])
  </div>

@endsection

@push('scripts')

  @include('inc.choose-category-script')

@endpush