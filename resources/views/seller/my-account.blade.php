@extends('layouts.seller')
@section('content') 
@php
$supplier_details=getSupplierDetails();
@endphp
<!-- Content-->
<section class="col-lg-8 pt-lg-4 pb-4 mb-3">
  <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
    @include('inc.session-message')
    <h2 class="h3 py-2 text-center text-sm-start">My Account</h2>
    <!-- Tabs-->
    <ul class="nav nav-tabs nav-justified" role="tablist">
      <li class="nav-item"><a class="nav-link px-0 active" href="#gst-details" data-bs-toggle="tab" role="tab">
          <div class="d-none d-lg-block">
            <i class="ci-percent opacity-60 me-2"></i>GST Details
          </div>
          <div class="d-lg-none text-center">
            <i class="ci-percent opacity-60 d-block fs-xl mb-2"></i>
            <span class="fs-ms">GST Details</span>
          </div>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-0" href="#pickup-address" data-bs-toggle="tab" role="tab">
          <div class="d-none d-lg-block">
            <i class="ci-delivery opacity-60 me-2"></i>Pickup Address
          </div>
          <div class="d-lg-none text-center">
            <i class="ci-delivery opacity-60 d-block fs-xl mb-2"></i>
            <span class="fs-ms">Pickup Address</span>
          </div>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-0" href="#bank-details" data-bs-toggle="tab" role="tab">
          <div class="d-none d-lg-block">
            <i class="ci-card opacity-60 me-2"></i>Bank Details
          </div>
          <div class="d-lg-none text-center">
            <i class="ci-card opacity-60 d-block fs-xl mb-2"></i>
            <span class="fs-ms">Bank Details</span>
          </div>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-0" href="#supplier-details" data-bs-toggle="tab" role="tab">
          <div class="d-none d-lg-block">
            <i class="ci-user opacity-60 me-2"></i>Supplier Details
          </div>
          <div class="d-lg-none text-center">
            <i class="ci-user opacity-60 d-block fs-xl mb-2"></i>
            <span class="fs-ms">Supplier Details</span>
          </div>
        </a>
      </li>
    </ul>
    <!-- Tab content-->
    <form action="{{ route('seller-account') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="tab-content">
      <!-- GST Details-->
      <div class="tab-pane fade show active" id="gst-details" role="tabpanel">
        <h4 class="text-center">GST Details</h4>
        <div class="row gx-4 gy-3">
          <div class="col-sm-12 py-4">
            <label class="form-label" for="gst-number">Enter GST Number</label>
            <div class="row mt-2">
              <div class="col-sm-9">
                <input class="form-control" type="text" name="gst_number" id="gst-number" value="{{ $supplier_details ? $supplier_details->gst_no : Request::old('gst_number') }}">
              </div>
              <div class="col-sm-3">
                <button class="btn btn-primary mt-3 w-100 mt-sm-0" type="button">Verify</button>
              </div>
            </div>
          </div>
          <div class="col-sm-12 pb-5">
            <div class="row mt-2">
              <div class="col-sm-6">
                <label class="form-label" for="business-name">Business Name</label>
                <input class="form-control" type="text" name="business_name" id="business-name" value="{{ $supplier_details ? $supplier_details->business_name : Request::old('business_name') }}">
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="pan-number">PAN Number</label>
                <input class="form-control" type="text" name="pan_number" id="pan-number" value="{{ $supplier_details ? $supplier_details->pan_no : Request::old('pan_number') }}">
              </div>
              <div class="col-sm-6 mt-4">
                <label class="form-label" for="business-type">Business Type</label>
                <input class="form-control" type="text" name="business_type" id="business-type" value="{{ $supplier_details ? $supplier_details->business_type : Request::old('business_type') }}">
              </div>
              <div class="col-sm-6 mt-4">
                <label class="form-label" for="business-address">Business Address</label>
                <input class="form-control" type="text" name="business_address" id="business-address" value="{{ $reg_address ? $reg_address->address : Request::old('business_address') }}">
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- Pickup Address-->
      <div class="tab-pane fade" id="pickup-address" role="tabpanel">
        <h4 class="text-center">Pickup Address</h4>
        <div class="row gx-4 gy-3">
          <div class="col-sm-12 pt-4">         
            <label class="form-label" for="state">State</label>
            <select name="state" class="form-control" name="state" id="state">
              <option value="">Select state</option>
                @foreach($states as $state)
                <option value="{{$state->id}}" @if($pick_address){{ $state->id==$pick_address->state ? 'selected' : '' }}@endif>{{ucwords($state->name)}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-sm-8 mt-4">         
            <label class="form-label" for="city">City</label>
            <select name="city" class="form-control" name="city" id="city">
              <option value="">Select city</option>
              @if($pick_address)
                <option value="{{$pick_address->city}}" selected>{{ucwords(getCityName($pick_address->city))}}</option>
              @endif
            </select>
          </div>
          <div class="col-sm-4 mt-4">         
            <label class="form-label" for="pincode">Pincode</label>
            <input class="form-control" type="text" maxlength="6" name="pincode" id="pincode" value="{{ $pick_address ? $pick_address->pincode : Request::old('pincode') }}">
          </div>
          <!-- 10, BUALANDSHAHR, INTA RODI, Pincode - 203001, Bulandshahar, Uttar Pradesh -->
          <div class="col-sm-12 mt-4">         
            <label class="form-label" for="address">Address</label>
            <input class="form-control" type="text" name="address" id="address" value="{{ $pick_address ? $pick_address->address : Request::old('address') }}">
          </div>
        </div>
      </div>
     
      <!-- Bank Details-->
      <div class="tab-pane fade" id="bank-details" role="tabpanel">
        <h4 class="text-center">Bank Details</h4>
        <div class="row gx-4 gy-3">
          <div class="col-sm-12 pt-4">         
            <label class="form-label" for="account_holder_name">Account Holder Name</label>
            <input class="form-control" type="text" name="account_holder_name" id="account_holder_name" value="{{ $bank ? $bank->name : Request::old('account_holder_name') }}">
          </div>
          <div class="col-sm-12 pt-4">         
            <label class="form-label" for="bank_name">Bank Name</label>
            <input class="form-control" type="text" name="bank_name" id="bank_name" value="{{ $bank ? $bank->account_name : Request::old('bank_name') }}">
          </div>
          <div class="col-sm-12 pt-4">         
            <label class="form-label" for="account_number">Account Number</label>
            <input class="form-control" type="number" name="account_number" id="account_number" value="{{ $bank ? $bank->account_number : Request::old('account_number') }}">
          </div>
          <div class="col-sm-12 pt-4">         
            <label class="form-label" for="ifsc_code">IFSC Code</label>
            <input class="form-control" type="text" name="ifsc_code" id="ifsc_code" value="{{ $bank ? $bank->ifsc : Request::old('ifsc_code') }}">
          </div>
        </div>  
      </div>

      <!-----Supplier Details----->
      <div class="tab-pane fade" id="supplier-details" role="tabpanel">
        <h4 class="text-center">Supplier Details</h4>
        <div class="bg-secondary rounded-3 p-4 mb-4">
          <div class="d-flex align-items-center">
            <img class="rounded" src="{{ asset('supplier_images') }}/{{ $supplier_details ? $supplier_details->image : 'default.jpg' }}" id="output2" width="90" alt="">
            <div class="ps-3">
              <button class="btn btn-light btn-shadow btn-sm mb-2" type="button" onclick="clickFile()">
                <i class="ci-loading me-2"></i>Change 
                <span class='d-none d-sm-inline'>avatar</span>
              </button>
              <input type="file" id="sel-file" onchange="loadFile(event,'output2')" class="d-none sel-file" name="image">
              <div class="p mb-0 fs-ms text-muted">Upload JPG or PNG image. 300 x 300 required.</div>
            </div>
          </div>
        </div>
        <div class="row gx-4 gy-3">
          <div class="col-sm-6">
            <label class="form-label" for="dashboard-fn">Name</label>
            <input class="form-control" type="text" id="name" name="name" value="{{ $supplier_details ? $supplier_details->supplier_name : Request::old('name') }}">
          </div>
          <div class="col-sm-6">
            <label class="form-label" for="email">Email</label>
            <input class="form-control" type="text" id="email" name="email" value="{{Session::get('supplier.email')}}" readonly="">
          </div>
          <div class="col-sm-6">
            <label class="form-label" for="mobile">Mobile</label>
            <input class="form-control" type="text" maxlength="10" id="mobile" name="mobile" value="{{Session::get('supplier.mobile')}}" readonly>
          </div>
          <div class="col-12">
            <hr class="mt-2 mb-4">
            <div class="d-sm-flex justify-content-between align-items-center">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="i_agree" name="i_agree" checked>
                <label class="form-check-label text-dark" for="freelancer">I agree to all 
                  <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policies</a>
                </label>
              </div>
              <button id="form-submit" class="btn btn-primary mt-3 mt-sm-0" type="Submit" disabled>Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    </form>
  </div>
</section>

@endsection
@push('styles')
<style>
  .sel-file{
    width:0;
    height: 0;
  }
</style>
@endpush
@push('scripts')
<script type="text/javascript">
  
  var loadFile = function(event, bindId) {
    var image = document.getElementById(bindId);
    image.src = URL.createObjectURL(event.target.files[0]);
  };

  function clickFile(){
     var ele=document.getElementById('sel-file');
     ele.classList.remove('d-none');
     ele.click();
  }

  jQuery(document).ready(function($){

    $('#i_agree').on('click', function(){
        if(this.checked){
          $('#form-submit').attr('disabled',false);
        }else{
          $('#form-submit').attr('disabled',true);
        }
    });
    if($('#i_agree').is(":checked")){
        $('#form-submit').attr('disabled',false);
    }
    else if($('#i_agree').is(":not(:checked)")){
        $('#form-submit').attr('disabled',true);
    }




    $('#state').on('change', function(){
      if($(this).val() != ""){
        var url = '/api/get-cities-from-state/'+($(this).val());
        $.get(url, function(data, status){
          if(data.status==true){
            
            //console.log(data.data);
            bindParentCategory(data.data,'city');
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