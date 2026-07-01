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
    $orderForPayment = DB::table('lf_06_03')->count();
    $jobRouteForm = DB::table('lf_06_04')->count();
    $totalReleasing = DB::table('lf_06_02')->where('status', 8)->count();
    $totalClients = DB::table('clients')->count();
    $registeredEquipments = DB::table('lf_03_05')->count();
    $sampleStorageLogbooks = DB::table('sample_storage_logbooks')->count();
@endphp

    <div class="container-fluid content-inner mt-n5 py-0">
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
                        <p class="mb-1"> -- </p>
                        <h4 class="mb-0">--</h4>
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

        <!-- Registered Equipments -->
        {{-- <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1200">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">

                    <div class="icon bg-secondary text-white rounded p-3">
                       <svg width="28" height="28" viewBox="0 0 24 24" fill="white">
    <path d="M22.7 19L13.6 9.9C14.5 7.6 14 4.9 12.1 3C10.1 1 7 0.6 4.6 1.8L8.5 5.7L5.7 8.5L1.8 4.6C0.6 7 1 10.1 3 12.1C4.9 14 7.6 14.5 9.9 13.6L19 22.7C19.4 23.1 20 23.1 20.4 22.7L22.7 20.4C23.1 20 23.1 19.4 22.7 19Z"/>
</svg>
                    </div>

                    <div class="text-end">
                        <p class="mb-1"> Equipments</p>
                        <h4 class="mb-0">{{ $registeredEquipments ?: '' }}</h4>
                    </div>

                </div>
            </div>
        </li> --}}

        <!-- Sample Storage -->
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

    <div class="swiper-button swiper-button-next"></div>
    <div class="swiper-button swiper-button-prev"></div>
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
                        {{-- <div class="dropdown">
                            <a href="#" class="text-gray dropdown-toggle" id="dropdownMenuButton22" data-bs-toggle="dropdown" aria-expanded="false">
                            This Week
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton22">
                                <li><a class="dropdown-item" href="#">This Week</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <div id="d-main" class="d-main"></div>
                    </div>
                    </div>
                </div>
                {{-- <div class="col-md-12 col-xl-6">
                    <div class="card" data-aos="fade-up" data-aos-delay="900">
                    <div class="flex-wrap card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Earnings</h4>            
                        </div>   
                        <div class="dropdown">
                            <a href="#" class="text-gray dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                This Week
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#">This Week</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="flex-wrap d-flex align-items-center justify-content-between">
                            <div id="myChart" class="col-md-8 col-lg-8 myChart"></div>
                            <div class="d-grid gap col-md-4 col-lg-4">
                                <div class="d-flex align-items-start">
                                <svg class="mt-2 icon-14" xmlns="http://www.w3.org/2000/svg" width="14" viewBox="0 0 24 24" fill="#3a57e8">
                                    <g>
                                        <circle cx="12" cy="12" r="8" fill="#3a57e8"></circle>
                                    </g>
                                </svg>
                                <div class="ms-3">
                                    <span class="text-gray">Fashion</span>
                                    <h6>251K</h6>
                                </div>
                                </div>
                                <div class="d-flex align-items-start">
                                <svg class="mt-2 icon-14" xmlns="http://www.w3.org/2000/svg" width="14" viewBox="0 0 24 24" fill="#4bc7d2">
                                    <g>
                                        <circle cx="12" cy="12" r="8" fill="#4bc7d2"></circle>
                                    </g>
                                </svg>
                                <div class="ms-3">
                                    <span class="text-gray">Accessories</span>
                                    <h6>176K</h6>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div> --}}
                {{-- <div class="col-md-12 col-xl-6">
                    <div class="card" data-aos="fade-up" data-aos-delay="1000">
                    <div class="flex-wrap card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Conversions</h4>            
                        </div>
                        <div class="dropdown">
                            <a href="#" class="text-gray dropdown-toggle" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                This Week
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton3">
                                <li><a class="dropdown-item" href="#">This Week</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="d-activity" class="d-activity"></div>
                    </div>
                    </div>
                </div>         
              --}}
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card credit-card-widget" data-aos="fade-up" data-aos-delay="900">
                    <div class="pb-4 border-0 card-header">
                        {{-- <div class="p-4 border border-white rounded primary-gradient-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                <h5 class="font-weight-bold">VISA </h5>
                                <P class="mb-0">PREMIUM ACCOUNT</P>  
                                </div>
                                <div class="master-card-content">
                                <svg class="master-card-1 icon-60" width="60"  viewBox="0 0 24 24">
                                    <path fill="#ffffff" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                </svg>
                                <svg class="master-card-2 icon-60" width="60"  viewBox="0 0 24 24">
                                    <path fill="#ffffff" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                </svg>
                                </div>
                            </div>
                            <div class="my-4">
                                <div class="card-number">
                                <span class="fs-5 me-2">5789</span>
                                <span class="fs-5 me-2">****</span>
                                <span class="fs-5 me-2">****</span>
                                <span class="fs-5">2847</span>
                                </div>
                            </div>
                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                <p class="mb-0">Card holder</p>
                                <p class="mb-0">Expire Date</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>Mike Smith</h6>
                                <h6 class="ms-5">06/11</h6>
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <div class="flex-wrap mb-4 d-flex align-itmes-center justify-content-between">
                            <div class="d-flex align-itmes-center me-0 me-md-4">
                                <div>
                                {{--   <div class="p-3 mb-2 rounded bg-soft-primary">
                                  <svg class="icon-20"  width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.9303 7C16.9621 6.92913 16.977 6.85189 16.9739 6.77432H17C16.8882 4.10591 14.6849 2 12.0049 2C9.325 2 7.12172 4.10591 7.00989 6.77432C6.9967 6.84898 6.9967 6.92535 7.00989 7H6.93171C5.65022 7 4.28034 7.84597 3.88264 10.1201L3.1049 16.3147C2.46858 20.8629 4.81062 22 7.86853 22H16.1585C19.2075 22 21.4789 20.3535 20.9133 16.3147L20.1444 10.1201C19.676 7.90964 18.3503 7 17.0865 7H16.9303ZM15.4932 7C15.4654 6.92794 15.4506 6.85153 15.4497 6.77432C15.4497 4.85682 13.8899 3.30238 11.9657 3.30238C10.0416 3.30238 8.48184 4.85682 8.48184 6.77432C8.49502 6.84898 8.49502 6.92535 8.48184 7H15.4932ZM9.097 12.1486C8.60889 12.1486 8.21321 11.7413 8.21321 11.2389C8.21321 10.7366 8.60889 10.3293 9.097 10.3293C9.5851 10.3293 9.98079 10.7366 9.98079 11.2389C9.98079 11.7413 9.5851 12.1486 9.097 12.1486ZM14.002 11.2389C14.002 11.7413 14.3977 12.1486 14.8858 12.1486C15.3739 12.1486 15.7696 11.7413 15.7696 11.2389C15.7696 10.7366 15.3739 10.3293 14.8858 10.3293C14.3977 10.3293 14.002 10.7366 14.002 11.2389Z" fill="currentColor"></path>                                            
                                    </svg> 
                                </div>--}}
                                </div>
                                <div class="ms-3">
                                {{-- <h5>1153</h5>
                                <small class="mb-0">Products</small> --}}
                                </div>
                            </div>
                            <div class="d-flex align-itmes-center">
                                <div>
                               {{--  <div class="p-3 mb-2 rounded bg-soft-info">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.1213 11.2331H16.8891C17.3088 11.2331 17.6386 10.8861 17.6386 10.4677C17.6386 10.0391 17.3088 9.70236 16.8891 9.70236H14.1213C13.7016 9.70236 13.3719 10.0391 13.3719 10.4677C13.3719 10.8861 13.7016 11.2331 14.1213 11.2331ZM20.1766 5.92749C20.7861 5.92749 21.1858 6.1418 21.5855 6.61123C21.9852 7.08067 22.0551 7.7542 21.9652 8.36549L21.0159 15.06C20.8361 16.3469 19.7569 17.2949 18.4879 17.2949H7.58639C6.25742 17.2949 5.15828 16.255 5.04837 14.908L4.12908 3.7834L2.62026 3.51807C2.22057 3.44664 1.94079 3.04864 2.01073 2.64043C2.08068 2.22305 2.47038 1.94649 2.88006 2.00874L5.2632 2.3751C5.60293 2.43735 5.85274 2.72207 5.88272 3.06905L6.07257 5.35499C6.10254 5.68257 6.36234 5.92749 6.68209 5.92749H20.1766ZM7.42631 18.9079C6.58697 18.9079 5.9075 19.6018 5.9075 20.459C5.9075 21.3061 6.58697 22 7.42631 22C8.25567 22 8.93514 21.3061 8.93514 20.459C8.93514 19.6018 8.25567 18.9079 7.42631 18.9079ZM18.6676 18.9079C17.8282 18.9079 17.1487 19.6018 17.1487 20.459C17.1487 21.3061 17.8282 22 18.6676 22C19.4969 22 20.1764 21.3061 20.1764 20.459C20.1764 19.6018 19.4969 18.9079 18.6676 18.9079Z" fill="currentColor"></path>                                            
                                    </svg>                                      
                                </div>   --}}
                                </div>
                                <div class="ms-3">
                                {{-- <h5>81K</h5>
                                <small class="mb-0">Order Served</small> --}}
                                </div>
                            </div>
                        </div>
                            @php
                                $yearlyGrandTotal = DB::table('lf_06_03')
                                    ->whereYear('created_at', date('Y'))
                                    ->sum('grand_total');
                            @endphp

                            <div class="mb-4">
                                <div class="flex-wrap d-flex justify-content-between">

                                    <h2 class="mb-2">
                                        {{ $yearlyGrandTotal ? '₱ ' . number_format($yearlyGrandTotal, 2) : '' }}
                                    </h2>

                                    <div>
                                        <span class="badge bg-success rounded-pill">
                                            {{ date('Y') }}
                                        </span>
                                    </div>

                                </div>

                                <p class="text-info">Customer Payments</p>
                            </div>
                        <div class="grid-cols-2 d-grid gap-card">
                            {{-- <button class="p-2 btn btn-primary text-uppercase">SUMMARY</button>
                            <button class="p-2 btn btn-info text-uppercase">ANALYTICS</button> --}}
                        </div>
                    </div>
                    </div>
                    {{-- <div class="card" data-aos="fade-up" data-aos-delay="500">
                    <div class="text-center card-body d-flex justify-content-around">
                        <div>
                            <h2 class="mb-2">750<small>K</small></h2>
                            <p class="mb-0 text-gray">Website Visitors</p>
                        </div>
                        <hr class="hr-vertial">
                        <div>
                            <h2 class="mb-2">7,500</h2>
                            <p class="mb-0 text-gray">New Customers</p>
                        </div>
                    </div>
                    </div>  --}}
                </div>
               
            </div>
        </div> 
        </div>
      </div>
  
@endsection