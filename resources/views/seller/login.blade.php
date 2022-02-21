@extends('layouts.home2')
@section('content')
	<section>
		<div class="container py-5">
			<div class="row justify-content-center" style="margin-top:15px; ">
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

					<form action="{{ route('seller_login') }}" method="post" class="w-100 bg-light">
						@csrf
						<input type="hidden" value="s" name="role">
						<div class="form-group mb-4">
	                        <label for="mobile">Mobile Number</label>
	                        <input id="mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" type="number" maxlength="10" minlength="10" value="{{ Session::get('seller-mobile') }}">
	                        @include('admin.inc.error_message',['name'=>'mobile']) 
                      	</div>
                      	<div class="form-group mb-4">
		                    <x-label for="password" :value="__('Password :')" />

		                    <x-input id="password" class="form-control @error('password')"
		                                    type="password"
		                                    name="password"
		                                    required autocomplete="new-password" />
		                    @include('admin.inc.error_message',['name'=>'password'])  
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