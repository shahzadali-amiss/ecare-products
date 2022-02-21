@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-12">  
      <div class="card"> 
    		<div class="card-body">
      		<h3 class="bg-light text-center py-2">@if($user->role=='a'){{'Admin'}}@elseif($user->role=='c'){{'Customer'}}@elseif($user->role=='s'){{'Supplier'}}@endif Details</h3>
      		<div class="row">
        		<div class="col-12">
          			@include('inc.session-message')
        		</div>
      		</div>
      		<div class="row mt-5 justify-content-around px-5">
        		<div class="col-md-3">
        			<div class="w-100 bg-light position-relative rounded-circle square-box overflow-hidden">
        				@if($role=='s' && $supplier)
        				<img src="{{asset('supplier_images')}}/{{$supplier->image}}" class="w-100">
        				@else
        				<span class="letter text-dark">
        					@if(is_null($user->name))	
        						{{strtoupper($user->email[0])}}
        					@else
        						{{strtoupper($user->name[0])}}
        					@endif
        				</span>
        				@endif
        			</div>
        		</div>
        		<div class="col-md-7 py-3">
        			@if(!is_null($user->name))
        			<div class="row justify-content-around bg-light p-2 mb-2">
        				<div class="col-4 h4 mb-0">@if($user->role=='a'){{'Admin'}}@elseif($user->role=='c'){{'Customer'}}@elseif($user->role=='s'){{'Supplier'}}@endif Name</div>		
        				<div class="col-8 h4 mb-0">{{ucwords($user->name)}}</div>		
        			</div>
        			@endif
      				<div class="row justify-content-around bg-light p-2 mb-2">
      					<div class="col-4 h4 mb-0">@if($user->role=='a'){{'Admin'}}@elseif($user->role=='c'){{'Customer'}}@elseif($user->role=='s'){{'Supplier'}}@endif Mobile</div>		
      					<div class="col-8 h4 mb-0">{{$user->mobile}}</div>		
      				</div>
      				@if(!is_null($user->email))
      				<div class="row justify-content-around bg-light p-2 mb-2">
      					<div class="col-4 h4 mb-0">@if($user->role=='a'){{'Admin'}}@elseif($user->role=='c'){{'Customer'}}@elseif($user->role=='s'){{'Supplier'}}@endif Email</div>		
      					<div class="col-8 h4 mb-0">{{$user->email}}</div>		
      				</div>
      				@endif
      				<div class="row justify-content-around bg-light p-2 mb-2">
      					<div class="col-4 h4 mb-0">Status</div>		
      					<div class="col-8 h4 mb-0">{{ $user->status ? 'Active':'Not Active'}}</div>		
      				</div>
      			</div>
      		</div>

      		@if($role=='s')
      		<ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
					  <li class="nav-item">
					    <a class="nav-link active" id="gst-tab" data-toggle="tab" href="#gst" role="tab" aria-controls="gst" aria-selected="true">GST Details
					  		@if( $supplier && $supplier->is_verified )  	
					    	<img src="{{asset('admin_assets/images/verify.png')}}" width="16px" style="position: relative;top:-10px;">
					    	@endif
					    </a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link" id="bank-tab" data-toggle="tab" href="#bank" role="tab" aria-controls="bank" aria-selected="true">Bank Details</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link" id="registered-tab" data-toggle="tab" href="#registered" role="tab" aria-controls="registered" aria-selected="true">Registered Address</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link" id="pickup-tab" data-toggle="tab" href="#pickup" role="tab" aria-controls="pickup" aria-selected="true">Pickup Address</a>
					  </li>
					</ul>
					<div class="tab-content" id="myTabContent">  
					  @if($supplier)
					  <div class="tab-pane fade show active" id="gst" role="tabpanel" aria-labelledby="gst-tab">
					  	<div class="row mt-4 px-5">
		        		<h4 class="text-center bg-dark text-white py-2">GST Details</h4>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Business Name</div>		
		    					<div class="col-9 h4 mb-0">{{ucwords($supplier->business_name)}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">GST Number</div>		
		    					<div class="col-9 h4 mb-0">{{$supplier->gst_no}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">PAN Number</div>		
		    					<div class="col-9 h4 mb-0">{{$supplier->pan_no}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Business Type</div>		
		    					<div class="col-9 h4 mb-0">{{$supplier->business_type}}</div>	
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0 py-2">Verified Status</div>		
		    					<div class="col-9 h4 mb-0">
		    						<form action="{{ route('verify_user') }}" method="post">
		    							@csrf
		    							<input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
		    							<select class="form-control supplier-verified-status" name="is_verified" onchange="this.closest('form').submit()">
			    							<option value="1" {{ $supplier->is_verified ? 'selected' : '' }}>Verified</option>
			    							<option value="0" {{ !$supplier->is_verified ? 'selected' : '' }}>Not-Verified</option>
			    						</select>
		    						</form>
		    					</div>
		    				</div>
		      		</div>
					  </div>
					  @else
					  <div class="tab-pane fade show active" id="gst" role="tabpanel" aria-labelledby="gst-tab">
					  	<div class="row mt-4 px-5">
		        		<h4 class="text-center py-2">No GST Details found</h4>
		        	</div>
		        </div>
					  @endif
					  @if($bank)
					  <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="bank-tab">
					  	<div class="row mt-4 px-5">
		    				<h4 class="text-center bg-dark text-white py-2">Bank Details</h4>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Name</div>		
		    					<div class="col-9 h4 mb-0">{{ucwords($bank->name)}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Bank Name</div>		
		    					<div class="col-9 h4 mb-0">{{ucwords($bank->account_name)}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Account Number</div>		
		    					<div class="col-9 h4 mb-0">{{$bank->account_number}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">IFSC Code</div>		
		    					<div class="col-9 h4 mb-0">{{$bank->ifsc}}</div>		
		    				</div>
		    			</div>
					  </div>
					  @else
					  <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="bank-tab">
					  	<div class="row mt-4 px-5">
		        		<h4 class="text-center py-2">No Bank Details found</h4>
		        	</div>
		        </div>
					  @endif
					  @if($r_address)
					  <div class="tab-pane fade" id="registered" role="tabpanel" aria-labelledby="registered-tab">
					  	<div class="row mt-4 px-5">
		    				<h4 class="text-center bg-dark text-white py-2">Registered Address</h4>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Name</div>		
		    					<div class="col-9 h4 mb-0">{{ucwords($r_address->name)}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Email</div>		
		    					<div class="col-9 h4 mb-0">{{$r_address->email}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Mobile</div>		
		    					<div class="col-9 h4 mb-0">{{$r_address->mobile}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Address</div>		
		    					<div class="col-9 h4 mb-0">{{$r_address->address}}</div>		
		    				</div>
		    			</div>
					  </div>
					  @else
					  <div class="tab-pane fade" id="registered" role="tabpanel" aria-labelledby="registered-tab">
					  	<div class="row mt-4 px-5">
		        		<h4 class="text-center py-2">No Registered Address found</h4>
		        	</div>
		        </div>
					  @endif
					  @if($p_address)
					  <div class="tab-pane fade" id="pickup" role="tabpanel" aria-labelledby="pickup-tab">
					  	<div class="row mt-4 px-5">
		    				<h4 class="text-center bg-dark text-white py-2">Pickup Address</h4>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Name</div>		
		    					<div class="col-9 h4 mb-0">{{ucwords($p_address->name)}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Email</div>		
		    					<div class="col-9 h4 mb-0">{{$p_address->email}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Mobile</div>		
		    					<div class="col-9 h4 mb-0">{{$p_address->mobile}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">State</div>		
		    					<div class="col-9 h4 mb-0">{{getStateName($p_address->state)}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">City</div>		
		    					<div class="col-9 h4 mb-0">{{getCityName($p_address->city)}}</div>		
		    				</div>
		    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
		    					<div class="col-3 h4 mb-0">Address</div>		
		    					<div class="col-9 h4 mb-0">{{$p_address->address}}</div>		
		    				</div>
		    			</div>
					  </div>
					  @else
						<div class="tab-pane fade" id="pickup" role="tabpanel" aria-labelledby="pickup-tab">
					  	<div class="row mt-4 px-5">
		        		<h4 class="text-center py-2">No Pickup Address found</h4>
		        	</div>
		        </div>
					  @endif
					</div>
					@endif
    			@if($role=='c')
    			<div class="row mt-4 px-5">
    				@if($address)
    				<h4 class="text-center bg-dark text-white py-2">Delivery Address</h4>
    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
    					<div class="col-3 h4 mb-0">Name</div>		
    					<div class="col-9 h4 mb-0">{{ucwords($address->name)}}</div>		
    				</div>
    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
    					<div class="col-3 h4 mb-0">Email</div>		
    					<div class="col-9 h4 mb-0">{{$address->email}}</div>		
    				</div>
    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
    					<div class="col-3 h4 mb-0">Mobile</div>		
    					<div class="col-9 h4 mb-0">{{$address->mobile}}</div>		
    				</div>
    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
    					<div class="col-3 h4 mb-0">State</div>		
    					<div class="col-9 h4 mb-0">{{getStateName($address->state)}}</div>		
    				</div>
    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
    					<div class="col-3 h4 mb-0">City</div>		
    					<div class="col-9 h4 mb-0">{{getCityName($address->city)}}</div>		
    				</div>
    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
    					<div class="col-3 h4 mb-0">Address</div>		
    					<div class="col-9 h4 mb-0">{{ucwords($address->house).', '.ucwords($address->area)}}</div>		
    				</div>
    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
    					<div class="col-3 h4 mb-0">Landmark</div>		
    					<div class="col-9 h4 mb-0">{{ucwords($address->landmark)}}</div>
    				</div>
    				<div class="row justify-content-around bg-light mx-0 p-2 mb-2">
    					<div class="col-3 h4 mb-0">Pincode</div>		
    					<div class="col-9 h4 mb-0">{{$address->pincode}}</div>
    				</div>
    				@else
    				<h4 class="text-center py-2">No Delivery Address found</h4>
    				@endif
      		</div>	
      		@endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
	var width= $('.square-box').width();
	$('.square-box').css({'height':width+'px'});
</script>
@endpush

@push('styles')
<style type="text/css">
	.square-box .letter{
		position:absolute;
		top: 50%;
		left: 50%;
		font-size: 130px;
		font-weight: 900;
		transform: translate(-50%, -50%);
		z-index: 999;
	}

	.supplier-verified-status{
    background-color: #fff!important;
    color:#111!important;
    appearance:auto!important;
  }
</style>
@endpush