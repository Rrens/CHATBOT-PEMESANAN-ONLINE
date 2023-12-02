<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_TITLE') }} - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/icon/favicon.ico') }}" type="image/x-icon" />
</head>

<body>
    @include('sweetalert::alert')
    <div id="auth">

        <div id="auth-left">
            <div class="auth-logo">
                <a href="{{ route('login') }}"><img src="{{ asset('assets/img/logo.png') }}" alt="Logo"></a>
            </div>

            @yield('container')

        </div>
    </div>
</body>

</html>
