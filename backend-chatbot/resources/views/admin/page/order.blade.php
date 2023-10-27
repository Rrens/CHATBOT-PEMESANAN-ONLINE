@extends('admin.components.master')
@section('title', 'PESANAN')
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
            <h3>Pesanan</h3>
        </div>
        {{-- <div class="flex-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Add_modal"><i
                    class="bi bi-plus-circle"></i>&nbsp Tambah
                Pesanan</button>
        </div> --}}
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
                                            <th>ID Order</th>
                                            <th>Nomor Whatsapp</th>
                                            <th>Status User</th>
                                            <th>No Resi</th>
                                            <th>Alamat</th>
                                            <th>Detail</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-bold-500">
                                                    {{ $item->id }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->customer[0]->whatsapp }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item->customer[0]->is_distributor == 1 ? 'Distributor' : 'Customer' }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ empty($item->resi_number) ? '-' : $item->resi_number }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ empty($item->address) ? '-' : $item->address . ' | ' . $item->zipcode }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#modalDetail{{ $item->id }}"><i
                                                            class="bi bi-info-circle-fill"></i>
                                                    </button>
                                                </td>
                                                @if ($item->status == 1)
                                                    <td>
                                                        <button class="btn btn-light-warning btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#modalResi{{ $item->id }}">Beri resi
                                                        </button>
                                                        <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#modalDelete{{ $item->id }}">Tracking
                                                            Pesanan
                                                        </button>
                                                    </td>
                                                @else
                                                    <td>
                                                        <p>-</p>
                                                    </td>
                                                @endif

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

    @foreach ($data as $item)
        <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Diskon</th>
                                    <th>Harga Produk</th>
                                    <th>Harga Akhir</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_detail->where('id_order', $item->id) as $row)
                                    <tr>
                                        <td class="text-bold-500">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="text-bold-500">
                                            {{ $row->menu[0]->name }}
                                        </td>
                                        <td class="text-bold-500">
                                            {{ empty($row->promo[0]) ? '-' : $row->promo[0]->discount . '%' }}
                                        </td>
                                        <td class="text-bold-500">
                                            {{ $row->menu[0]->price }}
                                        </td>
                                        <td class="text-bold-500">
                                            {{ $row->price }}
                                        </td>
                                        <td>
                                            {{ $row->quantity }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($data as $item)
        <div class="modal fade" id="modalResi{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Beri Resi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('order.resi') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="product">Pilih Jasa Pengiriman</label>
                                <input type="number" name="id" value="{{ $item->id }}" hidden>
                                <select name="courier" class="form-select mt-3">
                                    <option hidden selected>Pilih...</option>
                                    @foreach ($data_list_courier as $item)
                                        <option value="{{ $item['code'] }}">{{ $item['description'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">Masukan Resi</label>
                                <input type="text" class="form-control mt-2" name="resi_number"
                                    value="{{ old('name') }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
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
