@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<style>
    .choices {
        width: 100% !important;
    }

    .choices__inner {
        width: 100% !important;
        box-sizing: border-box;
    }

    .choices__input {
        width: 100% !important;
        box-sizing: border-box;
    }

    td {
        position: relative;
    }
</style>
<style>
    
    .page-wrap{
        max-width: 1750px;
        margin: 10px auto;
        padding: 0 20px;
    }

    .form-sheet{
        border: 1.5px solid #000;
        background: #fff;
        padding: 14px;
    }

    table{
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }
    
    .bordered td,
    .bordered th{
        border: 1px solid #000 !important;
        padding: 3px 5px;
        vertical-align: middle;
    }

    .header-title{
        line-height: 1.15;
        font-size: 13px;
    }

    .header-title .big{
        font-weight: bold;
    }

    .logo-cell{
        width: 110px;
        text-align: center;
        vertical-align: middle;
    }

    .logo-cell img{
        max-width: 78px;
        height: auto;
    }

    .section-title{
        font-weight: bold;
        text-align: center;
        font-size: 13px;
    }


    .form-control-plain{
        width: 100%;
        min-width: 0;
        border: none;
        outline: none;
        background: transparent;
        font-size: 12px;
        /* padding: 0 2px; */
        box-shadow: none;
    }

    .form-control-plain:focus,
    .meta-input:focus{
        outline: none;
        box-shadow: none;
    }

    .table-main{
        margin-bottom: 0;
    }

    .table-main th{
        text-align: center;
        font-weight: normal;
        word-break: break-word;
    }

    .table-main td{
        height: 28px;
        overflow: hidden;
    }

    .table-main input[type="date"]{
        font-size: 11px;
    }

    .action-col{
        width: 54px;
    }

    .screen-only{
        display: inline-block;
    }

    .btn-row{
        margin-top: 16px;
        display: flex;
        gap: 8px;
    }

    .checked-by{
        margin-top: 48px;
        width: 300px;
    }

    .checked-label{
        margin-bottom: 28px;
    }

    .signature-line{
        border-top: 1px solid #000;
        width: 100%;
        height: 1px;
    }

    @media print{
        .screen-only{
            display: none !important;
        }

        .page-wrap{
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        .form-sheet{
            border: 1px solid #000;
            padding: 6px;
        }
    }
</style>
  <style>
.report-sheet {
    width: 100%;
    border-collapse: collapse;
    color: #000;
    font-family: "Times New Roman", serif;
    font-size: 12px;
}

.report-sheet td,
.report-sheet th {
    border: 1px solid #000;
    padding: 4px 6px;
    vertical-align: middle;
}

.report-sheet .section-title {
    text-align: center;
    font-weight: bold;
    background: #d9d9d9;
}

.report-sheet .section-subtitle {
    display: block;
    font-style: italic;
    font-weight: normal;
    font-size: 11px;
    margin-top: 2px;
}

.report-sheet .text-center {
    text-align: center;
}

.report-sheet .text-bold {
    font-weight: bold;
}

.report-sheet .no-padding {
    padding: 0;
}

.sheet-input {
    width: 100%;
    border: none;
    outline: none;
    background: transparent;
    font-family: "Times New Roman", serif;
    font-size: 12px;
    padding: 2px 4px;
    box-sizing: border-box;
}

.sheet-input[type="date"],
.sheet-input[type="time"] {
    min-width: 100px;
}

.remarks-box {
    width: 100%;
    min-height: 70px;
    border: none;
    outline: none;
    resize: none;
    background: transparent;
    font-family: "Times New Roman", serif;
    font-size: 12px;
    padding: 6px;
    box-sizing: border-box;
}

.signature-line {
    border: none;
    border-bottom: 1px solid #000;
    width: 100%;
    background: transparent;
    outline: none;
    height: 28px;
}

.meta-row {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-top: 20px;
}

.meta-col {
    flex: 1 1 48%;
}

.meta-col label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
}

