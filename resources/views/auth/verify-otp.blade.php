<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div class="w-100 m-auto text-center p-2 p-md-5 pb-md-0">
                <a href="{{ route('home') }}" title="Go to home" class="" rel="home">
                      <img class="site_logo" id="logo" src="{{ asset('img/logo-dark.png') }}" alt="ATAA HAI">
                </a>
            </div>
        </x-slot>
        <div class="w-50 m-auto">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-danger text-center" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4 text-danger text-center" :errors="$errors" />

            <form method="POST" action="{{ route('check_otp') }}" class="text-primary fw-bold p-3 p-md-5 rounded-3">
                @csrf
                <input type="hidden" value="c" name="role" id="role">
                <!-- Name -->
                <div class="row justify-content-center">
                    <x-label class="col-4 py-2" for="name" :value="__('Enter Otp :')" />

                    <x-input class="col-6 block mt-1 w-full border border-none rounded" id="otp" type="number" maxlength="6" name="otp" required autofocus />
                </div>

                

                <div class="flex text-center justify-end mt-4">

                    <button type="submit" class="d-block m-auto mt-3 px-4 btn btn-primary">
                        Register
                    </button>
                </div>
            </form>
        </div>
        <div class="back-btn">
            <a href="{{ route('home') }}" class="text-primary fw-bold text-decoration-none me-3">
                &#8592;Back
            </a>
            <a href="{{ route('guest-home') }}" class="text-primary fw-bold text-decoration-none">
                Home
            </a>
        </div>
    </x-auth-card>
</x-guest-layout>



