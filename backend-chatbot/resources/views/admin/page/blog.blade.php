@extends('admin.components.master')
@section('title', 'BLOG')
@push('head')
    <style>
        .color-card {
            background-color: rgb(14, 12, 27);
        }

        /* .img-container {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            position: relative;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            padding-top: 100%;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } */

        img {
            max-width: 500px;
        }

        body.theme-dark a {
            color: inherit;
            text-decoration: none !important;
        }
    </style>
    <style>
        .cards-wrapper {
            display: flex;
            justify-content: center;
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

        .carousel-inner {
            padding: 1em;
        }

        .carousel-control-prev,
        .carousel-control-next {
            background-color: #e1e1e1;
            width: 5vh;
            height: 5vh;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
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

        /* .note-editable {
                height: 50px !important;
            } */
    </style>
    <link rel="stylesheet" href="{{ asset('admin/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/extensions/summernote/summernote-lite.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/pages/simple-datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/pages/summernote.css') }}">
@endpush

@section('container')
    <div class="page-heading d-flex justify-content-between">
        <div class="flex-start">
            <h3>Blog</h3>
        </div>
        <div class="flex-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Add_modal"><i
                    class="bi bi-plus-circle"></i>&nbsp Tambah
                Blog</button>
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
                                            <th>Title</th>
                                            <th>Tags</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
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
                                                    <form action="{{ route('admin.blog.change_status') }}" method="post">
                                                        @csrf
                                                        <input type="number" name="id" value="{{ $item->id }}"
                                                            hidden>
                                                        <button type="submit"
                                                            class="btn btn-light-{{ $item->status == 'active' ? 'success' : 'danger' }}">{{ $item->status }}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.blog.edit', $item->id) }}"
                                                        class="btn btn-light-warning">Edit</a>
                                                    <button class="tagA btn btn-light-danger" data-bs-toggle="modal"
                                                        data-bs-target="#modalDelete{{ $item->id }}">Delete
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

    <div class="modal fade" id="Add_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Blog</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.blog.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="basicInput">Judul</label>
                            <input type="text" class="form-control mt-3" id="basicInput"
                                name="title"value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="summernote" class="mb-3">Konten</label>
                            <textarea id="summernote" name="content" required>{{ old('content') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="resume" class="mb-3">Resume</label>
                            <textarea id="resume" class="form-control" name="resume" rows="1" cols="1" required>{{ old('resume') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="summernote" class="mb-3">Gambar Blog</label>
                            <input type="file" class="form-control mt-3" id="basicInput" name="image"
                                value="{{ old('image') }}" required>
                        </div>
                        <div class="form-group mb-3 tags-input mt-3">
                            <label for="input-tag">Tag</label>
                            <ul id="tags"></ul>
                            <input id="arrayTag" name="arrayTag" type="array" hidden>
                            <textarea type="text" class="form-control mt-3" name="" value="" id="input-tag"
                                placeholder="Masukan nama tag"></textarea>
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
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Hapus Blog
                            {{ $item->title . ' ?' }}</h5>
                    </div>
                    <form action="{{ route('admin.blog.delete') }}" id="myForm" method="post">
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

    @foreach ($data as $item)
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
                            <label class="mb-3">Konten</label>
                            <div class="card">
                                {!! $item->content !!}
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-3">Resume</label>
                            <div class="card">
                                {!! $item->resume !!}
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
                            <ul>
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
    <script src="{{ asset('admin/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('admin/extensions/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('admin/js/pages/simple-datatables.js') }}"></script>
    <script src="{{ asset('admin/js/pages/summernote.js') }}"></script>

    <script>
        let dataTag = []
        let tag_data = []
        let arrayBaru = []
        const tags = document.getElementById('tags');
        const input = document.getElementById('input-tag');
        const arrayTagInput = document.getElementById('arrayTag');

        function removeArrayTagInput(nilai) {
            let indexToRemove = arrayBaru.indexOf(nilai);
            if (indexToRemove !== -1) {
                arrayBaru.splice(indexToRemove, 1);
            }
            let jsonArray = JSON.stringify(arrayBaru);
            $('#arrayTag').val(jsonArray);
        }

        function updateArrayTagInput() {
            $("#tags li").each(function(index) {
                let value = $(this).find('td:eq(1)')['prevObject'][0]['innerText'].split('X')[0];
                tag_data.push(value)
            });

            for (var i = 0; i < tag_data.length; i++) {
                let index = arrayBaru.indexOf(tag_data[i])
                if (index === -1) {
                    arrayBaru.push(tag_data[i]);
                }
            }

            let jsonArray = JSON.stringify(arrayBaru);
            $('#arrayTag').val(jsonArray);
        }

        input.addEventListener('keydown', function(event) {

            if (event.key === 'Enter') {
                const tag = document.createElement('li');

                const tagContent = input.value.trim();
                if (tagContent !== '') {
                    tag.innerText = tagContent;
                    tag.innerHTML += '<button class="delete-button">X</button>';
                    tags.appendChild(tag);
                    input.value = '';
                }
                dataTag.push(tagContent);
                updateArrayTagInput();
            }
        });

        tags.addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-button')) {
                var liElement = event.target.parentNode;
                var textInsideLi = liElement.textContent.trim();
                var textWithoutX = textInsideLi.replace('X', '');
                removeArrayTagInput(textWithoutX)
                event.target.parentNode.remove();
            }
        });
    </script>
@endpush