.meta-input {
    width: 100%;
    border: 1px solid #000;
    border-radius: 0;
    padding: 8px 10px;
    font-family: "Times New Roman", serif;
    font-size: 13px;
    background: #fff;
}
</style>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><span class="badge bg-warning p-3">DOCUMENT CODE : LF 06-04</span></h4>
                         
                        </div>
                        {{-- <a class="btn btn-sm btn-icon btn-success mt-3" data-bs-toggle="modal" data-bs-target="#viewRLAModal" data-bs-placement="top" aria-label="Generate RLA No." title="Generate RLA No.">
                            <svg class="icon-35" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z" fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.07996 6.6499V6.6599C7.64896 6.6599 7.29996 7.0099 7.29996 7.4399C7.29996 7.8699 7.64896 8.2199 8.07996 8.2199H11.069C11.5 8.2199 11.85 7.8699 11.85 7.4289C11.85 6.9999 11.5 6.6499 11.069 6.6499H8.07996ZM15.92 12.7399H8.07996C7.64896 12.7399 7.29996 12.3899 7.29996 11.9599C7.29996 11.5299 7.64896 11.1789 8.07996 11.1789H15.92C16.35 11.1789 16.7 11.5299 16.7 11.9599C16.7 12.3899 16.35 12.7399 15.92 12.7399ZM15.92 17.3099H8.07996C7.77996 17.3499 7.48996 17.1999 7.32996 16.9499C7.16996 16.6899 7.16996 16.3599 7.32996 16.1099C7.48996 15.8499 7.77996 15.7099 8.07996 15.7399H15.92C16.319 15.7799 16.62 16.1199 16.62 16.5299C16.62 16.9289 16.319 17.2699 15.92 17.3099Z" fill="currentColor"></path>
                                </svg>      
                            <span class="item-name">RLA No.</span>
                         </a> --}}
                        </div>
                        <div class="card-body ">
                            <input type="text" id="searchInput" style="width: 50%"  placeholder="Search RLA No." class="form-control mb-3">
                            

                            <div class="table-responsive">
                                
                                <table id="documentsTable" class="table table-striped" role="grid" data-bs-toggle="data-table">
                                    <thead>
                                        <tr class="light">
                                            <th class="text-wrap">RLA NO.</th>
                                            <th class="text-wrap">Customer Name</th>
                                            <th class="text-wrap">Laboratory Code</th>
                                            <th class="text-wrap">Sample Type</th>
                                            <th class="text-wrap">Status</th>
                                            <th style="min-width: 100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rla as $r)
                                             <tr>
                                            
                                                <td class="text-wrap">{{ $r->RLA_no}}</td>
                                                <td class="text-wrap">{{ $r->company_name}}</td>
                                                <td class="text-wrap">{{ $r->lab_code}}</td>
                                                <td class="text-wrap">{{ $r->sample_desc}}</td>
                                                 <style>
                                                     .timeline-item {
                                                        position: relative;
                                                        padding-left: 45px;
                                                        margin-bottom: 20px;
                                                    }

                                                    /* 🔥 VERTICAL LINE */
                                                    .timeline-item::before {
                                                        content: "";
                                                        position: absolute;
                                                        left: 14px;
                                                        top: 0;
                                                        width: 2px;
                                                        height: 100%;
                                                        background: #dee2e6;
                                                    }

                                                    /* remove last line */
                                                    .timeline-item:last-child::before {
                                                        height: 14px;
                                                    }

                                                    /* 🔵 CIRCLE */
                                                    .timeline-icon {
                                                        position: absolute;
                                                        left: 0;
                                                        top: 0;
                                                        width: 30px;
                                                        height: 30px;
                                                        border-radius: 50%;
                                                        background: #adb5bd;
                                                        color: white;
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: center;
                                                        font-weight: bold;
                                                    }

                                                    /* ✅ COMPLETED */
                                                    .timeline-icon.done {
                                                        background: #198754;
                                                    }

                                                    /* 🔵 CURRENT */
                                                    .timeline-icon.current {
                                                        background: #0d6efd;
                                                    }

                                                    /* TEXT */
                                                    .timeline-content {
                                                        padding-left: 5px;
                                                    }
                                                </style>
                                                @php
                                                    $statuses = [
                                                        0 => ['label' => 'On Process', 'class' => 'bg-secondary'],
                                                        1 => ['label' => 'Order of Payment', 'class' => 'bg-primary'],
                                                        2 => ['label' => 'Job Routing Form', 'class' => 'bg-info'],
                                                        3 => ['label' => 'Analysis Worksheet', 'class' => 'bg-secondary'],
                                                        4 => ['label' => 'Equipment Logs', 'class' => 'bg-secondary'],
                                                        5 => ['label' => 'ENVIRONMENTAL MONITORING LOGBOOK', 'class' => 'bg-secondary'],
                                                        6 => ['label' => 'Sample Disposal Logs', 'class' => 'bg-info'],
                                                        7 => ['label' => 'Preparation Report Test', 'class' => 'bg-warning'],
                                                        8 => ['label' => 'Release', 'class' => 'bg-success'],
                                                    ];

                                                    $currentStatus = $statuses[$r->status] ?? ['label' => 'Hold', 'class' => 'bg-danger'];
                                                @endphp

                                                <td>
                                                    <!-- CLICKABLE BADGE -->
                                                    <button type="button"
                                                        class="badge {{ $currentStatus['class'] }} p-2 border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#statusModal{{ $r->id }}">
                                                        {{ $currentStatus['label'] }}
                                                    </button>

                                                    <!-- MODAL -->
                                                    <div class="modal fade" id="statusModal{{ $r->id }}" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">

                                                                <!-- HEADER -->
                                                                <div class="modal-header bg-success text-white">
                                                                    <h5 class="modal-title">Status Progress</h5>
                                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                                </div>

                                                                <!-- BODY -->
                                                                <div class="modal-body">

                                                                    <h6 class="mb-3">
                                                                        Current Status:
                                                                        <span class="badge {{ $currentStatus['class'] }}">
                                                                            {{ $currentStatus['label'] }}
                                                                        </span>
                                                                    </h6>

                                                                    <!-- TIMELINE -->
                                                                    @foreach($statuses as $key => $status)
                                                                        <div class="timeline-item">

                                                                            <!-- CIRCLE -->
                                                                            <div class="timeline-icon
                                                                                {{ $r->status > $key ? 'done' : '' }}
                                                                                {{ $r->status == $key ? 'current' : '' }}">
                                                                                {{ $key + 1 }}
                                                                            </div>

                                                                            <!-- CONTENT -->
                                                                            <div class="timeline-content">
                                                                                <strong>{{ $status['label'] }}</strong><br>

                                                                                @if($r->status > $key)
                                                                                    <small class="text-success">Completed</small>
                                                                                @elseif($r->status == $key)
                                                                                    <small class="text-primary">Current step</small>
                                                                                @else
                                                                                    <small class="text-muted">Pending</small>
                                                                                @endif
                                                                            </div>

                                                                        </div>
                                                                    @endforeach

                                                                    @if(!array_key_exists($r->status, $statuses))
                                                                        <div class="alert alert-danger mt-3">
                                                                            This request is currently on hold.
                                                                        </div>
                                                                    @endif

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                {{-- <td>Page 1</td> --}}
                                                <td>
                                                       @php
                                                        $isDisabled = $r->status != 2;
                                                    @endphp
                                                    <div class="flex align-items-center list-user-action">
                                                        <a class="btn btn-sm btn-icon btn-warning RoutingFormBtn"
                                                            href="javascript:void(0);"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#routeFormModal"
                                                            data-id="{{ $r->id }}"
                                                            data-bs-placement="top"
                                                            title="Job Routing Form"
                                                            aria-label="Job Routing Form">
                                                                <span class="btn-inner">
                                                                   <svg class="20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.33049 2.00049H16.6695C20.0705 2.00049 21.9905 3.92949 22.0005 7.33049V16.6705C22.0005 20.0705 20.0705 22.0005 16.6695 22.0005H7.33049C3.92949 22.0005 2.00049 20.0705 2.00049 16.6705V7.33049C2.00049 3.92949 3.92949 2.00049 7.33049 2.00049ZM12.0495 17.8605C12.4805 17.8605 12.8395 17.5405 12.8795 17.1105V6.92049C12.9195 6.61049 12.7705 6.29949 12.5005 6.13049C12.2195 5.96049 11.8795 5.96049 11.6105 6.13049C11.3395 6.29949 11.1905 6.61049 11.2195 6.92049V17.1105C11.2705 17.5405 11.6295 17.8605 12.0495 17.8605ZM16.6505 17.8605C17.0705 17.8605 17.4295 17.5405 17.4805 17.1105V13.8305C17.5095 13.5095 17.3605 13.2105 17.0895 13.0405C16.8205 12.8705 16.4805 12.8705 16.2005 13.0405C15.9295 13.2105 15.7805 13.5095 15.8205 13.8305V17.1105C15.8605 17.5405 16.2195 17.8605 16.6505 17.8605ZM8.21949 17.1105C8.17949 17.5405 7.82049 17.8605 7.38949 17.8605C6.95949 17.8605 6.59949 17.5405 6.56049 17.1105V10.2005C6.53049 9.88949 6.67949 9.58049 6.95049 9.41049C7.21949 9.24049 7.56049 9.24049 7.83049 9.41049C8.09949 9.58049 8.25049 9.88949 8.21949 10.2005V17.1105Z" fill="currentColor"></path>                            </svg>                        
                                                                </span>
                                                            </a>
                                                        {{-- <a class="btn btn-sm btn-icon btn-primary"
                                                        onclick="openPDF('{{ asset('LF/LF00-08.pdf') }}')"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#viewPdfModal"
                                                        title="View Details">
                                                            <span class="btn-inner">
                                                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" fill="currentColor"></path><circle cx="12" cy="12" r="5" fill="#918F98"></circle>                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                </mask>                                <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white" fill-opacity="0.6"></circle></svg>                                                              
                                                            </span>
                                                        </a> --}}
                                                        <a class="btn btn-sm btn-icon btn-info"
                                                            href="{{ route('RoutingForm.download.pdf', $r->id) }}" data-download
                                                            data-bs-toggle="tooltip"
                                                            title="Download PDF">
                                                                <span class="btn-inner">
                                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path>
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                            @php
                                                                $isDisabled = $r->status != 2;
                                                            @endphp
                                                               <form action="{{ route('update.statusJRF', $r->id) }}" method="POST" class="d-inline check-form">
                                                                    @csrf
                                                                      <button type="submit"
                                                                        class="btn btn-sm btn-icon btn-success check-btn {{ $isDisabled ? 'disabled' : '' }}"
                                                                        style="{{ $isDisabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                                        title="Checked">

                                                                         <span class="btn-inner">
                                                                         <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7281 21.9137C11.8388 21.9715 11.9627 22.0009 12.0865 22C12.2103 21.999 12.3331 21.9686 12.4449 21.9097L16.0128 20.0025C17.0245 19.4631 17.8168 18.8601 18.435 18.1579C19.779 16.6282 20.5129 14.6758 20.4998 12.6626L20.4575 6.02198C20.4535 5.25711 19.9511 4.57461 19.2082 4.32652L12.5707 2.09956C12.1711 1.96424 11.7331 1.96718 11.3405 2.10643L4.72824 4.41281C3.9893 4.67071 3.496 5.35811 3.50002 6.12397L3.54231 12.7597C3.5554 14.7758 4.31448 16.7194 5.68062 18.2335C6.3048 18.9258 7.10415 19.52 8.12699 20.0505L11.7281 21.9137ZM10.7836 14.1089C10.9326 14.2521 11.1259 14.3227 11.3192 14.3207C11.5125 14.3198 11.7047 14.2472 11.8517 14.1021L15.7508 10.2581C16.0438 9.96882 16.0408 9.50401 15.7448 9.21866C15.4478 8.9333 14.9696 8.93526 14.6766 9.22454L11.3081 12.5449L9.92885 11.2191C9.63186 10.9337 9.15467 10.9367 8.8607 11.226C8.56774 11.5152 8.57076 11.98 8.86775 12.2654L10.7836 14.1089Z" fill="currentColor"></path>                            </svg>                        
                                                                    </span>
                                                                    </button>
                                                                </form>
                                                            <script>
                                                               $(document).on('click', '.check-btn', function(e){
                                                                    e.preventDefault();

                                                                    let button = $(this);

                                                                    if(button.hasClass('disabled')) return;

                                                                    let form = button.closest('form');

                                                                    Swal.fire({
                                                                        title: 'Verified?',
                                                                        icon: 'question',
                                                                        showCancelButton: true,
                                                                        confirmButtonText: 'Yes'
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            form.submit(); 
                                                                        }
                                                                    });
                                                                });
                                                            </script>
                                                            {{-- <form action="{{ route('rla.delete', $r->id) }}" method="POST" class="delete-form d-inline">
                                                                @csrf
                                                                @method('DELETE')

                                                                <a href="#" 
                                                                class="btn btn-sm btn-icon btn-danger delete-button" 
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="top" 
                                                                title="Delete" 
                                                                aria-label="Delete"
                                                                >
                                                                    <span class="btn-inner">
                                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                                            <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            </form>
                                                            <script>
                                                                document.addEventListener('DOMContentLoaded', function() {
                                                                    document.querySelectorAll('.delete-button').forEach(function(button) {
                                                                        button.addEventListener('click', function(e) {
                                                                            e.preventDefault();

                                                                            Swal.fire({
                                                                                title: 'Are you sure?',
                                                                                text: 'You will not be able to recover this data!',
                                                                                icon: 'warning',
                                                                                showCancelButton: true,
                                                                                confirmButtonColor: '#d33',
                                                                                cancelButtonColor: '#3085d6',
                                                                                confirmButtonText: 'Yes, delete it!',
                                                                                reverseButtons: true,
                                                                                buttonsStyling: false,
                                                                                customClass: {
                                                                                    confirmButton: 'btn btn-primary mx-2', 
                                                                                    cancelButton: 'btn btn-danger mx-2'    
                                                                                }
                                                                            }).then((result) => {
                                                                                if (result.isConfirmed) {
                                                                                    button.closest('.delete-form').submit();
                                                                                }
                                                                            });
                                                                        });
                                                                    });
                                                                });
                                                                </script> --}}
                                                    </div>
                                                </td>
                                            </tr>  
                                        @endforeach
                                       
                                   
                                    </tbody>
                                </table>
                                  <div class="card-body">
                                        <div class="d-flex ">
                                        {{ $rla->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
            {{-- payment modal --}}
        <div class="modal fade" id="routeFormModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewPdfModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" id="routingForm">
                            @csrf

                            <div class="form-sheet">
                             
                                <table class="report-sheet mb-3 text-wrap">
                                    <!-- RECEIVING -->
                                    <tr>
                                        <td colspan="8" class="section-title">
                                            RECEIVING
                                            <span class="section-subtitle">(To be filled-up by the Customer Service Officer)</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td rowspan="2" colspan="2" class="text-center text-bold" style="width: 22%;">Process / Action</td>
                                        <td colspan="2" class="text-center text-bold" style="width: 18%;">IN</td>
                                        <td colspan="2" class="text-center text-bold" style="width: 18%;">OUT</td>
                                        <td rowspan="2" class="text-center text-bold" style="width: 22%;">Remarks</td>
                                        <td rowspan="2" class="text-center text-bold" style="width: 10%;">Initials</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Date</td>
                                        <td class="text-center">Time</td>
                                        <td class="text-center">Date</td>
                                        <td class="text-center">Time</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">Sample Reception</td>
                                        <td class="no-padding"><input type="date" class="sheet-input receiving-lab-field" name="receiving_in_date"></td>
                                        <td class="no-padding"><input type="time" class="sheet-input receiving-lab-field" name="receiving_in_time"></td>
                                        <td class="no-padding"><input type="date" class="sheet-input receiving-lab-field" name="receiving_out_date"></td>
                                        <td class="no-padding"><input type="time" class="sheet-input receiving-lab-field" name="receiving_out_time"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="receiving_remarks"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="receiving_initials"></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">RLA No.</td>
                                        <td colspan="6" class="no-padding">
                                            <input type="text" class="sheet-input receiving-lab-field" name="RLA_no" id="RLA_no" readonly>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">Laboratory Code</td>
                                        <td colspan="6" class="no-padding">
                                            <input type="text" class="sheet-input receiving-lab-field" name="laboratory_code" id="laboratory_code" readonly>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">Sample Type</td>
                                        <td colspan="6" class="no-padding">
                                            <input type="text" class="sheet-input receiving-lab-field" name="sample_desc" id="sample_desc" readonly>
                                        </td>
                                    </tr>

                                    <!-- LABORATORY -->
                                    <tr>
                                        <td colspan="8" class="section-title">
                                            LABORATORY
                                            <span class="section-subtitle">(To be filled-up by the Laboratory Analyst)</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td rowspan="2" class="text-center text-bold ">Process / Action</td>
                                        <td colspan="2" class="text-center text-bold">IN</td>
                                        <td colspan="2" class="text-center text-bold">OUT</td>
                                        <td rowspan="2" class="text-center text-bold">Results</td>
                                        <td rowspan="2" class="text-center text-bold">% Recovery</td>
                                        <td rowspan="2" class="text-center text-bold">Initials</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Date</td>
                                        <td class="text-center">Time</td>
                                        <td class="text-center">Date</td>
                                        <td class="text-center">Time</td>
                                    </tr>

                                    <tr>
                                        <td class="text-wrap">I. Sample preparation</td>
                                        <td class="no-padding"><input type="date" class="sheet-input receiving-lab-field" name="prep_in_date"></td>
                                        <td class="no-padding"><input type="time" class="sheet-input receiving-lab-field" name="prep_in_time"></td>
                                        <td class="no-padding"><input type="date" class="sheet-input receiving-lab-field" name="prep_out_date"></td>
                                        <td class="no-padding"><input type="time" class="sheet-input receiving-lab-field" name="prep_out_time"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="prep_results"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="prep_recovery"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="prep_initials"></td>
                                    </tr>

                                    <tr>
                                        <td>II. Analysis</td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_1"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_2"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_3"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_4"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_results"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_recovery"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_initials"></td>
                                    </tr>
                                     <tr>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="name_analysis_2"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_2_2"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_2_3"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_2_4"></td>
                                         <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_2_5"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_results_2"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_recovery_2"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_initials_2"></td>
                                    </tr>
                                    <tr>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="name_analysis_3"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_3_2"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_3_3"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_3_4"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_3_5"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_results_3"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_recovery_3"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_initials_3"></td>
                                    </tr>
                                    <tr>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="name_analysis_4"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_4_2"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_4_3"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_4_4"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_4_5"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_results_4"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_recovery_4"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_initials_4"></td>
                                    </tr>
                                    <tr>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="name_analysis_5"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_5_2"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_5_3"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_5_4"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_5_5"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_results_5"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_recovery_5"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_initials_5"></td>
                                    </tr>
                                    <tr>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="name_analysis_6"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_6_2"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_6_3"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_6_4"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_6_5"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_results_6"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_recovery_6"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input receiving-lab-field" name="analysis_initials_6"></td>
                                    </tr>
                                
                                  <tr>
                                        <td colspan="8" style="height: 110px; vertical-align: top; padding: 0;">
                                            <div style="padding: 6px; font-weight: bold;">REMARKS</div>
                                            <textarea name="remarks" class="receiving-lab-field" 
                                                style="width:100%; height:70px; border:none; outline:none; resize:none; padding:6px; font-family:'Times New Roman'; font-size:12px;">
                                            </textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4" style="padding: 10px;">
                                            <span style="font-weight:bold;">Checked By:</span>
                                            <input type="text" name="checked_by" class="receiving-lab-field"
                                                style="border:none; border-bottom:1px solid #000; width:60%; margin-left:10px; outline:none; font-family:'Times New Roman';">
                                        </td>

                                        <td colspan="4" style="padding: 10px;">
                                            <span style="font-weight:bold;">Date:</span>
                                            <input type="date" name="checked_date" class="receiving-lab-field"
                                                style="border:none; border-bottom:1px solid #000; width:60%; margin-left:10px; outline:none; font-family:'Times New Roman';">
                                        </td>
                                    </tr>

                                    <!-- PREPARATION OF REPORT OF TEST -->
                                    <tr>
                                        <td colspan="8" class="section-title">
                                            PREPARATION OF REPORT OF TEST
                                            <span class="section-subtitle">(To be filled-up by the Customer Service Officer)</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td rowspan="2" colspan="2" class="text-center text-bold">Process / Action</td>
                                        <td colspan="2" class="text-center text-bold">IN</td>
                                        <td colspan="2" class="text-center text-bold">OUT</td>
                                        <td rowspan="2" class="text-center text-bold">Remarks</td>
                                        <td rowspan="2" class="text-center text-bold">Initials</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Date</td>
                                        <td class="text-center">Time</td>
                                        <td class="text-center">Date</td>
                                        <td class="text-center">Time</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">Preparation of Test Report</td>
                                        <td class="no-padding"><input type="date" class="sheet-input report-test-field" name="report_in_date"></td>
                                        <td class="no-padding"><input type="time" class="sheet-input report-test-field" name="report_in_time"></td>
                                        <td class="no-padding"><input type="date" class="sheet-input report-test-field" name="report_out_date"></td>
                                        <td class="no-padding"><input type="time" class="sheet-input report-test-field" name="report_out_time"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input report-test-field" name="report_remarks"></td>
                                        <td class="no-padding"><input type="text" class="sheet-input report-test-field" name="report_initials"></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">Date Approved for Release</td>
                                        <td colspan="6" class="no-padding">
                                            <input type="date" class="sheet-inpu report-test-field" name="date_approved_release">
                                        </td>
                                    </tr>
                                </table>

                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="user_id" id="user_id">

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-check"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <script>
        $(document).ready(function () {
       
            function clearRoutingForm() {
                $('#routingForm')[0].reset();
            }

           function toggleRoutingSections(status) {
                status = parseInt(status);

                console.log('toggle status =', status);

                $('.receiving-lab-field').prop('disabled', true);
                $('.report-test-field').prop('disabled', true);

                if (status === 2) {
                    $('.receiving-lab-field').prop('disabled', false);
                    $('.report-test-field').prop('disabled', true);
                } else if (status === 7) {
                    $('.receiving-lab-field').prop('disabled', true);
                    $('.report-test-field').prop('disabled', false);
                }
            }

            function fillRoutingForm(response) {
                clearRoutingForm();

                $('#id').val(response.id ?? '');
                $('#user_id').val(response.user_id ?? '');
                $('#RLA_no').val(response.RLA_no ?? '');
                $('#sample_desc').val(response.sample_desc ?? '');
                $('#laboratory_code').val(response.first_lab_code ?? '');
                // console.log(response);
                if (response.routing_form) {
                    $.each(response.routing_form, function (key, value) {
                        let field = $('[name="' + key + '"]');
                        if (field.length) {
                            field.val(value);
                        }
                    });
                }

                toggleRoutingSections(response.job_status);
            }
                $('.RoutingFormBtn').on('click', function () {
                    let id = $(this).data('id');

                    $('#id').val(id);
                    $('#routingForm').attr('action', '/routingForm/' + id);

                    $.ajax({
                        url: '/job/' + id + '/routing',
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            fillRoutingForm(response);
                            $('#routeFormModal').modal('show');
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to fetch record data.'
                            });
                        }
                    });
                });

            $('#routingForm').on('submit', function (e) {
                e.preventDefault();

                let form = $(this);
                let actionUrl = form.attr('action');

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: form.serialize(),
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });

                        $('#routeFormModal').modal('hide');
                    
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);

                        let message = 'Failed to save routing form.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message
                        });
                    }
                });
            });

        });
        </script>
    </div>

    

@endsection