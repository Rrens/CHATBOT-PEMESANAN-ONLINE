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
                                                            data-bs-target="#modalTracking"
                                                            onclick="approve({{ $item->id }})">Tracking
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

    {{-- @foreach ($data as $item) --}}
    <div class="modal fade" id="modalTracking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tracking Pesanan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">User Timeline</h5>
                            <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column"
                                id="timeline">
                                {{-- <tbody>

                                </tbody> --}}
                                {{-- <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl badge-warning"></i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <h4 class="timeline-title">Meeting with client</h4>
                                                <p>Meeting with USA Client, today at <a href="javascript:void(0);"
                                                        data-abc="true">12:00 PM</a></p>
                                                <span class="vertical-timeline-element-date">9:30 AM</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl badge-warning"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <p>Another meeting with UK client today, at <b class="text-danger">3:00
                                                        PM</b></p>
                                                <p>Yet another one, at <span class="text-success">5:00 PM</span>
                                                </p>
                                                <span class="vertical-timeline-element-date">12:25 PM</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-item vertical-timeline-element">
                                        <div>
                                            <span class="vertical-timeline-element-icon bounce-in">
                                                <i class="badge badge-dot badge-dot-xl badge-warning"> </i>
                                            </span>
                                            <div class="vertical-timeline-element-content bounce-in">
                                                <p>Another meeting with UK client today, at <b class="text-danger">3:00
                                                        PM</b></p>
                                                <p>Yet another one, at <span class="text-success">5:00 PM</span>
                                                </p>
                                                <span class="vertical-timeline-element-date">12:25 PM</span>
                                            </div>
                                        </div>
                                    </div> --}}
                            </div>
                        </div>
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
            </div>
        </div>
    </div>
    {{-- @endforeach --}}

@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function approve(id) {
            // $('#id_approve').val(id);
            // console.log(id)
            $.ajax({
                url: `/order/tracking/${id}`,
                method: 'GET',
                success: function(data) {
                    // console.log(data)
                    let data_resi = data.data.history;
                    console.log(data_resi)
                    let newRow = ' ';
                    $('#timeline').empty();
                    data_resi.forEach(value => {
                        const datetime = new Date(value.date);
                        const hours = datetime.getHours();
                        const minutes = datetime.getMinutes();
                        const ampm = hours >= 12 ? "PM" : "AM";
                        const formattedHours = hours % 12 || 12;
                        const formattedTime = `${formattedHours}:${minutes} ${ampm}`;

                        const date = new Date(value.date);
                        const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                        const months = [
                            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                        ];
                        const dayName = days[date.getDay()];
                        const day = date.getDate();
                        const month = months[date.getMonth()];
                        const year = date.getFullYear();

                        const formattedDate = `${dayName}, ${day} ${month} ${year}`;
                        newRow += `
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-warning"> </i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">${formattedDate}</h4>
                                        <p>${value.desc}</p>
                                        <span class="vertical-timeline-element-date" style="margin-right:10px;">${formattedTime}</span>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    $('#timeline').append(newRow);
                }
            })
        }
    </script>
@endpush

@push('head')
    <style>
        .mt-70 {
            margin-top: 70px;
        }

        .mb-70 {
            margin-bottom: 70px;
        }

        .card {
            box-shadow: 0 0.46875rem 2.1875rem rgba(4, 9, 20, 0.03), 0 0.9375rem 1.40625rem rgba(4, 9, 20, 0.03), 0 0.25rem 0.53125rem rgba(4, 9, 20, 0.05), 0 0.125rem 0.1875rem rgba(4, 9, 20, 0.03);
            border-width: 0;
            transition: all .2s;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(26, 54, 126, 0.125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1.25rem;
        }



        .vertical-timeline {
            width: 100%;
            position: relative;
            padding: 1.5rem 0 1rem;
        }

        .vertical-timeline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 67px;
            height: 100%;
            width: 4px;
            background: #e9ecef;
            border-radius: .25rem;
        }

        .vertical-timeline-element {
            position: relative;
            margin: 0 0 1rem;
        }

        .vertical-timeline--animate .vertical-timeline-element-icon.bounce-in {
            visibility: visible;
            animation: cd-bounce-1 .8s;
        }

        .vertical-timeline-element-icon {
            position: absolute;
            top: 0;
            left: 60px;
        }

        .vertical-timeline-element-icon .badge-dot-xl {
            box-shadow: 0 0 0 5px #fff;
        }

        .badge-dot-xl {
            width: 18px;
            height: 18px;
            position: relative;
        }

        .badge:empty {
            display: none;
        }


        .badge-dot-xl::before {
            content: '';
            width: 10px;
            height: 10px;
            border-radius: .25rem;
            position: absolute;
            left: 50%;
            top: 50%;
            margin: -5px 0 0 -5px;
            background: #fff;
        }

        .vertical-timeline-element-content {
            position: relative;
            margin-left: 90px;
            font-size: .8rem;
        }

        .vertical-timeline-element-content .timeline-title {
            font-size: .8rem;
            text-transform: uppercase;
            margin: 0 0 .5rem;
            padding: 2px 0 0;
            font-weight: bold;
        }

        .vertical-timeline-element-content .vertical-timeline-element-date {
            display: block;
            position: absolute;
            left: -100px;
            top: 0;
            padding-right: 10px;
            text-align: right;
            color: #adb5bd;
            font-size: .7619rem;
            white-space: nowrap;
        }

        .vertical-timeline-element-content:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
@endpush
