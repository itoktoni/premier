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
                                <span class="counter-value" data-target="27"></span>
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
                                <span class="counter-value" data-target="6258"></span>
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
                                <span class="counter-value" data-target="240"></span>
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
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Retur hari ini</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="230"></span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row-->

    <div class="row">
        <div class="col-xl-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm">
                            {!! $kotor->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-6">
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    {!! $bersih->container() !!}
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>

    @push('footer')
    <script src="{{ @asset('vendor/larapex-charts/apexcharts.js') }}"></script>
    {{ $kotor->script() }}
    {{ $bersih->script() }}
    @endpush

</x-layout>
