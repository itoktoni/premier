<x-layout>
    <div class="row">

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-50">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Bersih hari ini</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $bersih }}"></span>
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
                        <div class="col-6">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Kotor hari ini</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $kotor }}"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-50">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Reject hari ini</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $reject }}"></span>
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
                        <div class="col-6">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Rewash hari ini</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $rewash }}"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row-->

    <div class="row">
        <div class="col-xl-7">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm">
                            {!! $sebaran->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-5">
            <div class="card card-h-400">
                <!-- card body -->
                <div class="card-body">
                    {!! $perbandingan->container() !!}
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>

    @push('footer')
    <script src="{{ @asset('vendor/larapex-charts/apexcharts.js') }}"></script>
    {{ $sebaran->script() }}
    {{ $perbandingan->script() }}


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
