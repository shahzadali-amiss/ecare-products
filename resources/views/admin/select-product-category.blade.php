@extends('layouts.admin')
@section('content')          
<!-- <div class="content-wrapper">
  <div class="row">
    <div class="col-12">  
      <div class="card"> 
        <div class="card-body">
          <h4 class="card-title">Select Product Category</h4>
          <div class="row">
            <div class="col-12">

              @if(Session::has('msg'))
              <div class="alert alert-warning" role="alert">
                  <strong>Heads up!</strong> {{Session::get('success')}} 
              </div>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <form class="cmxform" id="select-category-form" method="post" action="{{ route('showProductCategories') }}" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        <label for="category">Select Product Category</label>
                        <select class="form-control form-control-lg py-3 @error('category') is-invalid @enderror" id="category" name="category">
                          <option value="" selected>Select Category</option>
                          @foreach($categories as $ct)
                          <option value="{{$ct->id}}">{{ucwords($ct->name)}}</option>
                          @endforeach 
                          <option>Other</option>   
                        </select>
                        @include('admin.inc.error_message',['name'=>'category'])
                      </div>
                      <input class="btn btn-primary" type="submit" value="Submit">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->
<div class="content-wrapper">
@include('inc.choose-category',['route_name'=>'showProductCategories'])
</div>
@endsection
@push('scripts')
@include('inc.choose-category-script')
@endpush