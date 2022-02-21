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

            <form method="POST" action="{{ route('customer_login') }}" class="fw-bold p-3 p-md-5 rounded-3">
                @csrf
                <input type="hidden" value="c" id="role" name="role">
                <!-- Email Address -->
                <div class="row justify-content-center">
                    <x-label class="col-lg-3 py-2" for="mobile" :value="__('Mobile :')" />

                    <x-input id="mobile" class="col-lg-6 block mt-1 w-full border border-none rounded py-2 py-lg-1" type="text" name="mobile" :value="old('mobile')" required autofocus/>
                </div>

                <!-- Password -->
                <div class="mt-4 row justify-content-center">
                    <x-label class="col-lg-3 py-2" for="password" :value="__('Password :')" />

                    <x-input id="password" class="col-lg-6 block mt-1 w-full border border-none rounded py-2 py-lg-1"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4 text-center">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex text-center justify-end mt-2">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-white" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button type="submit" class="d-block m-auto mt-3 px-4 btn btn-primary">
                        Log in
                    </button>
                </div>
                <div class="flex text-center justify-end mt-3">
                    Don't have an account? 
                    <a class="text-decoration-underline text-sm text-dark" href="{{ route('customer_register') }}">
                        {{ __('Register') }}
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
</x-guest-layout>
