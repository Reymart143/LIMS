@extends('layouts.app')
@section('content')
<script>
    window.chartData = {
        months: @json($months),
        totalRla: @json($totalRla),
        totalRelease: @json($totalRelease)
    };
</script>
@php
    $totalLabTest = DB::table('lf_06_02')->count();
    $totalEquipment = DB::table('lf_03_05')->count();
    $orderForPayment = DB::table('lf_06_03')->count();
    $jobRouteForm = DB::table('lf_06_04')->count();
    $totalReleasing = DB::table('lf_06_02')->where('status', 8)->count();
    $totalClients = DB::table('clients')->count();
    $registeredEquipments = DB::table('lf_03_05')->count();
    $sampleStorageLogbooks = DB::table('sample_storage_logbooks')->count();
@endphp

    <div class="container-fluid py-0" style="width: 95%">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="row row-cols-1">
                    <div class="overflow-hidden d-slider1">
                        <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">

                            <!-- Total Lab Test -->
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">

                                        <div class="icon bg-primary text-white rounded p-3">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="white">
                                                <path d="M9 2V4H10V9.59L5.29 14.29C4.4 15.18 4 16.39 4 17.66A4.34 4.34 0 0 0 8.34 22H15.66A4.34 4.34 0 0 0 20 17.66C20 16.39 19.6 15.18 18.71 14.29L14 9.59V4H15V2H9Z"/>
                                            </svg>
                                        </div>

                                        <div class="text-end">
                                            <p class="mb-1">Total Lab Test</p>
                                            <h4 class="mb-0">{{ $totalLabTest ?: '' }}</h4>
                                        </div>

                                    </div>
                                </div>
                            </li>

                            <!-- Order for Payment -->
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">

                                        <div class="icon bg-success text-white rounded p-3">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="white">
                                            <path d="M2 6H22V18H2V6M4 8V16H20V8H4M12 9C10.34 9 9 10.34 9 12S10.34 15 12 15 15 13.66 15 12 13.66 9 12 9Z"/>
                                        </svg>
                                        </div>

                                        <div class="text-end">
                                            <p class="mb-1"> Equipments </p>
                                            <h4 class="mb-0">{{ $totalEquipment ?: '' }}</h4>
                                        </div>

                                    </div>
                                </div>
                            </li>

                            <!-- Job Route Form -->
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">

                                        <div class="icon bg-info text-white rounded p-3">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="white">
                                            <path d="M19 3H14.82C14.4 1.84 13.3 1 12 1S9.6 1.84 9.18 3H5C3.89 3 3 3.89 3 5V21C3 22.11 3.89 23 5 23H19C20.11 23 21 22.11 21 21V5C21 3.89 20.11 3 19 3Z"/>
                                        </svg>
                                        </div>

                                        <div class="text-end">
                                            <p class="mb-1">Job Route Form</p>
                                            <h4 class="mb-0">{{ $jobRouteForm ?: '' }}</h4>
                                        </div>

                                    </div>
                                </div>
                            </li>

                            <!-- Releasing -->
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">

                                        <div class="icon bg-warning text-white rounded p-3">
                                            <svg width="30" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M12 2A10 10 0 1 0 22 12A10 10 0 0 0 12 2M10 17L5 12L6.41 10.59L10 14.17L17.59 6.59L19 8Z"/>
                                            </svg>
                                        </div>

                                        <div class="text-end">
                                            <p class="mb-1">Releasing</p>
                                            <h4 class="mb-0">{{ $totalReleasing ?: '' }}</h4>
                                        </div>

                                    </div>
                                </div>
                            </li>

                            <!-- Clients -->
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">

                                        <div class="icon bg-danger text-white rounded p-3">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="white">
                                                <path d="M16 11C17.66 11 19 9.66 19 8S17.66 5 16 5 13 6.34 13 8 14.34 11 16 11M8 11C9.66 11 11 9.66 11 8S9.66 5 8 5 5 6.34 5 8 6.34 11 8 11M8 13C5.33 13 0 14.34 0 17V19H16V17C16 14.34 10.67 13 8 13Z"/>
                                            </svg>
                                        </div>

                                        <div class="text-end">
                                            <p class="mb-1">Customers</p>
                                            <h4 class="mb-0">{{ $totalClients ?: '' }}</h4>
                                        </div>

                                    </div>
                                </div>
                            </li>

                        
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1300">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">

                                        <div class="icon bg-dark text-white rounded p-3">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="white">
                                                <path d="M12 3C7.58 3 4 4.79 4 7V17C4 19.21 7.58 21 12 21S20 19.21 20 17V7C20 4.79 16.42 3 12 3Z"/>
                                            </svg>
                                        </div>

                                        <div class="text-end">
                                            <p class="mb-1">Sample Storage Logbook</p>
                                            <h4 class="mb-0">{{ $sampleStorageLogbooks ?: '' }}</h4>
                                        </div>

                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                        <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                            <div class="header-title">
                                <h4 class="card-title">Total</h4>
                                <p class="mb-0">RLA & Releasing Documents</p>          
                            </div>
                            <div class="d-flex align-items-center align-self-center">
                                <div class="d-flex align-items-center text-primary">
                                    <svg class="icon-12" xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24" fill="currentColor">
                                    <g>
                                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                    </g>
                                    </svg>
                                    <div class="ms-2">
                                    <span class="text-gray">RLA</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center ms-3 text-info">
                                    <svg class="icon-12" xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24" fill="currentColor">
                                    <g>
                                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                    </g>
                                    </svg>
                                    <div class="ms-2">
                                    <span class="text-gray">Release</span>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <div id="d-main" class="d-main"></div>
                        </div>
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card credit-card-widget" data-aos="fade-up" data-aos-delay="900">
                            <div class="pb-4 border-0 card-header">
                        </div>
                        <div class="card-body">
                            @php
                                $year = date('Y');

                                $yearlyGrandTotal = DB::table('lf_06_02')
                                    ->whereYear('date_payment', $year)
                                    ->sum(DB::raw("CAST(REPLACE(payment, ',', '') AS DECIMAL(15,2))"));
                            @endphp

                                <div class="mb-4">
                                    <div class="flex-wrap d-flex justify-content-between">

                                     <h2 class="mb-2">
                                        {{ $yearlyGrandTotal > 0 ? '₱ ' . number_format($yearlyGrandTotal, 2) : '₱ 0.00' }}
                                    </h2>

                                        <div>
                                            <span class="badge bg-success rounded-pill">
                                                {{ date('Y') }}
                                            </span>
                                        </div>

                                    </div>

                                    <p class="text-info">Customer Payments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
</div>
  
@endsection