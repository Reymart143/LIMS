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

    .meta-label{
        white-space: nowrap;
        margin-right: 6px;
    }

    .meta-row{
        display: flex;
        align-items: center;
        width: 100%;
        gap: 6px;
        margin-bottom: 4px;
    }

    .meta-row:last-child{
        margin-bottom: 0;
    }

    .meta-input{
        flex: 1 1 auto;
        min-width: 0;
        border: none;
        border-bottom: 1px solid #000;
        background: transparent;
        outline: none;
        font-size: 17px;
        /* padding: 0 2px; */
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
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><span class="badge bg-warning p-3">DOCUMENT CODE : LF 06-03</span></h4>
                         
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
                            <input type="text" id="searchInput" style="width: 50%"  placeholder="Search Document Code or Title" class="form-control mb-3">
                            

                            <div class="table-responsive">
                                
                                <table id="documentsTable" class="table table-striped" role="grid" data-bs-toggle="data-table">
                                    <thead>
                                        <tr class="light">
                                            <th class="text-wrap">RLA NO.</th>
                                            <th class="text-wrap">Customer Name</th>
                                            <th class="text-wrap">Address</th>
                                            <th class="text-wrap">Sample</th>
                                            <th class="text-wrap">Date Collected</th>
                                            <th class="text-wrap">Payment</th>
                                            <th class="text-wrap">Status</th>
                                            <th style="min-width: 100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rla as $r)
                                             <tr>
                                            
                                                <td class="text-wrap">{{ $r->RLA_no}}</td>
                                                <td class="text-wrap">{{ $r->company_name}}</td>
                                                <td class="text-wrap">{{ $r->address}}</td>
                                                <td class="text-wrap">{{ $r->source_sample}}</td>
                                                <td class="text-wrap">{{ $r->date_collected}}</td>
                                                 <td class="text-wrap">{{ $r->payment}}</td>
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
                                                        $isDisabled = $r->status != 1;
                                                    @endphp
                                                    <div class="flex align-items-center list-user-action">
                                                            <a class="btn btn-sm btn-icon btn-warning paymentRlaBtn {{ $isDisabled ? 'disabled' : '' }}"
                                                            href="javascript:void(0);"
                                                            data-bs-toggle="{{ $isDisabled ? '' : 'modal' }}"
                                                            data-bs-target="{{ $isDisabled ? '' : '#paymentRLAModal' }}"
                                                            data-id="{{ $r->id }}"
                                                            style="{{ $isDisabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                            title="Payment"
                                                            aria-label="Payment">
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
                                                            href="{{ route('OrderOfPayment.download.pdf', $r->id) }}" data-download
                                                            data-bs-toggle="tooltip"
                                                            title="Download PDF">
                                                                <span class="btn-inner">
                                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path>
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                           
                                                               <form action="{{ route('update.statusOP', $r->id) }}" method="POST" class="d-inline check-form">
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
        <div class="modal fade" id="paymentRLAModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" id="paymentRLAForm">
                    @csrf

                    <div class="form-sheet">
                        <table class="bordered mb-2">
                            <colgroup>
                                <col style="width: 110px;">
                                <col>
                            </colgroup>
                            <tr>
                                <td class="logo-cell">
                                    <img src="../assets/images/bfarlogo.png" alt="Logo" onerror="this.style.display='none'">
                                </td>
                                <td class="header-title" style="color:black">
                                    <div>Republic of the Philippines</div>
                                    <div>Department of Agriculture</div>
                                    <div class="big">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
                                    <div class="big">REGIONAL FISHERIES LABORATORY XII</div>
                                    <div>J. Catolico St., Lagao, General Santos City</div>
                                </td>
                            </tr>
                        </table>

                        <table class="bordered mb-3" style="color:black">
                            <colgroup>
                                <col style="width: 23%;">
                                <col style="width: 26%;">
                                <col style="width: 28%;">
                                <col style="width: 23%;">
                            </colgroup>
                            <tr>
                                <td>
                                    <div>Document Type</div>
                                    <div><strong>Laboratory Form</strong></div>
                                </td>
                                <td>
                                    <div>Revision No:</div>
                                    <div>0</div>
                                </td>
                                <td>
                                    <div>Date Adopted:</div>
                                    <div>13 Aug 2019</div>
                                </td>
                                <td>
                                    <div>RLA No. <input type="text" name="RLA_no" id="RLA_no" class="meta-input form-control" readonly></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>Document Code:</div>
                                    <div><strong>LF 06-03</strong></div>
                                </td>
                                <td colspan="3" class="section-title">
                                    Order of Payment
                                </td>
                            </tr>
                        </table>

                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label class="form-label">Customer :</label>
                            <input type="text" class="form-control meta-input" id="company_name" readonly name="company_name">
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label class="form-label">Address :</label>
                            <input type="text" class="form-control meta-input" id="address" readonly name="address">
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label class="form-label">Sample :</label>
                            <input type="text" class="form-control meta-input" id="sample_description" readonly name="sample_description">
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label class="form-label">Laboratory Code :</label>
                            <input type="text" class="form-control meta-input" id="laboratory_code" readonly name="laboratory_code">
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:50%">CHEMICAL ANALYSIS</th>
                                    <th>Quantity</th>
                                    <th>Unit Cost</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[0][checked]" value="1">
                                        <input type="hidden" name="items[0][section]" value="CHEMICAL ANALYSIS">
                                        <input type="hidden" name="items[0][name]" value="Histamine">
                                        Histamine
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[0][qty]" disabled></td>
                                    <td><input type="text" value="450" class="form-control unit" name="items[0][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[0][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[1][checked]" value="1">
                                        <input type="hidden" name="items[1][section]" value="CHEMICAL ANALYSIS">
                                        <input type="hidden" name="items[1][name]" value="Moisture">
                                        Moisture
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[1][qty]" disabled></td>
                                    <td><input type="text" value="85" class="form-control unit" name="items[1][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[1][total]" readonly></td>
                                </tr>

                                <tr><th colspan="4">MICROBIOLOGICAL ANALYSIS</th></tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[2][checked]" value="1">
                                        <input type="hidden" name="items[2][section]" value="MICROBIOLOGICAL ANALYSIS">
                                        <input type="hidden" name="items[2][name]" value="Aerobic Plate Count (APC)">
                                        Aerobic Plate Count (APC)
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[2][qty]" disabled></td>
                                    <td><input type="text" value="200" class="form-control unit" name="items[2][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[2][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[3][checked]" value="1">
                                        <input type="hidden" name="items[3][section]" value="MICROBIOLOGICAL ANALYSIS">
                                        <input type="hidden" name="items[3][name]" value="Heterotrophic Plate Count (HPC)">
                                        Heterotrophic Plate Count (HPC)
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[3][qty]" disabled></td>
                                    <td><input type="text" value="200" class="form-control unit" name="items[3][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[3][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[4][checked]" value="1">
                                        <input type="hidden" name="items[4][section]" value="MICROBIOLOGICAL ANALYSIS">
                                        <input type="hidden" name="items[4][name]" value="Coliform">
                                        Coliform
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[4][qty]" disabled></td>
                                    <td><input type="text" value="250" class="form-control unit" name="items[4][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[4][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[5][checked]" value="1">
                                        <input type="hidden" name="items[5][section]" value="MICROBIOLOGICAL ANALYSIS">
                                        <input type="hidden" name="items[5][name]" value="E.coli">
                                        E.coli
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[5][qty]" disabled></td>
                                    <td><input type="text" value="350" class="form-control unit" name="items[5][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[5][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[6][checked]" value="1">
                                        <input type="hidden" name="items[6][section]" value="MICROBIOLOGICAL ANALYSIS">
                                        <input type="hidden" name="items[6][name]" value="Salmonella">
                                        Salmonella
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[6][qty]" disabled></td>
                                    <td><input type="text" value="400" class="form-control unit" name="items[6][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[6][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[7][checked]" value="1">
                                        <input type="hidden" name="items[7][section]" value="MICROBIOLOGICAL ANALYSIS">
                                        <input type="hidden" name="items[7][name]" value="Shigella">
                                        Shigella
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[7][qty]" disabled></td>
                                    <td><input type="text" value="400" class="form-control unit" name="items[7][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[7][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[8][checked]" value="1">
                                        <input type="hidden" name="items[8][section]" value="MICROBIOLOGICAL ANALYSIS">
                                        <input type="hidden" name="items[8][name]" value="Staph. aureus">
                                        Staph. aureus
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[8][qty]" disabled></td>
                                    <td><input type="text" value="300" class="form-control unit" name="items[8][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[8][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[9][checked]" value="1">
                                        <input type="hidden" name="items[9][section]" value="MICROBIOLOGICAL ANALYSIS">
                                        <input type="hidden" name="items[9][name]" value="Enterococci">
                                        Enterococci
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[9][qty]" disabled></td>
                                    <td><input type="text" value="350" class="form-control unit" name="items[9][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[9][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[10][checked]" value="1">
                                        <input type="hidden" name="items[10][section]" value="MICROBIOLOGICAL ANALYSIS">
                                        <input type="hidden" name="items[10][name]" value="Fecal coliform">
                                        Fecal coliform
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[10][qty]" disabled></td>
                                    <td><input type="text" value="250" class="form-control unit" name="items[10][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[10][total]" readonly></td>
                                </tr>

                                <tr><th colspan="4">MOLECULAR DIAGNOSIS</th></tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[11][checked]" value="1">
                                        <input type="hidden" name="items[11][section]" value="MOLECULAR DIAGNOSIS">
                                        <input type="hidden" name="items[11][name]" value="WSSV">
                                        WSSV
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[11][qty]" disabled></td>
                                    <td><input type="text" value="600" class="form-control unit" name="items[11][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[11][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[12][checked]" value="1">
                                        <input type="hidden" name="items[12][section]" value="MOLECULAR DIAGNOSIS">
                                        <input type="hidden" name="items[12][name]" value="EMS/AHPND">
                                        EMS/AHPND
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[12][qty]" disabled></td>
                                    <td><input type="text" value="600" class="form-control unit" name="items[12][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[12][total]" readonly></td>
                                </tr>

                                <tr><th colspan="4">BIOLOGICAL / BACTERIAL ANALYSIS</th></tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[13][checked]" value="1">
                                        <input type="hidden" name="items[13][section]" value="BIOLOGICAL / BACTERIAL ANALYSIS">
                                        <input type="hidden" name="items[13][name]" value="Parasite Examination">
                                        Parasite Examination
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[13][qty]" disabled></td>
                                    <td><input type="text" value="75" class="form-control unit" name="items[13][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[13][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[14][checked]" value="1">
                                        <input type="hidden" name="items[14][section]" value="BIOLOGICAL / BACTERIAL ANALYSIS">
                                        <input type="hidden" name="items[14][name]" value="Gross/Microscopic Examination">
                                        Gross/Microscopic Examination
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[14][qty]" disabled></td>
                                    <td><input type="text" value="100" class="form-control unit" name="items[14][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[14][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[15][checked]" value="1">
                                        <input type="hidden" name="items[15][section]" value="BIOLOGICAL / BACTERIAL ANALYSIS">
                                        <input type="hidden" name="items[15][name]" value="Bacterial Count">
                                        Bacterial Count
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[15][qty]" disabled></td>
                                    <td><input type="text" value="100" class="form-control unit" name="items[15][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[15][total]" readonly></td>
                                </tr>

                                <tr><th colspan="4">PRODUCT QUALITY CERTIFICATE</th></tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[16][checked]" value="1">
                                        <input type="hidden" name="items[16][section]" value="PRODUCT QUALITY CERTIFICATE">
                                        <input type="hidden" name="items[16][name]" value="Health Certificate">
                                        Health Certificate
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[16][qty]" disabled></td>
                                    <td><input type="text" value="50" class="form-control unit" name="items[16][unit]" readonly></td>
                                    <td><input type="text" class="form-control total" name="items[16][total]" readonly></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="chk" name="items[17][checked]" value="1">
                                        <input type="hidden" name="items[17][section]" value="PRODUCT QUALITY CERTIFICATE">
                                        <input type="hidden" name="items[17][name]" value="OTHERS">
                                        OTHERS
                                    </td>
                                    <td><input type="number" min="1" class="form-control qty" name="items[17][qty]" disabled></td>
                                    <td><input type="text" value="0" class="form-control unit" name="items[17][unit]"></td>
                                    <td><input type="text" class="form-control total" name="items[17][total]" readonly></td>
                                </tr>

                                <tr>
                                    <th colspan="3" class="text-end">Grand Total</th>
                                    <th><input type="text" id="grand_total" name="grand_total" class="form-control" readonly></th>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-6 position-relative mt-4 mb-2">
                                <label class="form-label">Signature :</label>

                                <div id="signature-wrapper" style="border:1px solid #000; width:100%; height:120px; background:#fff; position:relative;">
                                    <canvas id="signature-pad" style="width:100%; height:100%; display:block; touch-action:none; cursor:crosshair;"></canvas>
                                </div>

                                <button type="button" id="clear-signature" class="btn btn-sm btn-danger mt-2">
                                    Clear
                                </button>

                                <input type="hidden" name="signature" id="signature">
                            </div>

                            <div class="col-md-6 position-relative mt-4 mb-2">
                                <label for="issued_by" class="form-label">Issued By :</label>
                                <input type="text" class="form-control meta-input" id="issued_by" required name="issued_by">
                                <label class="form-label">Customer Service Officer</label>
                            </div>

                            <div class="col-md-6 float-right mt-4 mb-2">
                                <label for="date_issued" class="form-label">Date By :</label>
                                <input type="date" class="form-control meta-input" id="date_issued" required name="date_issued">
                            </div>
                        </div>

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
    $('.paymentRlaBtn').on('click', function () {
        let id = $(this).data('id');

        resetPaymentForm();

        $('#id').val(id);
        $('#paymentRLAForm').attr('action', '/paymentRLAForm/' + id);

        $.ajax({
            url: '/order/' + id + '/payment',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#id').val(response.id ?? '');
                $('#payment_id').val(response.payment_id ?? '');
                $('#user_id').val(response.user_id ?? '');
                $('#company_name').val(response.company_name ?? '');
                $('#RLA_no').val(response.RLA_no ?? '');
                $('#address').val(response.location ?? '');
                $('#sample').val(response.sample ?? '');

                $('#laboratory_code').val(response.first_lab_code ?? '');
                $('#sample_description').val(response.first_sample_desc ?? '');
                $('#issued_by').val(response.issued_by ?? '');
                $('#date_issued').val(response.date_issued ?? '');
                $('#grand_total').val(response.grand_total ?? '');
                $('#signature').val(response.signature ?? '');

                if (Array.isArray(response.items)) {
                    loadSavedPaymentItems(response.items);
                }
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

    document.querySelectorAll('.chk').forEach((checkbox) => {
        checkbox.addEventListener('change', function () {
            let row = this.closest('tr');
            let qty = row.querySelector('.qty');

            if (this.checked) {
                qty.disabled = false;
                if (!qty.value) qty.value = 1;
            } else {
                qty.disabled = true;
                qty.value = '';
                row.querySelector('.total').value = '';
            }

            recalcRow(row);
            computeGrandTotal();
        });
    });

    document.querySelectorAll('.qty').forEach((input) => {
        input.addEventListener('keydown', function (e) {
            if (e.key === '-' || e.key === 'e' || e.key === '+' || e.key === '.') {
                e.preventDefault();
            }
        });

        input.addEventListener('input', function () {
            let row = this.closest('tr');
            let checkbox = row.querySelector('.chk');

            if (!checkbox.checked) return;

            let qty = parseFloat(this.value);

            if (!qty || qty <= 0) {
                this.value = '';
                row.querySelector('.total').value = '';

                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Quantity',
                    text: 'Quantity must be greater than 0'
                });

                computeGrandTotal();
                return;
            }

            recalcRow(row);
            computeGrandTotal();
        });
    });

    function recalcRow(row) {
        let checkbox = row.querySelector('.chk');
        let qtyInput = row.querySelector('.qty');
        let unitInput = row.querySelector('.unit');
        let totalInput = row.querySelector('.total');

        if (!checkbox.checked) {
            totalInput.value = '';
            return;
        }

        let qty = parseFloat(qtyInput.value) || 0;
        let unit = parseFloat(unitInput.value) || 0;
        let total = qty * unit;

        totalInput.value = total > 0 ? total.toFixed(2) : '';
    }

    function computeGrandTotal() {
        let grand = 0;
        document.querySelectorAll('.total').forEach((input) => {
            grand += parseFloat(input.value) || 0;
        });
        document.getElementById('grand_total').value = grand.toFixed(2);
    }

    function resetPaymentForm() {
        $('#paymentRLAForm')[0].reset();
        $('#payment_id').val('');
        $('#grand_total').val('');
        $('#signature').val('');

        document.querySelectorAll('.chk').forEach((chk) => {
            chk.checked = false;
        });

        document.querySelectorAll('.qty').forEach((qty) => {
            qty.value = '';
            qty.disabled = true;
        });

        document.querySelectorAll('.total').forEach((total) => {
            total.value = '';
        });

        const canvas = document.getElementById('signature-pad');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            if (ctx) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            }
        }
    }

    function loadSavedPaymentItems(items) {
        items.forEach(function(item) {
            const hiddenNames = document.querySelectorAll('input[type="hidden"][name$="[name]"]');

            hiddenNames.forEach(function(hiddenInput) {
                if (hiddenInput.value === item.name) {
                    let row = hiddenInput.closest('tr');
                    let chk = row.querySelector('.chk');
                    let qty = row.querySelector('.qty');
                    let unit = row.querySelector('.unit');
                    let total = row.querySelector('.total');

                    chk.checked = !!item.checked;

                    if (item.checked) {
                        qty.disabled = false;
                        qty.value = item.qty ?? '';
                        if (item.unit !== undefined && item.unit !== null && unit && !unit.hasAttribute('readonly') === false) {
                            unit.value = item.unit;
                        }
                        total.value = item.total ?? '';
                    } else {
                        qty.disabled = true;
                        qty.value = item.qty ?? '';
                        total.value = item.total ?? '';
                    }
                }
            });
        });

        computeGrandTotal();
    }

    // signature pad
    (function () {
        let canvas, ctx, drawing = false, hasDrawn = false;

        function initSignaturePad() {
            canvas = document.getElementById('signature-pad');
            const wrapper = document.getElementById('signature-wrapper');
            const clearBtn = document.getElementById('clear-signature');
            const form = document.getElementById('paymentRLAForm');
            const hiddenInput = document.getElementById('signature');

            if (!canvas || !wrapper || !clearBtn || !form || !hiddenInput) return;

            ctx = canvas.getContext('2d');

            function resizeCanvas() {
                const rect = wrapper.getBoundingClientRect();
                const ratio = Math.max(window.devicePixelRatio || 1, 1);

                canvas.width = rect.width * ratio;
                canvas.height = rect.height * ratio;
                canvas.style.width = rect.width + 'px';
                canvas.style.height = rect.height + 'px';

                ctx.setTransform(1, 0, 0, 1, 0, 0);
                ctx.scale(ratio, ratio);
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.strokeStyle = '#000';
                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, rect.width, rect.height);
            }

            function getPos(e) {
                const rect = canvas.getBoundingClientRect();
                if (e.touches && e.touches.length) {
                    return {
                        x: e.touches[0].clientX - rect.left,
                        y: e.touches[0].clientY - rect.top
                    };
                }
                return {
                    x: e.clientX - rect.left,
                    y: e.clientY - rect.top
                };
            }

            function startDraw(e) {
                e.preventDefault();
                drawing = true;
                const pos = getPos(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            }

            function draw(e) {
                if (!drawing) return;
                e.preventDefault();
                const pos = getPos(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
                hasDrawn = true;
            }

            function endDraw(e) {
                if (!drawing) return;
                e.preventDefault();
                drawing = false;
                ctx.closePath();
            }

            function clearSignature() {
                const rect = wrapper.getBoundingClientRect();
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.setTransform(1, 0, 0, 1, 0, 0);
                ctx.scale(Math.max(window.devicePixelRatio || 1, 1), Math.max(window.devicePixelRatio || 1, 1));
                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, rect.width, rect.height);
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.strokeStyle = '#000';
                hiddenInput.value = '';
                hasDrawn = false;
            }

            resizeCanvas();

            const newCanvas = canvas.cloneNode(true);
            canvas.parentNode.replaceChild(newCanvas, canvas);
            canvas = newCanvas;
            ctx = canvas.getContext('2d');
            resizeCanvas();

            canvas.addEventListener('mousedown', startDraw);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', endDraw);
            canvas.addEventListener('mouseleave', endDraw);

            canvas.addEventListener('touchstart', startDraw, { passive: false });
            canvas.addEventListener('touchmove', draw, { passive: false });
            canvas.addEventListener('touchend', endDraw, { passive: false });

            clearBtn.onclick = clearSignature;

            form.addEventListener('submit', function () {
                if (hasDrawn) {
                    hiddenInput.value = canvas.toDataURL('image/png');
                }
            });
        }

        const modal = document.getElementById('paymentRLAModal');
        if (modal) {
            modal.addEventListener('shown.bs.modal', function () {
                setTimeout(initSignaturePad, 150);
            });
        }
    })();
});
</script>
<script>
$(document).ready(function () {
    let signaturePadObj = {
        canvas: null,
        ctx: null,
        drawing: false,
        hasDrawn: false
    };

    function initSignaturePad() {
        signaturePadObj.canvas = document.getElementById('signature-pad');
        const wrapper = document.getElementById('signature-wrapper');
        const clearBtn = document.getElementById('clear-signature');
        const form = document.getElementById('paymentRLAForm');
        const hiddenInput = document.getElementById('signature');

        if (!signaturePadObj.canvas || !wrapper || !clearBtn || !form || !hiddenInput) return;

        signaturePadObj.ctx = signaturePadObj.canvas.getContext('2d');

        function resizeCanvas() {
            const rect = wrapper.getBoundingClientRect();
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            signaturePadObj.canvas.width = rect.width * ratio;
            signaturePadObj.canvas.height = rect.height * ratio;
            signaturePadObj.canvas.style.width = rect.width + 'px';
            signaturePadObj.canvas.style.height = rect.height + 'px';

            signaturePadObj.ctx.setTransform(1, 0, 0, 1, 0, 0);
            signaturePadObj.ctx.scale(ratio, ratio);
            signaturePadObj.ctx.lineWidth = 2;
            signaturePadObj.ctx.lineCap = 'round';
            signaturePadObj.ctx.lineJoin = 'round';
            signaturePadObj.ctx.strokeStyle = '#000';
            signaturePadObj.ctx.fillStyle = '#fff';
            signaturePadObj.ctx.fillRect(0, 0, rect.width, rect.height);
        }

        function getPos(e) {
            const rect = signaturePadObj.canvas.getBoundingClientRect();
            if (e.touches && e.touches.length) {
                return {
                    x: e.touches[0].clientX - rect.left,
                    y: e.touches[0].clientY - rect.top
                };
            }
            return {
                x: e.clientX - rect.left,
                y: e.clientY - rect.top
            };
        }

        function startDraw(e) {
            e.preventDefault();
            signaturePadObj.drawing = true;
            const pos = getPos(e);
            signaturePadObj.ctx.beginPath();
            signaturePadObj.ctx.moveTo(pos.x, pos.y);
        }

        function draw(e) {
            if (!signaturePadObj.drawing) return;
            e.preventDefault();
            const pos = getPos(e);
            signaturePadObj.ctx.lineTo(pos.x, pos.y);
            signaturePadObj.ctx.stroke();
            signaturePadObj.hasDrawn = true;
        }

        function endDraw(e) {
            if (!signaturePadObj.drawing) return;
            e.preventDefault();
            signaturePadObj.drawing = false;
            signaturePadObj.ctx.closePath();
        }

        function clearSignature() {
            const rect = wrapper.getBoundingClientRect();
            signaturePadObj.ctx.clearRect(0, 0, signaturePadObj.canvas.width, signaturePadObj.canvas.height);
            signaturePadObj.ctx.setTransform(1, 0, 0, 1, 0, 0);
            signaturePadObj.ctx.scale(
                Math.max(window.devicePixelRatio || 1, 1),
                Math.max(window.devicePixelRatio || 1, 1)
            );
            signaturePadObj.ctx.fillStyle = '#fff';
            signaturePadObj.ctx.fillRect(0, 0, rect.width, rect.height);
            signaturePadObj.ctx.lineWidth = 2;
            signaturePadObj.ctx.lineCap = 'round';
            signaturePadObj.ctx.lineJoin = 'round';
            signaturePadObj.ctx.strokeStyle = '#000';
            hiddenInput.value = '';
            signaturePadObj.hasDrawn = false;
        }

        function loadSignatureImage(base64) {
            if (!base64) return;

            const img = new Image();
            img.onload = function () {
                const rect = wrapper.getBoundingClientRect();

                signaturePadObj.ctx.fillStyle = '#fff';
                signaturePadObj.ctx.fillRect(0, 0, rect.width, rect.height);

                signaturePadObj.ctx.drawImage(img, 0, 0, rect.width, rect.height);
                signaturePadObj.hasDrawn = true;
            };
            img.src = base64;
        }

        resizeCanvas();

        const newCanvas = signaturePadObj.canvas.cloneNode(true);
        signaturePadObj.canvas.parentNode.replaceChild(newCanvas, signaturePadObj.canvas);
        signaturePadObj.canvas = newCanvas;
        signaturePadObj.ctx = signaturePadObj.canvas.getContext('2d');
        resizeCanvas();

        signaturePadObj.canvas.addEventListener('mousedown', startDraw);
        signaturePadObj.canvas.addEventListener('mousemove', draw);
        signaturePadObj.canvas.addEventListener('mouseup', endDraw);
        signaturePadObj.canvas.addEventListener('mouseleave', endDraw);

        signaturePadObj.canvas.addEventListener('touchstart', startDraw, { passive: false });
        signaturePadObj.canvas.addEventListener('touchmove', draw, { passive: false });
        signaturePadObj.canvas.addEventListener('touchend', endDraw, { passive: false });

        clearBtn.onclick = clearSignature;

        form.addEventListener('submit', function () {
            if (signaturePadObj.hasDrawn) {
                hiddenInput.value = signaturePadObj.canvas.toDataURL('image/png');
            }
        });

        if (hiddenInput.value) {
            loadSignatureImage(hiddenInput.value);
        }

        window.paymentSignaturePad = {
            clear: clearSignature,
            load: loadSignatureImage
        };
    }

    const modal = document.getElementById('paymentRLAModal');
    if (modal) {
        modal.addEventListener('shown.bs.modal', function () {
            setTimeout(initSignaturePad, 150);
        });
    }
});
</script>
    </div>

    

@endsection