<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <link href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/apexcharts/dist/apexcharts.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/components/collapse.css', 'resources/css/components/dropdown.css', 'resources/css/components/nav.css', 'resources/css/components/navbar.css', 'resources/css/components/offcanvas.css', 'resources/css/components/prism.css', 'resources/css/components/toast.css', 'resources/css/components/tooltips.css', 'resources/js/app.js'])

    @routes
</head>

<body>
    <main>
        <div class="flex overflow-x-hidden" id="app-layout">
            @include('backend.layouts.sidebar')
            <div class="ml-[15.625rem] min-h-screen w-full min-w-[100vw] [transition:margin_0.25s_ease-out] md:min-w-0"
                id="app-layout-content">
                @include('backend.layouts.header')

                <!-- Page Content -->
                <div class="p-6">
                    <!-- Page Heading -->
                    @isset($header)
                        <div class="mb-4 flex items-center justify-between border-b border-gray-300 pb-4">
                            {{ $header }}
                        </div>
                    @endisset

                    {{ $slot }}
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/libs/feather-icons/dist/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>
    @stack('scripts')
</body>

</html>
