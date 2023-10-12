@extends('admin.components.master')
@section('title', 'PROMO')
@push('head')
    <style>
        .color-card {
            background-color: rgb(14, 12, 27);
        }

        img {
            max-width: 500px;
        }

        body.theme-dark a {
            color: inherit;
            text-decoration: none !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
@endpush

@section('container')
    <div class="page-heading d-flex justify-content-between">
        <div class="flex-start">
            <h3>Promo</h3>
        </div>
        <div class="flex-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Add_modal"><i
                    class="bi bi-plus-circle"></i>&nbsp Tambah
                Promo</button>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="margin-top:2.2rem">
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Promo</th>
                                            <th>Nama Barang</th>
                                            <th>diskon</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-bold-500">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->name }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->menu[0]->name }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->discount . '%' }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-light-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#modalUpdate{{ $item->id }}">Update
                                                    </button>
                                                    <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#modalDelete{{ $item->id }}">Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- @include('admin.components.paginate') --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <div class="modal fade" id="Add_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Promo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('promo.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="product">Produk</label>
                            <select name="menu" class="form-select mt-3">
                                <option hidden selected>Pilih Produk</option>
                                @foreach ($menus as $menu)
                                    <option value="{{ empty(old('menu')) ? $menu->id : old('menu') }}">
                                        {{ empty(old('menu')) ? $menu->name : old('menu') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">Nama Promo</label>
                            <input type="text" class="form-control mt-2" id="name"
                                name="name"value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount</label>
                            <div class="input-group">
                                <input type="number" class="form-control mt-2" name="discount"
                                    placeholder="Masukan berapa persen diskon">
                                <div class="input-group-append mt-2">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($data as $item)
        <div class="modal fade" id="modalUpdate{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Promo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('promo.update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="product">Produk</label>
                                <select name="menu" class="form-select mt-3">
                                    <option hidden selected>Pilih Produk</option>
                                    @foreach ($menus as $menu)
                                        <option value="{{ $menu->id }}"
                                            {{ $item->id_menu == $menu->id ? 'selected' : '' }}>
                                            {{ $menu->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">Nama Promo</label>
                                <input type="number" value="{{ $item->id }}" name="id" hidden>
                                <input type="text" class="form-control mt-2" id="name"
                                    name="name"value="{{ $item->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <div class="input-group">
                                    <input type="number" class="form-control mt-2" name="discount"
                                        value="{{ $item->discount }}" placeholder="Masukan berapa persen diskon">
                                    <div class="input-group-append mt-2">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($data as $item)
        <div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Hapus Promo
                            {{ $item->name . ' ?' }}</h5>
                    </div>
                    <form action="{{ route('promo.delete') }}" id="myForm" method="post">
                        @csrf
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
                            <button type="submit" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Delete</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endpush
