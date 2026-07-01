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
        font-size: 15px;
        padding: 0 2px;
    }

    .form-control-plain{
        width: 100%;
        min-width: 0;
        border: none;
        outline: none;
        background: transparent;
        font-size: 12px;
        padding: 0 2px;
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
                            <h4 class="card-title"><span class="badge bg-warning p-3">LF 06-02 : REPORT TEST</span></h4>
                         
                        </div>
                       {{-- <a class="btn btn-sm btn-icon btn-success mt-3"
                            data-bs-toggle="modal"
                            data-bs-target="#viewRLAModal"
                            data-bs-placement="top"
                            aria-label="Generate RLA No."
                            title="Generate RLA No.">
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
                                            {{-- <th class="text-wrap">Payment</th>
                                            <th class="text-wrap">Status</th> --}}
                                            <th class="text-wrap">Status</th>
                                            <th style="text-wrap">Action</th>
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
                                                                                    <small class="text-primary">Done</small>
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
                                                 {{-- <td class="text-wrap">{{ $r->payment}}</td> --}}
                                                {{-- <td>@if($r->status == 0)
                                                    <span class="badge bg-secondary p-2"> On Process</span>
                                                    @elseif($r->status == 1)
                                                    <span class="badge bg-primary p-2"> Order of Payment</span>
                                                    @elseif($r->status == 2)
                                                    <span class="badge bg-info p-2"> Job Routing Form</span>
                                                    @elseif($r->status == 3)
                                                    <span class="badge bg-secondary p-2"> Equipments Logs</span>
                                                     @elseif($r->status == 4)
                                                    <span class="badge bg-secondary p-2"> Equipments Logs</span>
                                                     @elseif($r->status == 5)
                                                    <span class="badge bg-info p-2"> Sample Disposal Logs</span>
                                                     @elseif($r->status == 6)
                                                    <span class="badge bg-warning p-2">Preparation Report Test</span>
                                                    @elseif($r->status == 7)
                                                    <span class="badge bg-success p-2">Release </span>
                                                    @else
                                                     <span class="badge bg-danger p-2">Hold</span>
                                                    @endif
                                                </td> --}}
                                                {{-- <td>Page 1</td> --}}
                                                <td class="text-wrap">
                                                    @php
                                                        $isDisabled = $r->status != 8;
                                                    @endphp
                                                    <div class="flex align-items-center list-user-action">
                                                        {{-- <a class="btn btn-sm btn-icon btn-warning editRlaBtn {{ $isDisabled ? 'disabled' : '' }}"
                                                            href="javascript:void(0);"
                                                            data-bs-toggle="{{ $isDisabled ? '' : 'modal' }}"
                                                            data-bs-target="{{ $isDisabled ? '' : '#editRLAModal' }}"
                                                            data-id="{{ $r->id }}"
                                                            style="{{ $isDisabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                            title="Edit"
                                                            aria-label="Edit">
                                                                <span class="btn-inner">
                                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                </span>
                                                            </a> --}}
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
                                                        href="{{ route('Reporttest.download.pdf', $r->id) }}" data-download
                                                        data-bs-toggle="tooltip"
                                                        title="Download PDF">
                                                            <span class="btn-inner">
                                                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                      {{-- <button
                                                            type="button"
                                                            class="btn btn-icon btn-danger openDownloadModal  {{ $isDisabled ? 'disabled' : '' }}"
                                                            data-rla-id="{{ $r->id }}"
                                                            title="Download PDF"
                                                            data-bs-toggle="{{ $isDisabled ? '' : 'modal' }}"
                                                            data-bs-target="{{ $isDisabled ? '' : '#downloadEnvironmentalModal' }}"
                                                          
                                                            style="{{ $isDisabled ? 'pointer-events:none; opacity:0.6;' : '' }}">

                                                            <span class="btn-inner">
                                                                     <svg class="icon-18" width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path>
                                                                    </svg>
                                                            </span>
                                                        </button> --}}
                                                            {{-- <form action="{{ route('rla.delete', $r->id) }}" method="POST" class="delete-form d-inline">
                                                                @csrf
                                                                @method('DELETE')

                                                                 <button type="submit"
                                                                    class="btn btn-sm btn-icon btn-danger {{ $isDisabled ? 'disabled' : '' }}"
                                                                    style="{{ $isDisabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                                    title="Delete">
                                                                    <span class="btn-inner">
                                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                                            <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        </svg>
                                                                    </span>
                                                                </button>
                                                            
                                                            </form> --}}
                                                          
                                                                {{-- <form action="{{ route('update.statusRLA', $r->id) }}" method="POST" class="d-inline check-form">
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
                                                                                form.submit(); // 🔥 submit POST
                                                                            }
                                                                        });
                                                                    });


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
            {{-- add data modal --}}
         {{-- <div class="modal fade" id="downloadEnvironmentalModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form action="{{ route('Reporttest.download.pdf') }}" method="GET" target="_blank">
                            <div class="modal-header">
                                <h5 class="modal-title">Download Report PDF</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" name="rla_id" id="modal_rla_id">
                                <label class="form-label">Select Report Type</label>
                                <select name="report_type" id="report_type" class="form-control" required>
                                    <option value="">-- Select Report Type --</option>
                                    <option value="CHEM">Report test for Chem</option>
                                    <option value="MICRO">Report test for Micro</option>
                                    <option value="FIS">Report Test for FIS</option>
                                </select>

                                <br>

                                <label class="form-label">Select Form</label>
                                <select name="form_type" id="form_type" class="form-control" required>
                                    <option value="">-- Select Form --</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Download PDF</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div> --}}

       <script>
