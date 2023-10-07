@extends('admin.components.master')
@section('title', 'GALERY')
@push('head')
    <style>
        .cards-wrapper {
            display: flex;
            justify-content: center;
        }

        .color-card {
            background-color: rgb(14, 12, 27) !important;
        }

        .card img {
            max-width: 100%;
            max-height: 100%;
        }

        .card {
            margin: 0 0.5em;
            box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
            border: none;
            border-radius: 0;
        }

        @media (min-width: 768px) {
            .card img {
                height: 11em;
            }
        }

        /* TAGS */
        .tags-input {
            display: inline-block;
            position: relative;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
            box-shadow: 2px 2px 5px #00000033;
            width: 100%;
        }

        .tags-input ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tags-input li {
            display: inline-block;
            background-color: #f2f2f2;
            color: #333;
            border-radius: 20px;
            padding: 5px 10px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .tags-input input[type="text"] {
            border: none;
            outline: none;
            padding: 5px;
            font-size: 14px;
        }

        .tags-input input[type="text"]:focus {
            outline: none;
        }

        .tags-input .delete-button {
            background-color: transparent;
            border: none;
            color: #999;
            cursor: pointer;
            margin-left: 5px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('admin/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/extensions/summernote/summernote-lite.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/pages/simple-datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/pages/summernote.css') }}">
@endpush

@section('container')
    <div class="page-heading d-flex justify-content-between">
        <div class="flex-start">
            <h3>Galery</h3>
        </div>
        <div class="flex-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Add_modal"><i
                    class="bi bi-plus-circle"></i>&nbsp Tambah
                Galery</button>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="margin-top:2.2rem">
                            <div class="card-body">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Brand</th>
                                            <th>Image</th>
                                            <th>Detail</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->alt }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/uploads/galeries/' . $item->image) }}"
                                                        class="card-img-top img-fluid" alt="{{ $item->alt }}"
                                                        style="width: 350px; height: 200px">
                                                </td>
                                                <td>
                                                    <button class="btn btn-light-primary" data-bs-toggle="modal"
                                                        data-bs-target="#modalDelete{{ $item->id }}">Hapus</button>
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.galery.change_status') }}" method="post">
                                                        @csrf
                                                        <input type="number" name="id" value="{{ $item->id }}"
                                                            hidden>
                                                        <button
                                                            class="btn btn-light-{{ $item->status == 'active' ? 'success' : 'danger' }}"
                                                            type="submit">{{ $item->status == 'active' ? 'Active' : 'Deactive' }}
                                                        </button>
                                                    </form>
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

    <div class="modal fade" id="Add_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Gambar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.galery.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="basicInput">Title</label>
                            <input type="text" class="form-control mt-3" name="alt" />
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Image</label>
                            <input type="file" class="form-control mt-3" name="images[]" multiple />
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
        <div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Hapus Galery</h5>
                    </div>
                    <form action="{{ route('admin.galery.delete') }}" id="myForm" method="post">
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
