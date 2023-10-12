@extends('admin.components.master')
@section('title', 'USER')
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
            <h3>USER MANAGEMENT</h3>
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
                                            <th>No Whatsapp</th>
                                            <th>Status Distributor</th>
                                            <th>Status Blokir</th>
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
                                                    {{ $item->whatsapp }}
                                                </td>
                                                <td class="text-bold-500">
                                                    <span
                                                        class="btn btn-light-{{ $item->is_distributor == 1 ? 'success' : 'primary' }} btn-sm">{{ $item->is_distributor == 1 ? 'Distributor' : 'Customer' }}</span>
                                                </td>
                                                <td class="text-bold-500">
                                                    <span
                                                        class="btn btn-light-{{ $item->is_block == 1 ? 'danger' : 'success' }} btn-sm">{{ $item->is_block == 1 ? 'Diblokir' : 'Tidak diblokir' }}</span>
                                                </td>
                                                <td>
                                                    <button
                                                        class="btn btn-light-{{ $item->request_distributor == 1 ? 'warning' : 'primary' }} btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalDistributor{{ $item->id }}">
                                                        {{ $item->request_distributor == 1 ? 'reques distributor' : 'Rubah status' }}
                                                    </button>
                                                    <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#modalBlock{{ $item->id }}">Blokir
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

    @foreach ($data as $item)
        <div class="modal fade" id="modalBlock{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Blokir Customer
                            {{ $item->whatsapp }}</h5>
                    </div>
                    <form action="{{ route('user.block_user') }}" id="myForm" method="post">
                        @csrf
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <input type="number" value="{{ $item->whatsapp }}" name="whatsapp" hidden>
                            <input type="number" value="{{ $item->is_block }}" name="is_block" hidden>
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

    @foreach ($data as $item)
        <div class="modal fade" id="modalDistributor{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Merubah Status Customer
                            {{ $item->whatsapp . ' ?' }}</h5>
                    </div>
                    <form action="{{ route('user.change_status_user') }}" id="myForm" method="post">
                        @csrf
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <input type="number" value="{{ $item->whatsapp }}" name="whatsapp" hidden>
                            <input type="number" value="{{ $item->is_distributor }}" name="is_distributor" hidden>

                            <button type="submit" class="btn btn-success ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Update</span>
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
