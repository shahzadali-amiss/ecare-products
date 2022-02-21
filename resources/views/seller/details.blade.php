@extends('layouts.home2')
@section('content')
	<section>
		<div class="container py-5">
			<div class="row justify-content-center" style="margin-top:15px;">
				<div class="col-md-12">
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
					<form action="{{ route('get-supplier-details') }}" method="post" class="w-100 bg-light">
						@csrf
						<input type="hidden" value="s" name="role">
						<div class="form-group mb-4">
	                        <label for="mobile">Mobile Number</label>
	                        <input id="mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" type="number" maxlength="10" minlength="10" value="{{$mobile}}{{Request::old('mobile')}}" readonly="">
	                        @include('admin.inc.error_message',['name'=>'mobile']) 
                      	</div>
                      	<div class="form-group mb-4">
	                        <label for="otp">Enter OTP</label>
	                        <input id="otp" class="form-control @error('otp') is-invalid @enderror" name="otp" autocomplete="off" type="number" maxlength="6" minlength="6" >
	                        @include('admin.inc.error_message',['name'=>'otp']) 
                      	</div>
                      	<div class="form-group mb-4">
	                        <label for="email-id">Email ID</label>
	                        <input id="email-id" class="form-control @error('email') is-invalid @enderror" name="email" type="email" value="{{Request::old('email')}}">
	                        @include('admin.inc.error_message',['name'=>'email']) 
                      	</div>
                      	<!-- <div class="form-group mb-4">
	                        <label for="password">Set Password</label>
	                        <input id="password" class="form-control @error('password') is-invalid @enderror" name="password" type="password" >
	                        @include('admin.inc.error_message',['name'=>'password']) 
                      	</div> -->

                      	<div class="form-group mb-4">
		                    <x-label for="password" :value="__('Password :')" />

		                    <x-input id="password" class="form-control @error('password')"
		                                    type="password"
		                                    name="password"
		                                    required autocomplete="new-password" />
		                    @include('admin.inc.error_message',['name'=>'password'])  
		                </div>

		                <!-- Confirm Password -->
		                <div class="form-group mb-4">
		                    <x-label for="password_confirmation" :value="__('Confirm Password :')" />

		                    <x-input id="password_confirmation" class="form-control @error('password_confirmation')"
		                                    type="password"
		                                    name="password_confirmation" required />
                            @include('admin.inc.error_message',['name'=>'password_confirmation'])
		                </div>

                      	<div class="form-group text-center mt-3">
                      		<input class="btn btn-primary" type="submit" value="Create Account">
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
@endsection