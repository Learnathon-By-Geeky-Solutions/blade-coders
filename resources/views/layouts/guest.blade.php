@props(['title'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '' }} :: {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <link href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/components/collapse.css', 'resources/css/components/dropdown.css', 'resources/css/components/modal.css', 'resources/css/components/nav.css', 'resources/css/components/navbar.css', 'resources/css/components/offcanvas.css', 'resources/css/components/prism.css', 'resources/css/components/toast.css', 'resources/css/components/tooltips.css', 'resources/js/app.js'])
</head>

<body>
    <div class="g-0 flex h-screen flex-col items-center justify-center px-4">
        <!-- card -->
        <div class="w-full max-w-md items-center justify-center rounded-md bg-white shadow md:mt-0 lg:flex xl:p-0">
            <!-- card body -->
            <div class="w-full p-6 sm:p-8 lg:p-8">
                <div class="mb-4">
                    <a href="{{ route('home') }}"><img class="mb-1"
                            src="{{ asset('assets/images/brand/logo/logo-primary.svg') }}" alt="" /></a>
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
