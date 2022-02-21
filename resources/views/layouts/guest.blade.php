<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>MAHIR BHARAT</title>
        <link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="16x16" type="image/png">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Styles -->
        <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
        <link rel='stylesheet' id='extra_css-css'  href="{{asset('css/bootstrap.min.css') }}" media='screen' />
        <link rel="stylesheet" href="{{ asset('css/mystyle.css') }}">
        <!-- Scripts -->
        <script src="{{ asset('js/jquery.min.js') }}" id='jquery-core-js'></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
        <script src="https://kit.fontawesome.com/3d8c19b62e.js" crossorigin="anonymous"></script>
        @stack('scripts')
    </body>
</html>
