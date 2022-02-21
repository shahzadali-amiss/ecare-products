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

            <form method="POST" action="{{ route('customer_register') }}" class="text-dark fw-bold p-3 p-md-5 rounded-3">
                @csrf
                <input type="hidden" value="c" name="role" id="role">
                <!-- Name -->
                <div class="row justify-content-center">
                    <x-label class="col-lg-4 py-2" for="name" :value="__('Name :')" />

                    <x-input class="col-lg-6 block mt-1 w-full border border-none rounded py-2 py-lg-1" id="name" type="text" name="name" :value="old('name')" required autofocus />
                </div>

                <!-- Email Address -->
                <!-- <div class="mt-4 row justify-content-center">
                    <x-label class="col-4 py-2" for="email" :value="__('Email :')" />

                    <x-input id="email" class="col-6 block mt-1 w-full border border-none rounded" type="email" name="email" :value="old('email')" required />
                </div>
 -->
                <!-- Mobile Number -->
                <div class="mt-4 row justify-content-center">
                    <x-label class="col-lg-4 py-2" for="mobile" :value="__('Mobile Number :')" />

                    <x-input id="mobile" class="col-lg-6 block mt-1 w-full border border-none rounded py-2 py-lg-1" maxlength="10" type="text" name="mobile" :value="old('mobile')" />
                </div>

                

                <!-- Confirm Password -->
                <!-- <div class="mt-4 row justify-content-center">
                    <x-label class="col-4 py-2" for="password_confirmation" :value="__('Confirm Password :')" />

                    <x-input id="password_confirmation" class="col-6 block mt-1 w-full border border-none rounded"
                                    type="password"
                                    name="password_confirmation" required />
                </div> -->
                <div class="mt-4 row justify-content-center">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-6 px-0">
                        <div class="row justify-content-center">
                            <div class="col-10 col-lg-5 d-none" id="otp">
                                <x-input maxlength="4" class="w-100 py-2 px-2 border border-none rounded" maxlength="4" autocomplete="off" type="text" name="otp" placeholder="Enter OTP" />           
                            </div>
                            <div class="col-1 d-none py-2" id="tick_icon"><i class="fas fa-check-circle text-success"></i></div>
                            <div class="col-lg-6 mt-4 mt-lg-0">
                                <button type="button" id="send-otp" class="py-2 w-100 m-auto px-4 btn btn-primary" disabled>
                                    Request OTP
                                </button>
                            </div>
                        </div>    
                    </div>
                </div>
                <!-- Password -->
                <div id="dynamicfield" class="d-none">
                    <div class="mt-4 row justify-content-center d-none">
                        <x-label class="col-lg-4 py-2" for="password" :value="__('Set Password :')" />

                        <x-input id="password" class="col-lg-6 block mt-1 w-full border border-none rounded py-2 py-lg-1"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                    </div>

                    <div class="flex text-center justify-end mt-2 d-none">
                        <button type="submit" class="d-block m-auto mt-3 px-4 btn btn-primary">
                            Register
                        </button>
                    </div>
                </div>

                <div class="flex text-center justify-end mt-4">
                    Already registered? 
                    <a class="text-decoration-underline text-sm text-dark" href="{{ route('customer_login') }}">
                        {{ __('Login') }}
                    </a>
                </div>
            </form>
        </div>
        <div class="back-btn d-none d-lg-block">
            <a href="{{ route('guest-home') }}" class="text-dark fw-bold text-decoration-none me-3">
                &#8592;Home / Back
            </a>
        </div>
    </x-auth-card>
@push('scripts')
    <script>
        jQuery(document).ready(function($){
            var origOtp;
            $('#mobile').on('keyup', function(){
                if($(this).val().length==10){
                    $('#send-otp').attr('disabled', false);                    
                }else{
                    $('#send-otp').attr('disabled', true);
                }
            });

            $('#send-otp').click(function(){
                var url = '/api/check-user/'+($('#mobile').val())+'/'+($('#role').val());
                $.get(url, function(data, status){
                    console.log(data.status);
                    if(data.status=='otp'){
                        var data2=data.data.user;
                        origOtp=data.data.otp;
                        //console.log(data2);
                        $('#name').attr('readonly', true);
                        $('#mobile').attr('readonly', true);
                        bindMoreInputs(data2);
                    }else{
                        alert('User already exist');
                    }
                });
            });
            function bindMoreInputs(data){
                if(data.length==0){
                    $('#otp').removeClass('d-none');
                    $('#send-otp').text('Resend OTP');
                }
            }

            $('#otp input').on('keyup', function(){
                if($(this).val().length==4){
                    if($(this).val()==origOtp){
                        $('#dynamicfield').removeClass('d-none');
                        $('#dynamicfield>div').removeClass('d-none');
                        $('#tick_icon').removeClass('d-none');
                    }else{
                        $('#dynamicfield').addClass('d-none');
                        $('#dynamicfield>div').addClass('d-none');
                        $('#tick_icon').addClass('d-none');
                    }
                } 
            });
        });
    </script>
@endpush
</x-guest-layout>



