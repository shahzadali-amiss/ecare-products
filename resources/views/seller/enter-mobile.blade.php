<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div class="w-100 m-auto text-center p-2 p-md-5 pb-md-0">
                <a href="{{ route('guest-home') }}" title="Go to home" class="" rel="home">
                      <img class="site_logo" id="logo" src="{{ asset('img/logo-dark.png') }}" alt="ATAA HAI">
                </a>
            </div>
        </x-slot>
        <div class="m-auto reg-cont">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-danger text-center" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4 text-danger text-center" :errors="$errors" />

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
                <form class="fw-bold p-3 p-md-5 rounded-3" action="{{ route('get-supplier-mobile') }}" method="post">
                    @csrf
                    <input type="hidden" name="role" id="role" value="s">

                    <div class="row justify-content-center">
	                    <x-label class="col-lg-3 py-2" for="mobile" :value="__('Mobile :')" />

	                    <x-input id="mobile" class="col-lg-6 block mt-1 w-full border border-none rounded py-2 py-lg-1 @error('mobile') is-invalid @enderror" type="text" name="mobile" :value="old('mobile')" maxlength="10" minlength="10" required autofocus/>
	                    @include('admin.inc.error_message',['name'=>'mobile']) 
	                </div>

	                <!-- <br><br> -->
	                <div class="row justify-content-center">
                        <input class="btn btn-primary col-lg-3 py-2 mt-5" type="submit" value="Proceed">
	                </div>

                </form>
            </div>

        </div>
        <div class="back-btn d-none d-lg-block">
            <a href="{{ route('guest-home') }}" class="text-dark fw-bold text-decoration-none me-3">
                &#8592;Home / Back
            </a>
        </div>
    </x-auth-card>
</x-guest-layout>