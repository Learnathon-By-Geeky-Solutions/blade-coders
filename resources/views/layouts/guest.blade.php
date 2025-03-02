<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" />

        <link rel="stylesheet" href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/css/components/collapse.css',
            'resources/css/components/dropdown.css',
            'resources/css/components/nav.css',
            'resources/css/components/navbar.css',
            'resources/css/components/offcanvas.css',
            'resources/css/components/prism.css',
            'resources/css/components/toast.css',
            'resources/css/components/tooltips.css',
            'resources/js/app.js'
        ])
    </head>
    <body>
        <div class="flex flex-col items-center justify-center g-0 h-screen px-4">
            <!-- card -->
            <div class="justify-center items-center w-full bg-white rounded-md shadow lg:flex md:mt-0 max-w-md xl:p-0">
                <!-- card body -->
                <div class="p-6 w-full sm:p-8 lg:p-8">
                    <div class="mb-4">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/images/brand/logo/logo-primary.svg') }}" class="mb-1" alt="" /></a>
                        <p class="mb-6">Please enter your user information.</p>
                    </div>
                    <!-- form -->
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/libs/feather-icons/dist/feather.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/theme.js') }}"></script>
    </body>
</html>
