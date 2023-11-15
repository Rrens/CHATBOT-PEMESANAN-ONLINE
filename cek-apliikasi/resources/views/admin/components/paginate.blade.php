@if (!empty($data[0]))
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-primary">
            <li class="page-item">
                <a class="page-link" href="{{ $data->previousPageUrl() }}">Previous</a>
            </li>
            @php
                $data_paginate = ceil($data->total() / $data->count());
            @endphp
            @if ($data->count() != $data->perPage())
                @for ($i = 1; $i <= $data->currentPage(); $i++)
                    <li class="page-item {{ $i == $data->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
            @else
                @for ($i = 1; $i <= $data_paginate; $i++)
                    <li class="page-item {{ $i == $data->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
            @endif
            <li class="page-item">
                <a class="page-link" href="{{ $data->nextPageUrl() }}">Next</a>
            </li>
        </ul>
    </nav>
@endif
