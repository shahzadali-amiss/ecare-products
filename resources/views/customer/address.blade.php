@extends('layouts.user')
@section('content')
<!-- Content  -->
<section class="col-lg-8">
            <!-- Toolbar-->
            <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
              <h6 class="fs-base text-light mb-0">Your registered address:</h6><a class="btn btn-primary btn-sm" href="{{ route('logout') }}"><i class="ci-sign-out me-2"></i>Sign out</a>
            </div>
            <!-- Addresses list-->
            @include('inc.session-message')
            <form action="{{ route('address') }}" method="post">
              @csrf
              <input type="hidden" name="is_update" value="{{ isset($address) ? $address->id : '' }}">
              <div class="row">
                <div class="col-sm-6">
                  <div class="mb-3">
                    <label class="form-label" for="checkout-state">State</label>
                    <select class="form-select" id="checkout-state" name="state" required="">
                      <option value="">Select state</option>
                      @foreach($states as $state)
                      <option value="{{$state->id}}" @if(isset($address)){{ $address->state==$state->id ? 'selected' : '' }}@endif>{{ucwords($state->name)}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="mb-3">
                    <label class="form-label" for="checkout-city">City</label>
                    <select class="form-select" id="checkout-city" name="city" required="">
                      <option value="">Select city</option>
                      @if(isset($address))
                        <option value="{{$address->city}}" selected>{{ucwords(getCityName($address->city))}}</option>
                      @endif
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="mb-3">
                    <label class="form-label" for="house">House No. / Street Name / Locality</label>
                    <input class="form-control" type="text" id="house" name="house" value="{{ isset($address) ? $address->house : '' }}">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="mb-3">
                    <label class="form-label" for="area">Village / Town / Area</label>
                    <input class="form-control" type="text" id="area" name="area" value="{{ isset($address) ? $address->area : '' }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="mb-3">
                    <label class="form-label" for="checkout-landmark">Landmark</label>
                    <input class="form-control" type="text" id="checkout-landmark" name="landmark" value="{{ isset($address) ? $address->landmark : '' }}">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="mb-3">
                    <label class="form-label" for="checkout-zip">ZIP Code</label>
                    <input class="form-control" type="text" maxlength="6" id="checkout-zip" name="zipcode" value="{{ isset($address) ? $address->pincode : '' }}">
                  </div>
                </div>
              </div>
              <div class="pt-4"><button class="btn btn-primary" type="submit">Update Address</button></div>
            </form>
            
          </section>
@endsection


@push('scripts')
  <script type="text/javascript">
  jQuery(document).ready(function($){
    $('#checkout-state').on('change', function(){
      if($(this).val() != ""){
        var url = '/api/get-cities-from-state/'+($(this).val());
        $.get(url, function(data, status){
          if(data.status==true){
            
            //console.log(data.data);
            bindParentCategory(data.data,'checkout-city');
          }    
        });
      }
    });

    function bindParentCategory(data, element){  
      var sel=document.getElementById(element);
      sel.innerText = "";
      var opt = document.createElement('option');
      opt.innerHTML = 'Select city';
      opt.value = "";
      // opt.setAttribute('data-display', 'Please Select');
      sel.appendChild(opt);

          //console.log(data.length);
      // ITERATE TO BIND OPTIONS
      for(var i = 0; i < data.length; i++) {
          var opt = document.createElement('option');
          opt.innerHTML = data[i].city;
          opt.value = data[i].id;
          sel.appendChild(opt);
      }
    }
  });
  </script>
@endpush