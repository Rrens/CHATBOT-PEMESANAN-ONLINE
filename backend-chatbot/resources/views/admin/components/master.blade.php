<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BJA Logistic - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('admin/css/main/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/main/app-dark.css') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/img/icon/favicon.ico') }}" type="image/x-icon" />
    <link href="{{ asset('assets/img/icon/Logo-BJA.png') }}" rel="apple-touch-icon">

    <link rel="stylesheet" href="{{ asset('admin/css/shared/iconly.css') }}" />

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    @stack('head')
</head>

<body>
    @include('sweetalert::alert')
    <div id="app">
        @include('admin.components.sidebar')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            @yield('container')

            @include('admin.components.footer')
        </div>
    </div>


    @stack('scripts')
    <script src="{{ asset('admin/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/js/app.js') }}"></script>



</body>

</html>
