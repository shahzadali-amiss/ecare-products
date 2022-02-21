@extends('layouts.supplier-guest')
@section('content')
	<section id="">
		<div class="container-fluid py-5 bg-danger">
			<div class="row justify-content-center">
				<div class="col-md-10 multistep-form">
					<!-- MultiStep Form -->
					<div class="my-5" style="text-align:center;">
					    <div class="step-cont">
					    	<div class="text-white fw-bold mb-2">GST Details</div>
					    	<span class="step"><small>1</small></span>
					    </div>
					    <div class="step-cont">
					    	<div class="text-white fw-bold mb-2">Pickup Address</div>
					    	<span class="step"><small>2</small></span>
					    </div>
					    <div class="step-cont">
					    	<div class="text-white fw-bold mb-2">Bank Details</div>
					    	<span class="step"><small>3</small></span>
					    </div>
					    <div class="step-cont no-bar">
					    	<div class="text-white fw-bold mb-2">Supplier Details</div>
					    	<span class="step"><small>4</small></span>
					    </div>
					</div>
					<form id="regForm" action="/action_page.php">
					  	<!-- One "tab" for each step in the form: -->
					  	<div class="tab">
					  		<h1>GST Details</h1>
					    	<p class="mt-5">
					    		<input placeholder="GST Number" oninput="this.className = ''" name="gst_number" class="input" required>
					    	</p>
					    	<!-- <p>
					    		<input placeholder="Last name..." oninput="this.className = ''" name="lname" class="input" required>
					    	</p> -->
					  	</div>
					  	<div class="tab">
					    	<h1>Pickup Address</h1>
					    	<p class="mt-5">
					    		<select placeholder="Select state" oninput="this.className = ''" name="state" class="input" required>
					    			<option value="">Select State</option>
					    			<option>Telangana</option>
					    			<option>Uttar Pradesh</option>
					    			<option>Haryana</option>
					    			<option>West Bengal</option>
					    			<option>Madhya Pradesh</option>
					    		</select>
					    	</p>
				    		<p class="mt-4">
				    			<select placeholder="Select city" oninput="this.className = ''" name="city" class="input" required>
					    			<option value="">Select city</option>
					    			<option>Faridabad</option>
					    			<option>Kanpur</option>
					    			<option>Chennai</option>
					    			<option>Bangalore</option>
					    			<option>Jaipur</option>
					    		</select>
				    		</p>
				    		<p class="mt-4">
				    			<input placeholder="Address" oninput="this.className = ''" name="address" class="input" required>
				    		</p>
				    		<p class="mt-4">
				    			<input placeholder="Pin Code" oninput="this.className = ''" name="pin_code" class="input" required>
				    		</p>
					  	</div>
					  	<div class="tab">
					  		<h1>Bank Details</h1>
					    	<p class="mt-5">
					    		<input placeholder="Account Holder Name" oninput="this.className = ''" name="account_holder_name" class="input" required>
					    	</p>
					    	<p class="mt-4">
					    		<input placeholder="Bank Name" oninput="this.className = ''" name="bank_name" class="input" required>
					    	</p>
					    	<p class="mt-4">
					    		<input placeholder="Account Number" oninput="this.className = ''" name="account_number" class="input" required>
					    	</p>
					    	<p class="mt-4">
					    		<input placeholder="IFSC Code" oninput="this.className = ''" name="ifsc_code" class="input" required>
					    	</p>
					  	</div>
					  	<div class="tab">
					    	<h1>Supplier Details</h1>
					    	<p class="mt-5">
					    		<input placeholder="Company/Business Name" oninput="this.className = ''" name="business_name" class="input" required>
					    	</p>
					    	<p class="mt-4">
					    		<input placeholder="Contact Person Name" oninput="this.className = ''" name="supplier_name" class="input" required>
					    	</p>
					    	<p class="mt-4">
					    		<input placeholder="Mobile Number" oninput="this.className = ''" name="supplier_mobile" class="input" required>
					    	</p>
					  	</div>
					  	<div style="overflow:auto;">
						    <div style="float:right;">
						      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
						      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
						    </div>
					  	</div>
						  <!-- Circles which indicates the steps of the form: -->
					</form>
			        
					 
				</div>
			</div>
		</div>
	</section>
@endsection
@push('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/multistep-form.css') }}">
@endpush

@push('scripts')
	<script type="text/javascript" src="{{ asset('js/multistep-form.js') }}"></script>
@endpush