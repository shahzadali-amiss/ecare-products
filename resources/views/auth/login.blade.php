@extends('layouts.app')

@section('content')

    <section>
        <div class="container">
            <div class="row justify-content-center">
            
                <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">
                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                        <div class="crs_log_wrap">
                            <div class="crs_log__thumb">
                                <img src="{{ asset('theme/img/banner-2.jpg') }}" class="img-fluid" alt="" />
                            </div>
                            <div class="crs_log__caption">
                                <div class="rcs_log_123">
                                    <div class="rcs_ico"><i class="fas fa-lock"></i></div>
                                </div>
                                
                                <div class="rcs_log_124">
                                    <div class="Lpo09"><h4>Login Your Account</h4></div>
                                    <div class="form-group">
                                        <label>User Name</label>
                                        
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>

                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>
                                        
                                    </div>
                                </div>
                                <!-- <div class="rcs_log_125">
                                    <span>Or Login with Social Info</span>
                                </div>
                                <div class="rcs_log_126">
                                    <ul class="social_log_45 row">
                                        <li class="col-xl-4 col-lg-4 col-md-4 col-4"><a href="javascript:void(0);" class="sl_btn"><i class="ti-facebook text-info"></i>Facebook</a></li>
                                        <li class="col-xl-4 col-lg-4 col-md-4 col-4"><a href="javascript:void(0);" class="sl_btn"><i class="ti-google text-danger"></i>Google</a></li>
                                        <li class="col-xl-4 col-lg-4 col-md-4 col-4"><a href="javascript:void(0);" class="sl_btn"><i class="ti-twitter theme-cl"></i>Twitter</a></li>
                                    </ul>
                                </div> -->
                            </div>
                            <div class="crs_log__footer d-flex justify-content-between">
                                <div class="fhg_45"><p class="musrt">Don't have account? <a href="{{ route('register') }}" class="theme-cl">SignUp</a></p></div>

                                @if (Route::has('password.request'))
                                    <div class="fhg_45">
                                        <p class="musrt">
                                            <a href="{{ route('password.request') }}" class="text-danger">Forgot Password?</a>
                                        </p>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

@endsection
