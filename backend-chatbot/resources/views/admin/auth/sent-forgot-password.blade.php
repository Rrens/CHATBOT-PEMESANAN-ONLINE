@extends('tenant.auth.components.master-message')
@section('title', 'SENT EMAIL SUCCESSFULLY')
@section('container')
    <div id="error">


        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="{{ asset('assets/images/mail-min.png') }}" alt="Not Found">
                    <h1 class="error-title">E-mail successfully sent</h1>
                    <p class="fs-5 text-gray-600">please check your email inbox</p>
                    <a href="{{ route('login') }}" class="btn btn-lg btn-outline-primary mt-3">Go Login</a>
                </div>
            </div>
        </div>


    </div>
@endsection
