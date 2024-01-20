@extends('admin.components.master')
@section('title', 'TRASH')
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
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/summernote/summernote-lite.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/summernote.css') }}">
@endpush

@section('container')
    <div class="page-heading d-flex justify-content-start">
        <h3>Galery</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="margin-top:2.2rem">
                            <div class="card-body">
                                <p>Galery</p>
                                <div class="d-flex">
                                    @foreach ($galery as $item)
                                        <div class="col-4 mx-2">
                                            <div class="card-content color-card">
                                                <img class="img-fluid w-100"
                                                    src="{{ asset('storage/uploads/galeries/' . $item->image) }}"
                                                    alt="Card image cap">
                                            </div>
                                            <div class="card-footer color-card d-flex justify-content-between">
                                                <button class="btn btn-light-danger" data-bs-toggle="modal"
                                                    data-bs-target="#modalRestoreGalery{{ $item->id }}">Restore</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card" style="margin-top:2.2rem">
                            <div class="card-body">
                                <p>Blog</p>
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Tags</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($blog as $item)
                                            <tr>
                                                <td class="text-bold-500">
                                                    {{ $item->title }}
                                                </td>
                                                <td class="text-bold-500">
                                                    @foreach ($tags->where('id_blog', $item->id) as $row)
                                                        {{ $loop->last ? $row->name : $row->name . ',' }}
                                                    @endforeach
                                                </td>
                                                <td class="text-bold-500">
                                                    <a href="javascript:void"
                                                        class="btn btn-light-{{ $item->status == 'active' ? 'success' : 'danger' }}">
                                                        {{ $item->status }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <button class="tagA btn btn-light-danger" data-bs-toggle="modal"
                                                        data-bs-target="#modalRestoreBlog{{ $item->id }}">Restore
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class="tagA btn btn-light-primary" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalDetail{{ $item->id }}">Detail
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

    @foreach ($blog as $item)
        <div class="modal fade" id="modalRestoreBlog{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Restore {{ $item->title . '?' }}</h5>
                    </div>
                    <form action="{{ route('admin.trash.restore_blog') }}" id="myForm" method="post">
                        @csrf
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
                            <button type="submit" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Restore</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($galery as $item)
        <div class="modal fade" id="modalRestoreGalery{{ $item->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Restore Image?</h5>
                    </div>
                    <form action="{{ route('admin.trash.restore_galery') }}" id="myForm" method="post">
                        @csrf
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
                            <button type="submit" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Restore</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($blog as $item)
        <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Blog</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="basicInput">Judul</label>
                            <input type="text" class="form-control mt-3" id="basicInput"
                                name="title"value="{{ $item->title }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="summernote" class="mb-3">Konten</label>
                            <div class="card">
                                {!! $item->content !!}
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="blog_image" class="mb-3">Gambar Konten</label>
                            <center>
                                <img class="form-control" id="blog_image"
                                    src="{{ asset('storage/uploads/blog/' . $item->image) }}" alt="">
                            </center>
                        </div>
                        <div class="form-group mb-3 tags-input">
                            <label for="input-tag">Tag</label>
                            <ul id="tags">
                                @foreach ($tags->where('id_blog', $item->id) as $item)
                                    <li>{{ $item->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/extensions/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/summernote.js') }}"></script>
@endpush
