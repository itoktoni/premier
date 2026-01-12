<x-layout>
    <div class="row">

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-50">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-2 d-block text-truncate">Kotor Kemarin</span>
                            <h4 class="mb-1">
                                <span class="counter-value" data-target="{{ $kemarin }}"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-50">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-2 d-block text-truncate">Bersih</span>
                            <h4 class="mb-1">
                                <span class="counter-value" data-target="{{ $bersih }}"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-2 col-md-6">
            <!-- card -->
            <div class="card card-h-50">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="text-muted mb-2 d-block text-truncate">Kotor</span>
                            <h4 class="mb-1">
                                <span class="counter-value" data-target="{{ $kotor }}"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->

        <div class="col-xl-2 col-md-6">
            <!-- card -->
            <div class="card card-h-50">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="text-muted mb-2 d-block text-truncate">Reject</span>
                            <h4 class="mb-1">
                                <span class="counter-value" data-target="{{ $reject }}"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-2 col-md-6">
            <!-- card -->
            <div class="card card-h-50">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="text-muted mb-2 d-block text-truncate">Rewash</span>
                            <h4 class="mb-1">
                                <span class="counter-value" data-target="{{ $rewash }}"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

         <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-50">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-2 d-block text-truncate">Total Register</span>
                            <h4 class="mb-1">
                                <span class="counter-value" data-target="{{ $register }}"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

         <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-50">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-2 d-block text-truncate">Available Linen</span>
                            <h4 class="mb-1">
                                <span class="counter-value" data-target="{{ $available }}"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

         <div class="col-xl-2 col-md-6">
            <!-- card -->
            <div class="card card-h-50">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-2 d-block text-truncate">Pending Kotor</span>
                            <h4 class="mb-1">
                                <span class="counter-value" data-target="{{ $pending_kotor }}"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

         <div class="col-xl-2 col-md-6">
            <!-- card -->
            <div class="card card-h-50">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-2 d-block text-truncate">Pending Reject</span>
                            <h4 class="mb-1">
                                <span class="counter-value" data-target="{{ $pending_reject }}"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

         <div class="col-xl-2 col-md-6">
            <!-- card -->
            <div class="card card-h-50">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-2 d-block text-truncate">Pending Rewash</span>
                            <h4 class="mb-1">
                                <span class="counter-value" data-target="{{ $pending_rewash }}"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->


    </div><!-- end row-->

    <div class="row">
        <div class="col-xl-12">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm">
                            {!! $dkotor->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-12">
            <div class="card card-h-400">
                <!-- card body -->
                <div class="card-body">
                    {!! $dbersih->container() !!}
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-12">
            <div class="card card-h-400">
                <!-- card body -->
                <div class="card-body">
                    {!! $dperbandingan->container() !!}
                </div>
            </div>
        </div>

    </div>

    @push('footer')
    <script src="{{ @asset('vendor/larapex-charts/apexcharts.js') }}"></script>
    {{ $dkotor->script() }}
    {{ $dbersih->script() }}
    {{ $dperbandingan->script() }}


    <style>
        .apexcharts-legend-series{
            margin-bottom: 5px !important;
        }

        .apexcharts-legend{
            bottom: -5px !important;
        }

        .page-content {
            padding: 90px calc(20px / 2) 60px calc(20px / 2) !important;
        }
    </style>
    @endpush

</x-layout>
