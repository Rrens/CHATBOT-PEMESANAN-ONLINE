@extends('admin.auth.components.master')
@section('title', 'LOGIN')

@section('container')
    <h1 class="auth-title">Log in.</h1>
    {{-- <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p> --}}

    <div class="center">
        <form action="" method="POST">
            @csrf
            <div class="form-group position-relative has-icon-left mb-4">
                <input name="email" type="email" class="form-control form-control-xl" placeholder="Email">
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
                <input name="password" type="password" class="form-control form-control-xl" placeholder="Password">
                <div class="form-control-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>
            {{-- <div class="form-check form-check-lg d-flex align-items-end">
                <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label text-gray-600" for="flexCheckDefault">
                    Keep me logged in
                </label>
            </div> --}}
            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
        </form>
        <div class="text-center mt-5 text-lg fs-4">
            {{-- <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="font-bold">Sign
                    up</a>.</p> --}}
            {{-- <p><a class="font-bold" href="{{ route('forgot-password') }}">Forgot password?</a>.</p> --}}
        </div>
    </div>
@endsection
