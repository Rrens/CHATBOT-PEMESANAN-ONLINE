@extends('admin.components.master')
@section('title', 'DASHBOARD')

@section('container')
    <div class="page-heading">
        <p>All System are running smothly! you have 3 unread</p>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <a href="">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon purple mb-2">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                Number of Omzet
                                            </h6>
                                            <h6 class="font-extrabold mb-0">
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Order Details</h4>
                                <p>The total number of sessions within the date range. It is the period time a user is
                                    actively engaged with your website, page or app, etc</p>
                            </div>
                            <div class="card-body">
                                {{-- <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-primary" width="32" height="32" fill="blue"
                                                style="width: 10px">
                                                <use xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            <h5 class="mb-0 ms-3">Europe</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="mb-0">862</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-europe"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-success" width="32" height="32" fill="blue"
                                                style="width: 10px">
                                                <use xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            <h5 class="mb-0 ms-3">America</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="mb-0">375</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-america"></div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    {{-- <div class="col-6 d-flex">
                                        <h5 class="mb-0" style="margin-right: 10px">Order Value 1025</h5>
                                        <h5 class="mb-0" style="margin-right: 10px">Orders 1025</h5>
                                        <h5 class="mb-0" style="margin-right: 10px">Users 1025</h5>
                                        <h5 class="mb-0" style="margin-right: 10px">Sales 1025</h5>
                                    </div> --}}
                                    <div class="col-12">
                                        <div id="chart-order"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6">
                        <div class="card">

                            <div class="card-header">
                                <h4></h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Order</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <p class="font-bold ms-3 mb-0"></p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">
                                                    </p>
                                                </td>
                                                <td>
                                                    <div class="col-auto">
                                                        <p class="mb-0"></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @push('scripts')
                <script src="{{ asset('admin/extensions/apexcharts/apexcharts.min.js') }}"></script>
                <script>
                    var areaOptions = {
                        series: [
                            // {
                            //     name: "Order",
                            //     data: ,
                            // },
                            {
                                name: "series2",
                                data: [11, 32, 45, 32, 34, 52, 41],
                            },
                        ],
                        chart: {
                            height: 350,
                            type: "area",
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        stroke: {
                            curve: "smooth",
                        },
                        xaxis: {
                            type: "datetime",
                            categories: ,
                        },
                        tooltip: {
                            x: {
                                format: "dd/MM/yy HH:mm",
                            },
                        },
                    };

                    var area = new ApexCharts(document.querySelector("#chart-order"), areaOptions);

                    area.render();
                </script>
            @endpush
        </section>
    </div>
@endsection
