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

            <form method="POST" action="{{ route('register-new-admin') }}" class="text-dark fw-bold p-3 p-md-5 rounded-3">
                @csrf
                <input type="hidden" value="a" name="role" id="role">
                <!-- Name -->
                <div class="row justify-content-center">
                    <x-label class="col-lg-4 py-2" for="name" :value="__('Name :')" />

                    <x-input class="col-lg-6 block mt-1 w-full border border-none rounded py-2 py-lg-1" id="name" type="text" name="name" :value="old('name')" required autofocus />
                </div>

                <!-- Email Address -->
                <div class="mt-4 row justify-content-center">
                    <x-label class="col-4 py-2" for="email" :value="__('Email :')" />

                    <x-input id="email" class="col-6 block mt-1 w-full border border-none rounded" type="email" name="email" :value="old('email')" required />
                </div>

                <!-- Mobile Number -->
                <div class="mt-4 row justify-content-center">
                    <x-label class="col-lg-4 py-2" for="mobile" :value="__('Mobile Number :')" />

                    <x-input id="mobile" class="col-lg-6 block mt-1 w-full border border-none rounded py-2 py-lg-1" maxlength="10" type="text" name="mobile" :value="old('mobile')" />
                </div>

                <!-- Password -->
                <div>
                    <div class="mt-4 row justify-content-center">
                        <x-label class="col-lg-4 py-2" for="password" :value="__('Set Password :')" />

                        <x-input id="password" class="col-lg-6 block mt-1 w-full border border-none rounded py-2 py-lg-1"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                    </div>

                    <div class="flex text-center justify-end mt-2">
                        <button type="submit" class="d-block m-auto mt-3 px-4 btn btn-primary">
                            Register
                        </button>
                    </div>
                </div>

                <div class="flex text-center justify-end mt-4">
                    Already registered? 
                    <a class="text-decoration-underline text-sm text-dark" href="{{ route('admin-login') }}">
                        {{ __('Login') }}
                    </a>
                </div>
            </form>
        </div>
        <div class="back-btn d-none d-lg-block">
            <a href="{{ route('home') }}" class="text-dark fw-bold text-decoration-none me-3">
                &#8592;Back
            </a>
            <a href="{{ route('guest-home') }}" class="text-dark fw-bold text-decoration-none">
                Home
            </a>
        </div>
    </x-auth-card>

</x-guest-layout>