document.addEventListener('DOMContentLoaded', function () {
    const downloadModal = document.getElementById('downloadEnvironmentalModal');
    const reportType = document.getElementById('report_type');
    const formType = document.getElementById('form_type');

    const forms = {
        CHEM: [
            { value: 'histamine', text: 'LF 08-01-01 (Histamine)' },
            { value: 'moisture', text: 'LF 08-01-02 (Moisture)' },
            { value: 'physico_chem_water', text: 'LF 08-01-07 (Physico-Chem Water)' },
        ],
        MICRO: [
            { value: 'meat', text: 'LF 08-01-03 (Meat)' },
            { value: 'water', text: 'LF 08-01-04 (Bacterial analysis for water)' },
        ],
        FIS: [
            { value: 'molecular', text: 'LF 08-01-05 (Molecular Analysis)' },
            { value: 'gross_parasitology', text: 'LF 08-01-06 (Gross and PARASITOLOGY)' },
        ],
    };

    downloadModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('modal_rla_id').value = button.getAttribute('data-rla-id');

        reportType.value = '';
        formType.innerHTML = '<option value="">-- Select Form --</option>';
    });

    reportType.addEventListener('change', function () {
        formType.innerHTML = '<option value="">-- Select Form --</option>';

        if (forms[this.value]) {
            forms[this.value].forEach(function (item) {
                formType.innerHTML += `<option value="${item.value}">${item.text}</option>`;
            });
        }
    });
});
</script>
            {{-- edit modal --}}
        <div class="modal fade" id="editRLAModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewPdfModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
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
                                        <div>Page No:</div>
                                        <div>Page 1 of 2</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>Document Code:</div>
                                        <div><strong>LF 06-02</strong></div>
                                    </td>
                                    <td colspan="3" class="section-title">
                                        Request for Laboratory Analysis
                                    </td>
                                </tr>
                            </table>

                            <form method="POST" id="editRLAForm">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="edit_id" id="edit_id">
                                <input type="hidden" name="edit_company_name" id="edit_company_name">

                                <table class="bordered mb-3" style="color:black; width:100%; border-collapse:collapse;">
                                    <colgroup>
                                        <col style="width: 35%;">
                                        <col style="width: 35%;">
                                        <col style="width: 30%;">
                                    </colgroup>

                                    <tr>
                                        <td>Name of Company</td>
                                        <td colspan="1">
                                            <select name="edit_user_id" id="edit_user_id" class="form-control">
                                                <option value="">-- Select Customer --</option>
                                                @foreach ($clients as $c)
                                                    <option value="{{ $c->id }}">
                                                        {{ $c->company_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            RLA No.
                                            <input type="text" name="edit_RLA_no" id="edit_RLA_no" class="meta-input form-control">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Address</td>
                                        <td>
                                            <input type="text" name="edit_location" id="edit_location" class="meta-input form-control">
                                        </td>
                                        <td class="text-wrap">
                                            <strong>ATTN:</strong> EUGENE GAY B. JAMORA<br>
                                            Laboratory Manager<br>
                                            Telefax: (083)5529328
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Contact No</td>
                                        <td class="mt-3 mb-3 p-3">
                                            <input type="text" name="edit_contact_no" id="edit_contact_no" class="meta-input form-control">
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>Source of Sample</td>
                                        <td>
                                            <input type="text" name="edit_source_sample" id="edit_source_sample" class="meta-input form-control">
                                        </td>
                                        <td>
                                            <label>
                                                <input type="radio" name="edit_sample" value="official"> Official Sample
                                            </label>
                                            &nbsp;&nbsp;
                                            <label>
                                                <input type="radio" name="edit_sample" value="industry"> Industry Sample
                                            </label>
                                            <br><br>
                                            Date Collected:
                                            <input type="date" name="edit_date_collected" id="edit_date_collected" class="meta-input form-control">
                                        </td>
                                    </tr>
                                </table>

                                <table class="table table-bordered" id="editSampleTable" style="border: #000;">
                                    <thead>
                                        <tr style="text-align:center; font-weight:bold;">
                                            <td class="text-wrap">Laboratory Code</td>
                                            <td class="text-wrap">Sample Description</td>
                                            <td class="text-wrap">Sample Code</td>
                                            <td class="text-wrap">Analyses Requested</td>
                                            <td class="text-wrap">Test Method</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody id="editSampleTableBody">
                                        <tr>
                                            <td><input type="text" name="edit_laboratory_code[]" class="meta-input form-control"></td>
                                            <td><input type="text" name="edit_sample_description[]" class="meta-input form-control"></td>
                                            <td><input type="text" name="edit_sample_code[]" class="meta-input form-control"></td>
                                            <td><input type="text" name="edit_analysis_requested[]" class="meta-input form-control"></td>
                                            <td><input type="text" name="edit_test_method[]" class="meta-input form-control"></td>
                                            <td><button type="button" class="btn btn-danger btn-sm editRemoveRow">Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <button type="button" class="btn btn-primary btn-sm mb-3" id="editAddRow">Add Row</button>

                                <table class="bordered mb-3" style="color:black; width:100%; border-collapse:collapse;">
                                    <colgroup>
                                        <col style="width: 35%;">
                                        <col style="width: 20%;">
                                        <col style="width: 45%;">
                                    </colgroup>

                                    <tr>
                                        <td>
                                            Sample Received by:<br>
                                            <input type="text" name="edit_sample_received_by" id="edit_sample_received_by" class="meta-input form-control mt-3"><br><br>
                                            <small>(Customer Service Officer)</small>
                                            <input type="text" name="edit_service_officer" id="edit_service_officer" class="meta-input form-control mt-3"><br><br>
                                        </td>
                                        <td>
                                            Date Received<br>
                                            <input type="date" name="edit_date_received" id="edit_date_received" class="meta-input form-control mt-3">
                                        </td>
                                        <td>
                                            Payment (<label>Partial</label> / <label>Full</label>) Amount
                                            <input type="text" name="edit_payment" id="edit_payment" class="meta-input form-control mt-3" placeholder="0.00">

                                            Date payment received<br>
                                            <input type="date" name="edit_date_payment" id="edit_date_payment" class="meta-input form-control mt-3">

                                            <br><br>

                                            OR No.:<br>
                                            <input type="text" name="edit_or_no" id="edit_or_no" class="meta-input form-control mt-3">
                                        </td>
                                    </tr>
                                </table>

                                <div class="col-md-6 position-relative mt-4 mb-2">
                                    <label for="edit_remarks" class="form-label">Remarks :</label>
                                    <input type="text" class="form-control meta-input" id="edit_remarks" required name="edit_remarks">
                                </div>
                                <div class="modal-footer">
                                       <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> Update
                                </button>
                                </div>
                             
                            </form>
                        </div>
                    </div>

                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div> --}}
                </div>
            </div>
        </div>
        <script>
            function editGenerateRow(row = {}) {
                return `
                    <tr>
                        <td>
                            <input type="text" name="edit_laboratory_code[]" class="meta-input form-control" value="${row.laboratory_code ?? ''}">
                        </td>
                        <td>
                            <input type="text" name="edit_sample_description[]" class="meta-input form-control" value="${row.sample_description ?? ''}">
                        </td>
                        <td>
                            <input type="text" name="edit_sample_code[]" class="meta-input form-control" value="${row.sample_code ?? ''}">
                        </td>
                        <td>
                            <input type="text" name="edit_analysis_requested[]" class="meta-input form-control" value="${row.analysis_requested ?? ''}">
                        </td>
                        <td>
                            <input type="text" name="edit_test_method[]" class="meta-input form-control" value="${row.test_method ?? ''}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm editRemoveRow">Remove</button>
                        </td>
                    </tr>
                `;
            }

            function editResetSampleTable() {
                $('#editSampleTableBody').html(editGenerateRow());
            }

            function editLoadSampleRows(rows) {
                let tableBody = $('#editSampleTableBody');
                tableBody.html('');

                if (rows && rows.length > 0) {
                    rows.forEach(function(row) {
                        tableBody.append(editGenerateRow(row));
                    });
                } else {
                    tableBody.append(editGenerateRow());
                }
            }

            $(document).ready(function () {
                const editUserElement = document.getElementById('edit_user_id');

                const editChoices = new Choices(editUserElement, {
                    searchEnabled: true,
                    itemSelectText: '',
                    shouldSort: false,
                    position: 'bottom',
                });

                $('#edit_user_id').on('change', function () {
                    let userId = $(this).val();
                    let selectedText = $('#edit_user_id option:selected').text();

                    $('#edit_company_name').val(selectedText);

                    if (userId) {
                        $.ajax({
                            url: '/get-User-info/' + userId,
                            type: 'GET',
                            success: function (data) {
                                $('#edit_location').val(data.address ?? data.location ?? '');
                                $('#edit_contact_no').val(data.contact_no ?? '');
                                $('#edit_source_sample').val(data.source_sample ?? '');
                            }
                        });
                    } else {
                        $('#edit_company_name').val('');
                        $('#edit_location').val('');
                        $('#edit_contact_no').val('');
                        $('#edit_source_sample').val('');
                    }
                });

                $('#editAddRow').on('click', function () {
                    $('#editSampleTableBody').append(editGenerateRow());
                });

                $(document).on('click', '.editRemoveRow', function () {
                    if ($('#editSampleTableBody tr').length > 1) {
                        $(this).closest('tr').remove();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Cannot remove the last row.'
                        });
                    }
                });

                $('.editRlaBtn').on('click', function () {
                    let id = $(this).data('id');

                    $('#edit_id').val(id);
                    $('#editRLAForm').attr('action', '/rla/' + id);

                    $.ajax({
                        url: '/rla/' + id + '/edit',
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            console.log('EDIT RESPONSE:', response);

                            $('#edit_id').val(response.id ?? '');
                            $('#edit_company_name').val(response.edit_company_name ?? '');
                            $('#edit_RLA_no').val(response.edit_RLA_no ?? '');
                            $('#edit_location').val(response.edit_location ?? '');
                            $('#edit_contact_no').val(response.edit_contact_no ?? '');
                            $('#edit_source_sample').val(response.edit_source_sample ?? '');
                            $('#edit_date_collected').val(response.edit_date_collected ?? '');
                            $('#edit_sample_received_by').val(response.edit_sample_received_by ?? '');
                            $('#edit_service_officer').val(response.edit_service_officer ?? '');
                            $('#edit_date_received').val(response.edit_date_received ?? '');
                            $('#edit_payment').val(response.edit_payment ?? '');
                            $('#edit_date_payment').val(response.edit_date_payment ?? '');
                            $('#edit_or_no').val(response.edit_or_no ?? '');
                            $('#edit_remarks').val(response.edit_remarks ?? '');

                            $('input[name="edit_sample"]').prop('checked', false);
                            if (response.edit_sample) {
                                $('input[name="edit_sample"][value="' + response.edit_sample + '"]').prop('checked', true);
                            }

                            if (response.edit_user_id) {
                                $('#edit_user_id').val(response.edit_user_id);
                                editChoices.setChoiceByValue(String(response.edit_user_id));
                            } else {
                                editChoices.removeActiveItems();
                            }

                            // THIS IS THE IMPORTANT PART
                            editLoadSampleRows(response.rows);
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to fetch record data.'
                            });

                            editResetSampleTable();
                        }
                    });
                });

                $('#edit_payment').on('blur', function () {
                    let value = parseFloat(this.value);
                    if (!isNaN(value)) {
                        this.value = value.toFixed(2);
                    } else {
                        this.value = '';
                    }
                });
            });
        </script>
                


    </div>

    

@endsection