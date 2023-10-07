@extends('tenant.auth.components.master')
@section('title', 'LOGIN')

@section('container')
    <h1 class="auth-title">Sign Up</h1>
    {{-- <p class="auth-subtitle mb-5">Input your data to register to our website.</p> --}}

    <form action="{{ route('post_register') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control form-control-xl" placeholder="Name" name="name">
            <div class="form-control-icon">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control form-control-xl" placeholder="Username" name="username">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control form-control-xl" placeholder="Email" name="email">
            <div class="form-control-icon">
                <i class="bi bi-envelope"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <select class="form-select form-select-xl" name="sex">
                <option selected hidden>Pilih Jenis Kelamin</option>
                <option value="0">Laki-laki</option>
                <option value="1">Perempuan</option>
            </select>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control form-control-xl" placeholder="Password" name="password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="number" class="form-control form-control-xl" placeholder="Phone Number" name="phone">
            <div class="form-control-icon">
                <i class="bi bi-phone"></i>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="basicInput">Upload Foto Produk</label>
            <input class="form-control mt-2" type="file" name="image" id="formFile">
        </div>
        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
    </form>
    <div class="text-center mt-5 text-lg fs-4">
        <p class='text-gray-600'>Already have an account? <a href="{{ route('login') }}" class="font-bold">Log
                in</a>.</p>
    </div>
@endsection
