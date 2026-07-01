@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script>
    <script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js'></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <style>
    .edit-custom-multi-wrapper {
        position: relative;
        width: 220px;
        min-width: 220px;
        font-family: Arial, sans-serif;
        z-index: 999;
    }

    .edit-custom-multi-box {
        min-height: 38px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        background: #fff;
        padding: 6px 35px 6px 8px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 5px;
        cursor: pointer;
        position: relative;
    }

    .edit-custom-multi-box:hover,
    .edit-custom-multi-wrapper.open .edit-custom-multi-box {
        border-color: #0d6efd;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.15);
    }

    .edit-custom-multi-box.disabled {
        background: #e9ecef;
        cursor: not-allowed;
    }

    .edit-custom-multi-placeholder {
        color: #6c757d;
        font-size: 14px;
    }

    .edit-custom-multi-arrow {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        color: #777;
        pointer-events: none;
    }

    .edit-custom-multi-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 5px);
        left: 0;
        width: 300px;
        max-height: 230px;
        overflow-y: auto;
        background: #fff;
        border: 1px solid #d5d5d5;
        border-radius: 6px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        z-index: 999999 !important;
        padding: 5px;
    }

    .edit-custom-multi-wrapper.open {
        z-index: 999999 !important;
    }

    .edit-custom-multi-wrapper.open .edit-custom-multi-dropdown {
        display: block;
    }

    .edit-custom-multi-option {
        padding: 9px 10px 9px 30px;
        cursor: pointer;
        border-radius: 4px;
        font-size: 14px;
        position: relative;
        color: #111;
        background: #fff;
        white-space: normal;
        line-height: 1.3;
    }

    .edit-custom-multi-option:hover {
        background: #f1f5ff;
    }

    .edit-custom-multi-option.selected {
        background: #0d6efd;
        color: #fff;
    }

    .edit-custom-multi-option.selected::before {
        content: "✓";
        position: absolute;
        left: 9px;
        top: 8px;
        font-weight: bold;
    }

    .edit-custom-multi-tag {
        background: #e9ecef;
        color: #000;
        border-radius: 15px;
        padding: 3px 8px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 5px;
        max-width: 165px;
    }

    .edit-custom-multi-tag span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .edit-custom-multi-remove {
        background: #9e9e9e;
        color: #fff;
        border-radius: 50%;
        width: 17px;
        height: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        line-height: 1;
        flex-shrink: 0;
    }

    .edit_analysis_requested {
        display: none !important;
    }

    #editSampleTable td {
        position: relative;
        vertical-align: top;
        overflow: visible !important;
    }

    #editSampleTable,
    #editSampleTable tbody,
    #editSampleTable tr {
        overflow: visible !important;
    }
</style>    
 <style>
    /* IMPORTANT: para dili ma-cut ang dropdown sulod sa table */
    .table-responsive {
        overflow-x: auto !important;
        overflow-y: visible !important;
        padding-bottom: 260px !important;
    }

    #sampleTable,
    #sampleTable tbody,
    #sampleTable tr,
    #sampleTable td {
        overflow: visible !important;
    }

    #sampleTable td {
        position: relative;
        vertical-align: top;
    }

    .custom-multi-wrapper {
        position: relative;
        width: 220px;
        min-width: 220px;
        font-family: Arial, sans-serif;
        z-index: 999;
    }

    .custom-multi-box {
        min-height: 38px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        background: #fff;
        padding: 6px 35px 6px 8px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 5px;
        cursor: pointer;
        position: relative;
        box-shadow: none;
    }

    .custom-multi-box:hover,
    .custom-multi-wrapper.open .custom-multi-box {
        border-color: #0d6efd;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.15);
    }

    .custom-multi-box.disabled {
        background: #e9ecef;
        cursor: not-allowed;
    }

    .custom-multi-placeholder {
        color: #6c757d;
        font-size: 14px;
    }

    .custom-multi-arrow {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        color: #777;
        pointer-events: none;
    }

    .custom-multi-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 5px);
        left: 0;
        width: 260px;
        max-height: 230px;
        overflow-y: auto;
        background: #fff;
        border: 1px solid #d5d5d5;
        border-radius: 6px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        z-index: 999999 !important;
        padding: 5px;
    }

    .custom-multi-wrapper.open {
        z-index: 999999 !important;
    }

    .custom-multi-wrapper.open .custom-multi-dropdown {
        display: block;
    }

    .custom-multi-option {
        padding: 9px 10px 9px 30px;
        cursor: pointer;
        border-radius: 4px;
        font-size: 14px;
        position: relative;
        color: #111;
        background: #fff;
        white-space: normal;
        line-height: 1.3;
    }

    .custom-multi-option:hover {
        background: #f1f5ff;
    }

    .custom-multi-option.selected {
        background: #0d6efd;
        color: #fff;
    }

    .custom-multi-option.selected::before {
        content: "✓";
        position: absolute;
        left: 9px;
        top: 8px;
        font-weight: bold;
    }

    .custom-multi-tag {
        background: #e9ecef;
        color: #000;
        border-radius: 15px;
        padding: 3px 8px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 5px;
        max-width: 165px;
    }

    .custom-multi-tag span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .custom-multi-remove {
        background: #9e9e9e;
        color: #fff;
        border-radius: 50%;
        width: 17px;
        height: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        line-height: 1;
        flex-shrink: 0;
    }

    .analysis_requested {
        display: none !important;
    }
        .analysis-table-wrapper::-webkit-scrollbar {
        height: 18px; /* mao ni kadako sa horizontal scrollbar */
       
    }

</style>

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
                            <h4 class="card-title"><span class="badge bg-warning p-3">DOCUMENT CODE : LF 06-02</span></h4>
                         
                        </div>
                       <a class="btn btn-sm btn-icon btn-success mt-3"
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
                            </a>
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
                                            <th style="text-wrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rla as $r)
                                             <tr>
                                            
                                                <td class="text-wrap">{{ $r->RLA_no}}</td>
                                                <td class="text-wrap">{{ $r->company_name}}</td>
                                                <td class="text-wrap">{{ $r->display_address ?? $r->address ?? '' }}</td>
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
                                                <td class="text-wrap">
                                                    @php
                                                        $isDisabled = $r->status != 0 && $r->status != 1;
                                                        $isDisableds = $r->status != 0;
                                                    @endphp
                                                    <div class="flex align-items-center list-user-action">
                                                        <a class="btn btn-sm btn-icon btn-warning editRlaBtn {{ $isDisabled ? 'disabled' : '' }}"
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
                                                            href="{{ route('rla.download.pdf', $r->id) }}" data-download
                                                            data-bs-toggle="tooltip"
                                                            title="Download PDF">
                                                                <span class="btn-inner">
                                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path>
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                            <form action="{{ route('rla.delete', $r->id) }}" method="POST" class="delete-form d-inline">
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
                                                            
                                                            </form>
                                                          
                                                             <form action="{{ route('update.statusRLA', $r->id) }}" method="POST" class="d-inline check-form">
                                                                    @csrf
                                                                     <button type="submit"
                                                                        class="btn btn-sm btn-icon btn-success check-btn {{ $isDisableds ? 'disabled' : '' }}"
                                                                        style="{{ $isDisableds ? 'pointer-events:none; opacity:0.6;' : '' }}"
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
                                                                </script>
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
            <div class="modal fade" id="viewRLAModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewPdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <!-- TOP HEADER -->
                        <div class="form-sheet">
                            <table class="bordered mb-2">
                                <colgroup>
                                    <col style="width: 110px;">
                                    <col>
                                </colgroup>
                                <tr>
                                    <td class="logo-cell" >
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

                            <!-- DOCUMENT INFO -->
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
                             <form method="POST" action="{{ route('lf_06_02.store')}}">
                                  @csrf
                                <table class="bordered mb-3" style="color:black; width:100%; border-collapse:collapse;">
                                    <colgroup>
                                        <col style="width: 35%;">
                                        <col style="width: 35%;">
                                        <col style="width: 30%;">
                                    </colgroup>

                                    <tr>
                                    <td>Name of Company</td>
                                    <td colspan="1">

                                        <input type="hidden" name="company_name" id="company_name">

                                        <select name="user_id" id="user_id">
                                            <option value="">-- Select Customer --</option>

                                            @foreach ($clients as $c)
                                                <option value="{{ $c->id }}">
                                                    {{ $c->company_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </td>

                                      <script>
                                        document.addEventListener("DOMContentLoaded", function () {

                                            const element = document.getElementById('user_id');

                                            const choices = new Choices(element, {
                                                searchEnabled: true,
                                                itemSelectText: '',
                                                shouldSort: false,
                                                position: 'bottom', 
                                            });

                                            element.addEventListener('change', function () {

                                                let UserId = this.value;
                                                let selectedText = this.options[this.selectedIndex].text;

                                                document.getElementById("company_name").value = selectedText;

                                                if (UserId) {
                                                    $.ajax({
                                                        url: '/get-User-info/' + UserId,
                                                        type: 'GET',
                                                        success: function (data) {
                                                            $('#location').val(data.address);
                                                            $('#contact_no').val(data.contact_no);
                                                            $('#source_sample').val(data.source_sample);
                                                        }
                                                    });
                                                } else {
                                                    $('#location, #contact_no, #source_sample').val('');
                                                }

                                            });

                                        });
                                        </script>

                                       
                                    <td>
                                        RLA No.
                                        <input type="text" name="RLA_no" id="RLA_no" class="meta-input form-control" readonly>
                                    </td>

                                    <script>
                                    $(document).ready(function () {
                                        $(document).on('click', '[data-bs-target="#viewRLAModal"]', function () {
                                            

                                            $('#RLA_no').val('');

                                            $.ajax({
                                                url: "{{ route('generate.rla.no') }}",
                                                type: "GET",
                                                dataType: "json",
                                                success: function (response) {
                                                    console.log('response:', response.RLA_no);

                                                    if (response.success) {
                                                        $('#RLA_no').val(response.RLA_no);
                                                    } else {
                                                        Swal.fire({
                                                            icon: 'warning',
                                                            title: 'Warning',
                                                            text: 'Unable to generate RLA number.'
                                                        });
                                                    }
                                                },
                                                error: function (xhr) {
                                                    console.log('AJAX error:', xhr.responseText);

                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error',
                                                        text: 'Failed to generate RLA number.'
                                                    });
                                                }
                                            });
                                        });
                                    });
                                    </script>
                                    </tr>
                                    <!-- Row 2 -->
                                    <tr>
                                        <td>Address</td>
                                        <td>
                                            <div class="input-group">

                                                <input type="text"
                                                    name="location"
                                                    id="location"
                                                    class="meta-input form-control"
                                                    value="{{ $data->location ?? '' }}"
                                                    readonly>

                                                <button type="button"
                                                        class="btn btn-primary"
                                                        onclick="openMapSwal()">

                                                    <i class="bi bi-geo-alt-fill"></i> See Maps

                                                </button>

                                            </div>
                                        </td>



                                    <script>

                                        let swalMap;
                                        let swalMarker;

                                        function openMapSwal()
                                        {
                                            let locationValue = $('#location').val();

                                            let defaultLat = 8.4852;
                                            let defaultLng = 123.8043;

                                            let lat = defaultLat;
                                            let lng = defaultLng;

                                            // GET SAVED COORDINATES
                                            if (locationValue) {

                                                let coords = locationValue.split(',');

                                                if (coords.length === 2) {

                                                    lat = parseFloat(coords[0]);
                                                    lng = parseFloat(coords[1]);

                                                }
                                            }


                                            Swal.fire({

                                                title: 'Location Map',

                                                html: `
                                                    <div id="swalMap"
                                                        style="
                                                            width:100%;
                                                            height:650px;
                                                            border-radius:10px;
                                                        ">
                                                    </div>
                                                `,

                                                width: '90%',

                                                showConfirmButton: false,

                                                showCloseButton: true,

                                                didOpen: () => {

                                                    // REMOVE OLD MAP INSTANCE
                                                    if (swalMap) {
                                                        swalMap.remove();
                                                    }

                                                    // TILE LAYERS
                                                    let satellite = L.tileLayer(
                                                        'http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',
                                                        {
                                                            maxZoom: 20,
                                                            subdomains:['mt0','mt1','mt2','mt3']
                                                        }
                                                    );

                                                    let streets = L.tileLayer(
                                                        'http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',
                                                        {
                                                            maxZoom: 20,
                                                            subdomains:['mt0','mt1','mt2','mt3']
                                                        }
                                                    );

                                                    // CREATE MAP
                                                    swalMap = L.map('swalMap', {
                                                        center: [lat, lng],
                                                        zoom: 18,
                                                        layers: [satellite]
                                                    });

                                                    let baseLayers = {
                                                        "Satellite": satellite,
                                                        "Streets": streets
                                                    };
                                                    const greenIcon = L.icon({
                                                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',

                                                        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',

                                                        iconSize: [45, 70],      
                                                        iconAnchor: [22, 70],
                                                        popupAnchor: [1, -34],
                                                        shadowSize: [70, 70]
                                                    });
                                                    L.control.layers(baseLayers).addTo(swalMap);

                                                swalMarker = L.marker([lat, lng], {
                                                        icon: greenIcon
                                                    }).addTo(swalMap);
                                                
                                                    setTimeout(() => {
                                                        swalMap.invalidateSize();
                                                    }, 300);

                                                }

                                            });
                                        }

                                    </script>

                                        <td class="text-wrap">
                                            <strong>ATTN:</strong> EUGENE GAY B. JAMORA<br>
                                            Laboratory Manager<br>
                                            Telefax: (083)5529328
                                        </td>
                                    </tr>

                                    <!-- Row 3 -->
                                    <tr >
                                        <td >Contact No</td>
                                        <td class="mt-3 mb-3 p-3">
                                            <input type="text" name="contact_no" id="contact_no" class="meta-input form-control" >
                                        </td>
                                        <td></td>
                                    </tr>

                                    <!-- Row 4 -->
                                    <tr >
                                        <td>Source of Sample</td>
                                        <td>
                                            <input type="text" name="source_sample" id="source_sample" class="meta-input form-control" >
                                        </td>
                                        <td>
                                            <label >
                                                <input type="radio" name="sample" class="text-wrap" value="official"> Official Sample
                                            </label>
                                            &nbsp;&nbsp;
                                            <label>
                                                <input type="radio" name="sample" class="text-wrap" value="industry"> Industry Sample
                                            </label>
                                            <br><br>
                                            Date Collected:
                                            <input type="date" name="date_collected" class="meta-input form-control">
                                        </td>
                                    </tr>

                                 

                                    
                                </table>

                      <div class="table-responsive analysis-table-wrapper">
                            <table class="table table-bordered" id="sampleTable" style="border: #000;">
                                <tr style="text-align:center; font-weight:bold;">
                                    <td class="text-wrap" style="width: 300px">Laboratory Code</td>
                                    <td class="text-wrap" style="width: 300px">Sample Description</td>
                                    <td class="text-wrap" style="width: 300px">Sample Code</td>
                                    <td class="text-wrap" style="width: 300px">Lab Unit</td>
                                    <td class="text-wrap" style="width: 300px">Analysis Description</td>
                                    <td class="text-wrap" style="width: 300px">Analysis Requested</td>
                                    <td class="text-wrap" style="width: 300px">Test Method</td>
                                    <td style="width: 200px">Action</td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="text"
                                            name="laboratory_code[]"
                                            class="form-control laboratory_code"
                                            style="width: 200px"
                                            readonly>
                                    </td>

                                    <td>
                                        <input type="text"
                                            name="sample_description[]"
                                            class="form-control sample_description"
                                            style="width: 200px">
                                    </td>

                                    <td>
                                        <input type="text"
                                            name="sample_code[]"
                                            class="form-control sample_code"
                                            style="width: 200px">
                                    </td>

                                    <td>
                                        <select name="lab_unit[]" class="form-control lab_unit" style="width: 200px">
                                            <option value="">Select Lab Unit</option>
                                            <option value="FIS">FIS</option>
                                            <option value="CHEM">CHEM</option>
                                            <option value="MIC">MIC</option>
                                        </select>
                                    </td>

                                    <td>
                                        <select name="analysis_description[]"
                                                class="form-control analysis_description"
                                                style="width: 200px"
                                                disabled>
                                            <option value="">N/A</option>
                                        </select>
                                    </td>

                                    <td>
                                        <select name="analysis_requested[0][]"
                                                class="form-control analysis_requested"
                                                multiple>
                                        </select>

                                        <div class="custom-multi-wrapper">
                                            <div class="custom-multi-box">
                                                <span class="custom-multi-placeholder">Select Analysis</span>
                                                <span class="custom-multi-arrow">⌄</span>
                                            </div>
                                            <div class="custom-multi-dropdown"></div>
                                        </div>
                                    </td>

                                    <td>
                                        <input type="text"
                                            name="test_method[]"
                                            class="form-control test_method"
                                            style="width: 200px">
                                    </td>

                                    <td>
                                        <button type="button"
                                                class="btn btn-danger btn-sm removeRow"
                                                style="width: 150px">
                                            Remove
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <button type="button" class="btn btn-primary btn-sm mb-3 mt-3" id="addRow">
                            Add Row
                        </button>


                        <script>
                            let rowIndex = 1;

                            let laboratoryCodePrefix = '';
                            let nextLaboratoryNumber = 1;

                            /*
                            |--------------------------------------------------------------------------
                            | FIS OPTIONS
                            |--------------------------------------------------------------------------
                            */
                            const fisDescriptionOptions = [
                                'PCR',
                                'Parasitological Examination',
                                'Gross Examination'
                            ];

                            const fisRequestOptions = {
                                'PCR': [
                                    'EMS/AHPND',
                                    'WSSV',
                                    'EHP',
                                    'TILV'
                                ],

                                'Parasitological Examination': [
                                    'Parasitological Examination'
                                ],

                                'Gross Examination': [
                                    'Gross Examination'
                                ]
                            };

                            /*
                            |--------------------------------------------------------------------------
                            | CHEM OPTIONS
                            |--------------------------------------------------------------------------
                            */
                            const chemDescriptionOptions = [
                                'HISTAMINE',
                                'MOISTURE CONTENT',
                                'WATER QUALITY'
                            ];

                            const chemRequestOptions = {
                                'HISTAMINE': [
                                    'HISTAMINE'
                                ],

                                'MOISTURE CONTENT': [
                                    'MOISTURE CONTENT'
                                ],

                                'WATER QUALITY': [
                                    'pH',
                                    'Alkalinity',
                                    'Nitrite Nitrogen',
                                    'Calcium Hardness',
                                    'Dissolved Oxygen'
                                ]
                            };

                            /*
                            |--------------------------------------------------------------------------
                            | MIC OPTIONS
                            |--------------------------------------------------------------------------
                            */
                            const micDescriptionOptions = [
                                'FISH AND FISHERY PRODUCTS',
                                'WATER POTABILITY',
                                'WATER BACTERIOLOGY'
                            ];

                            const micRequestOptions = {
                                'FISH AND FISHERY PRODUCTS': [
                                    'APC',
                                    'E COLI',
                                    'S. AUREUS',
                                    'SALMONELLA',
                                    'SHIGELLA'
                                ],

                                'WATER POTABILITY': [
                                    'HPC',
                                    'E COLI',
                                    'TOTAL COLIFORM',
                                    'FECAL COLIFORM',
                                    'ENTEROCOCCI'
                                ],

                                'WATER BACTERIOLOGY': [
                                    'TOTAL LUMINOUS BACTERIAL COUNT',
                                    'TOTAL VIBRIO COUNT',
                                    '% YELLOW COLONIES',
                                    '% GREEN COLONIES'
                                ]
                            };

                            function formatLaboratoryCode(number) {
                                return laboratoryCodePrefix + String(number).padStart(3, '0');
                            }

                            function refreshLaboratoryCodes() {
                                let rows = document.querySelectorAll('#sampleTable tr');

                                rows.forEach(function (row, index) {
                                    if (index === 0) return;

                                    let labCodeInput = row.querySelector('.laboratory_code');

                                    if (labCodeInput) {
                                        labCodeInput.value = formatLaboratoryCode(nextLaboratoryNumber + index - 1);
                                    }
                                });
                            }

                            function getLatestLaboratoryCode() {
                                $.ajax({
                                    url: "{{ route('get.latest.laboratory.code') }}",
                                    type: "GET",
                                    dataType: "json",
                                    success: function (response) {
                                        if (response.success) {
                                            laboratoryCodePrefix = response.prefix;
                                            nextLaboratoryNumber = parseInt(response.next_number);

                                            refreshLaboratoryCodes();
                                        }
                                    },
                                    error: function () {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Unable to get latest laboratory code.',
                                        });
                                    }
                                });
                            }

                            function escapeHtml(value) {
                                if (value === null || value === undefined) {
                                    return '';
                                }

                                return String(value)
                                    .replace(/&/g, '&amp;')
                                    .replace(/"/g, '&quot;')
                                    .replace(/'/g, '&#039;')
                                    .replace(/</g, '&lt;')
                                    .replace(/>/g, '&gt;');
                            }

                            function createCustomMultiSelect(row) {
                                const select = row.querySelector('.analysis_requested');
                                const wrapper = row.querySelector('.custom-multi-wrapper');
                                const box = row.querySelector('.custom-multi-box');
                                const dropdown = row.querySelector('.custom-multi-dropdown');

                                if (!select || !wrapper || !box || !dropdown) return;

                                renderCustomMultiSelect(row);

                                box.onclick = function (e) {
                                    e.stopPropagation();

                                    if (box.classList.contains('disabled')) {
                                        return;
                                    }

                                    document.querySelectorAll('.custom-multi-wrapper').forEach(function (item) {
                                        if (item !== wrapper) {
                                            item.classList.remove('open');
                                        }
                                    });

                                    wrapper.classList.toggle('open');
                                };
                            }

                            function renderCustomMultiSelect(row) {
                                const select = row.querySelector('.analysis_requested');
                                const wrapper = row.querySelector('.custom-multi-wrapper');
                                const box = row.querySelector('.custom-multi-box');
                                const dropdown = row.querySelector('.custom-multi-dropdown');

                                if (!select || !wrapper || !box || !dropdown) return;

                                const selectedValues = Array.from(select.selectedOptions).map(option => option.value);

                                box.innerHTML = '';

                                if (select.options.length === 0) {
                                    box.classList.add('disabled');
                                    box.innerHTML = `
                                        <span class="custom-multi-placeholder">No options</span>
                                        <span class="custom-multi-arrow">⌄</span>
                                    `;
                                } else {
                                    box.classList.remove('disabled');

                                    if (selectedValues.length === 0) {
                                        box.innerHTML = `<span class="custom-multi-placeholder">Select Analysis</span>`;
                                    } else {
                                        selectedValues.forEach(function (value) {
                                            const tag = document.createElement('div');
                                            tag.className = 'custom-multi-tag';
                                            tag.innerHTML = `
                                                <span>${escapeHtml(value)}</span>
                                                <div class="custom-multi-remove" data-value="${escapeHtml(value)}">×</div>
                                            `;
                                            box.appendChild(tag);
                                        });
                                    }

                                    const arrow = document.createElement('span');
                                    arrow.className = 'custom-multi-arrow';
                                    arrow.innerHTML = '⌄';
                                    box.appendChild(arrow);
                                }

                                dropdown.innerHTML = '';

                                Array.from(select.options).forEach(function (option) {
                                    const item = document.createElement('div');
                                    item.className = 'custom-multi-option';

                                    if (option.selected) {
                                        item.classList.add('selected');
                                    }

                                    item.dataset.value = option.value;
                                    item.innerText = option.text;

                                    item.addEventListener('click', function (e) {
                                        e.stopPropagation();

                                        option.selected = !option.selected;

                                        renderCustomMultiSelect(row);
                                    });

                                    dropdown.appendChild(item);
                                });

                                row.querySelectorAll('.custom-multi-remove').forEach(function (removeBtn) {
                                    removeBtn.addEventListener('click', function (e) {
                                        e.stopPropagation();

                                        const value = this.dataset.value;

                                        Array.from(select.options).forEach(function (option) {
                                            if (option.value === value) {
                                                option.selected = false;
                                            }
                                        });

                                        renderCustomMultiSelect(row);
                                    });
                                });
                            }

                            function clearAnalysisRequested(row) {
                                const requestSelect = row.querySelector('.analysis_requested');

                                requestSelect.innerHTML = '';
                                renderCustomMultiSelect(row);
                            }

                            function loadAnalysisRequested(row, options, autoSelectSingle = false) {
                                const requestSelect = row.querySelector('.analysis_requested');

                                requestSelect.innerHTML = '';

                                options.forEach(function (item) {
                                    let option = document.createElement('option');
                                    option.value = item;
                                    option.text = item;

                                    if (autoSelectSingle && options.length === 1) {
                                        option.selected = true;
                                    }

                                    requestSelect.appendChild(option);
                                });

                                renderCustomMultiSelect(row);
                            }

                            function loadAnalysisDescription(descriptionSelect, options) {
                                descriptionSelect.disabled = false;
                                descriptionSelect.innerHTML = '<option value="">Select Analysis Description</option>';

                                options.forEach(function (item) {
                                    let option = document.createElement('option');
                                    option.value = item;
                                    option.text = item;

                                    descriptionSelect.appendChild(option);
                                });
                            }

                            function copyOptionsAndSelected(sourceSelect, targetSelect) {
                                targetSelect.innerHTML = '';

                                Array.from(sourceSelect.options).forEach(function (sourceOption) {
                                    let option = document.createElement('option');

                                    option.value = sourceOption.value;
                                    option.text = sourceOption.text;
                                    option.selected = sourceOption.selected;

                                    targetSelect.appendChild(option);
                                });
                            }

                            document.addEventListener('DOMContentLoaded', function () {
                                document.querySelectorAll('#sampleTable tr').forEach(function (row, index) {
                                    if (index > 0) {
                                        createCustomMultiSelect(row);
                                    }
                                });

                                getLatestLaboratoryCode();
                            });

                            
                            document.getElementById('addRow').addEventListener('click', function () {
                                let table = document.getElementById('sampleTable');
                                let newRow = table.insertRow(-1);

                                let rows = document.querySelectorAll('#sampleTable tr');
                                let sourceRow = rows[rows.length - 2];

                                let sourceSampleDescription = sourceRow.querySelector('.sample_description')
                                    ? sourceRow.querySelector('.sample_description').value
                                    : '';

                                let sourceSampleCode = sourceRow.querySelector('.sample_code')
                                    ? sourceRow.querySelector('.sample_code').value
                                    : '';

                                let sourceLabUnit = sourceRow.querySelector('.lab_unit')
                                    ? sourceRow.querySelector('.lab_unit').value
                                    : '';

                                let sourceDescriptionSelect = sourceRow.querySelector('.analysis_description');

                                let sourceDescriptionValue = sourceDescriptionSelect
                                    ? sourceDescriptionSelect.value
                                    : '';

                                let sourceDescriptionDisabled = sourceDescriptionSelect
                                    ? sourceDescriptionSelect.disabled
                                    : true;

                                let sourceRequestSelect = sourceRow.querySelector('.analysis_requested');

                                let sourceTestMethod = sourceRow.querySelector('.test_method')
                                    ? sourceRow.querySelector('.test_method').value
                                    : '';

                                newRow.innerHTML = `
                                    <td>
                                        <input type="text"
                                            name="laboratory_code[]"
                                            class="form-control laboratory_code"
                                            style="width: 200px"
                                            readonly>
                                    </td>

                                    <td>
                                        <input type="text"
                                            name="sample_description[]"
                                            class="form-control sample_description"
                                            style="width: 200px"
                                            value="${escapeHtml(sourceSampleDescription)}">
                                    </td>

                                    <td>
                                        <input type="text"
                                            name="sample_code[]"
                                            class="form-control sample_code"
                                            style="width: 200px"
                                            value="${escapeHtml(sourceSampleCode)}">
                                    </td>

                                    <td>
                                        <select name="lab_unit[]" class="form-control lab_unit" style="width: 200px">
                                            <option value="">Select Lab Unit</option>
                                            <option value="FIS">FIS</option>
                                            <option value="CHEM">CHEM</option>
                                            <option value="MIC">MIC</option>
                                        </select>
                                    </td>

                                    <td>
                                        <select name="analysis_description[]"
                                                class="form-control analysis_description"
                                                style="width: 200px">
                                        </select>
                                    </td>

                                    <td>
                                        <select name="analysis_requested[${rowIndex}][]"
                                                class="form-control analysis_requested"
                                                multiple>
                                        </select>

                                        <div class="custom-multi-wrapper">
                                            <div class="custom-multi-box">
                                                <span class="custom-multi-placeholder">Select Analysis</span>
                                                <span class="custom-multi-arrow">⌄</span>
                                            </div>
                                            <div class="custom-multi-dropdown"></div>
                                        </div>
                                    </td>

                                    <td>
                                        <input type="text"
                                            name="test_method[]"
                                            class="form-control test_method"
                                            style="width: 200px"
                                            value="${escapeHtml(sourceTestMethod)}">
                                    </td>

                                    <td>
                                        <button type="button"
                                                class="btn btn-danger btn-sm removeRow"
                                                style="width: 150px">
                                            Remove
                                        </button>
                                    </td>
                                `;

                                let newLabUnitSelect = newRow.querySelector('.lab_unit');
                                let newDescriptionSelect = newRow.querySelector('.analysis_description');
                                let newRequestSelect = newRow.querySelector('.analysis_requested');

                                newLabUnitSelect.value = sourceLabUnit;

                                if (sourceDescriptionSelect) {
                                    copyOptionsAndSelected(sourceDescriptionSelect, newDescriptionSelect);
                                    newDescriptionSelect.value = sourceDescriptionValue;
                                    newDescriptionSelect.disabled = sourceDescriptionDisabled;
                                } else {
                                    newDescriptionSelect.innerHTML = '<option value="">N/A</option>';
                                    newDescriptionSelect.disabled = true;
                                }

                                if (sourceRequestSelect) {
                                    copyOptionsAndSelected(sourceRequestSelect, newRequestSelect);
                                }

                                createCustomMultiSelect(newRow);
                                renderCustomMultiSelect(newRow);

                                rowIndex++;

                                refreshLaboratoryCodes();
                            });

                            document.addEventListener('click', function (e) {
                                if (e.target.classList.contains('removeRow')) {
                                    let table = document.getElementById('sampleTable');

                                    if (table.rows.length > 2) {
                                        e.target.closest('tr').remove();
                                        refreshLaboratoryCodes();
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Cannot remove last row',
                                        });
                                    }
                                }

                                if (!e.target.closest('.custom-multi-wrapper')) {
                                    document.querySelectorAll('.custom-multi-wrapper').forEach(function (wrapper) {
                                        wrapper.classList.remove('open');
                                    });
                                }
                            });

                          
                            document.addEventListener('change', function (e) {
                                if (e.target.classList.contains('lab_unit')) {
                                    let row = e.target.closest('tr');

                                    let descriptionSelect = row.querySelector('.analysis_description');
                                    let selectedLab = e.target.value;

                                    descriptionSelect.innerHTML = '';
                                    descriptionSelect.disabled = true;
                                    descriptionSelect.innerHTML = '<option value="">N/A</option>';

                                    clearAnalysisRequested(row);

                                    if (selectedLab === 'FIS') {
                                        loadAnalysisDescription(descriptionSelect, fisDescriptionOptions);
                                    }

                                    if (selectedLab === 'CHEM') {
                                        loadAnalysisDescription(descriptionSelect, chemDescriptionOptions);
                                    }

                                    if (selectedLab === 'MIC') {
                                        loadAnalysisDescription(descriptionSelect, micDescriptionOptions);
                                    }
                                }
                            });

                            document.addEventListener('change', function (e) {
                                if (e.target.classList.contains('analysis_description')) {
                                    let row = e.target.closest('tr');

                                    let labUnit = row.querySelector('.lab_unit').value;
                                    let selectedDescription = e.target.value;

                                    clearAnalysisRequested(row);

                                    if (selectedDescription === '') {
                                        return;
                                    }

                                    if (labUnit === 'FIS') {
                                        if (fisRequestOptions[selectedDescription]) {
                                            let autoSelectSingle = selectedDescription === 'Parasitological Examination'
                                                || selectedDescription === 'Gross Examination';

                                            loadAnalysisRequested(row, fisRequestOptions[selectedDescription], autoSelectSingle);
                                        }

                                        return;
                                    }

                                    if (labUnit === 'CHEM') {
                                        if (chemRequestOptions[selectedDescription]) {
                                            let autoSelectSingle = selectedDescription === 'HISTAMINE'
                                                || selectedDescription === 'MOISTURE CONTENT';

                                            loadAnalysisRequested(row, chemRequestOptions[selectedDescription], autoSelectSingle);
                                        }

                                        return;
                                    }

                                    if (labUnit === 'MIC') {
                                        if (micRequestOptions[selectedDescription]) {
                                            loadAnalysisRequested(row, micRequestOptions[selectedDescription], false);
                                        }

                                        return;
                                    }
                                }
                            });
                        </script>
                                <table class="bordered mb-3" style="color:black; width:100%; border-collapse:collapse;">
                                    <colgroup>
                                        <col style="width: 35%;">
                                        <col style="width: 20%;">
                                        <col style="width: 45%;">
                                    </colgroup>

                                    <tr>
                                        <td>
                                            Sample Received by:<br>

                                            <select name="sample_received_by"
                                                id="sample_received_by"
                                                class="form-control meta-input mt-3"
                                                required>
                                                <option value="">-- Select Personnel --</option>

                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        data-role="{{ $user->role }}">
                                                        {{ $user->f_name }}
                                                        {{ $user->m_name ? $user->m_name . ' ' : '' }}
                                                        {{ $user->l_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <br><br>

                                            <small>(Customer Service Officer)</small>

                                            <input type="text"
                                                name="service_officer"
                                                id="service_officer"
                                                class="meta-input form-control mt-3"
                                                readonly>

                                            <br><br>
                                        </td>

                                        <script>
                                            $(document).ready(function () {

                                                const roleDescriptions = {
                                                    0: 'Laboratory Manager',
                                                    1: 'Quality Assurance Manager',
                                                    2: 'Purchase Supply Officer/ Laboratory Analyst - Fish Health Unit',
                                                    3: 'Laboratory Analyst - Microbiology Unit',
                                                    4: 'Laboratory Analyst - Fish Health Unit',
                                                    5: 'Customer Service Officer',
                                                    6: 'Utility',
                                                    7: 'Laboratory Analyst - Chemistry Unit'
                                                };

                                                $('#sample_received_by').on('change', function () {

                                                    let selectedOption = $(this).find('option:selected');

                                                    let role = selectedOption.data('role');

                                                    $('#service_officer').val(roleDescriptions[role] ?? '');
                                                });

                                            });
                                        </script>
                                        <td>
                                            Date Received<br>
                                            <input type="date" name="date_received" class="meta-input form-control mt-3">
                                        </td>
                                        <td>
                                           Payment 
                                            (<label>Partial</label> /
                                            <label>Full</label>) Amount

                                            <input type="text" name="payment" id="payment"
                                            class="meta-input form-control mt-3"
                                            placeholder="0.00">

                                            <script>
                                            document.getElementById('payment').addEventListener('blur', function () {
                                                let value = parseFloat(this.value);

                                                if (!isNaN(value)) {
                                                    this.value = value.toFixed(2);
                                                } else {
                                                    this.value = '';
                                                }
                                            });
                                            </script>
                                            Date payment received<br>
                                            <input type="date" name="date_payment" class="meta-input form-control mt-3">

                                            <br><br>

                                            OR No.:<br>
                                            <input type="text" name="or_no" class="meta-input form-control mt-3">
                                        </td>
                                    </tr>
                                </table>
                                 <div class="col-md-6 position-relative mt-4 mb-2">
                                    <label for="remarks" class="form-label">Remarks :</label>
                                    <input type="text" class="form-control meta-input" id="remarks" required name="remarks">
                                    <div class="invalid-tooltip">
                                        Please provide a remarks.
                                    </div>
                                    <div class="valid-tooltip">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="terms-box mt-4 mb-3">

                                    <div class="terms-header">
                                        <label class="terms-check mb-0">
                                            <input type="checkbox"
                                                name="terms_accepted"
                                                id="terms_accepted"
                                                value="1"
                                                required>

                                            <span>Terms and Conditions</span>
                                        </label>

                                   <button type="button"
                                        class="terms-arrow-btn"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#termsCollapse"
                                        aria-expanded="false"
                                        aria-controls="termsCollapse">
                                    <span id="termsArrow">▶</span>
                                </button>
                                    </div>
                                    <style>
                                        .terms-box {
                                            border: 1px solid #000;
                                            border-radius: 6px;
                                            background: #fff;
                                            color: #000;
                                        }

                                        .terms-header {
                                            display: flex;
                                            align-items: center;
                                            justify-content: space-between;
                                            padding: 12px 15px;
                                            background: #f8f9fa;
                                            border-bottom: 1px solid #ddd;
                                        }

                                        .terms-check {
                                            display: flex;
                                            align-items: center;
                                            gap: 10px;
                                            font-weight: 700;
                                            font-size: 15px;
                                            cursor: pointer;
                                        }

                                        .terms-check input {
                                            width: 18px;
                                            height: 18px;
                                            cursor: pointer;
                                        }

                                     .terms-arrow-btn {
                                            width: 36px;
                                            height: 36px;
                                            border: 1px solid #000;
                                            background: #ffffff;
                                            color: #1b0055;
                                            border-radius: 0;
                                            font-size: 18px;
                                            font-weight: bold;
                                            cursor: pointer;

                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        }

                                        #termsArrow {
                                            display: inline-block;
                                            line-height: 1;
                                        }

                                        .terms-arrow-btn i {
                                            transition: transform 0.25s ease;
                                        }

                                        .terms-arrow-btn i.rotate {
                                            transform: rotate(180deg);
                                        }

                                        .terms-content {
                                            padding: 15px 22px;
                                            font-size: 13px;
                                            line-height: 1.45;
                                            max-height: 420px;
                                            overflow-y: auto;
                                            text-align: justify;
                                        }

                                        .terms-content ol {
                                            padding-left: 18px;
                                            margin-bottom: 0;
                                        }

                                        .terms-content li {
                                            margin-bottom: 8px;
                                        }

                                        .terms-content .sub-list {
                                            margin-top: 6px;
                                        }
                                    </style>
                                  <script>
                                    document.addEventListener('DOMContentLoaded', function () {

                                        const termsCheckbox = document.getElementById('terms_accepted');
                                        const saveBtn = document.getElementById('saveRlaBtn');
                                        const rlaForm = document.getElementById('rlaForm');
                                        const termsCollapse = document.getElementById('termsCollapse');
                                        const termsArrow = document.getElementById('termsArrow');

                                        if (termsCheckbox && saveBtn) {
                                            saveBtn.disabled = !termsCheckbox.checked;

                                            termsCheckbox.addEventListener('change', function () {
                                                saveBtn.disabled = !this.checked;
                                            });
                                        }

                                        if (termsCollapse && termsArrow) {
                                            termsCollapse.addEventListener('show.bs.collapse', function () {
                                                termsArrow.innerHTML = '▼';
                                            });

                                            termsCollapse.addEventListener('hide.bs.collapse', function () {
                                                termsArrow.innerHTML = '▶';
                                            });
                                        }

                                        if (rlaForm && termsCheckbox) {
                                            rlaForm.addEventListener('submit', function (e) {
                                                if (!termsCheckbox.checked) {
                                                    e.preventDefault();

                                                    Swal.fire({
                                                        icon: 'warning',
                                                        title: 'Terms and Conditions Required',
                                                        text: 'Please check the Terms and Conditions before saving.'
                                                    });
                                                }
                                            });
                                        }

                                    });
                                    </script>
                                    <div class="collapse" id="termsCollapse">
                                        <div class="terms-content">

                                            <ol>
                                                <li>
                                                    Within the testing capability and resources of RFL12, the abovementioned request for test shall be conducted.
                                                </li>

                                                <li>
                                                    The tests shall be conducted in reference to the abovementioned Test Method.
                                                </li>

                                                <li>
                                                    The customer shall be informed immediately if any deviation from the contract occurs.
                                                </li>

                                                <li>
                                                    In the event that RFL12 does not have available capability and resources, RFL12 shall inform the customer
                                                    through telephone/writing and refer them to other laboratory that meets their requirements.
                                                </li>

                                                <li>
                                                    In the event that samples need to be subcontracted, RFL12 shall inform the customer through telephone/writing
                                                    that these samples shall be sent preferably at an ISO/IEC 17025 or equivalent QS accredited laboratory.
                                                    In this connection, please be informed that:

                                                    <ol class="sub-list">
                                                        <li>RFL12 shall act accordingly upon the written reply from the customer.</li>
                                                        <li>
                                                            If samples will be sent at an ISO/IEC 17025 accredited laboratory, RFL12 shall not be liable for
                                                            whatever damage the sample will sustain brought about by the destructive tests, if any, performed
                                                            on the sample.
                                                        </li>
                                                    </ol>
                                                </li>

                                                <li>
                                                    Change(s) in the request for testing work should be relayed to RFL12, in writing, addressed to the
                                                    Laboratory Manager, and/or fill up the ACTION SLIP. In connection with this, please be informed that:

                                                    <ol class="sub-list">
                                                        <li>
                                                            If request of halt of all/some tests is made, excess/undue payment, if any, shall be refunded
                                                            only by way of crediting this payment to future financial obligation of the payer to RFL12.
                                                        </li>
                                                        <li>
                                                            RFL12 shall consider request for additional test(s) as new testing work. Thus, another Request
                                                            for Laboratory Analyses shall be filed.
                                                        </li>
                                                        <li>
                                                            RFL12 shall consider request for changes to entry, Address, Consignee, Destination, Product Code,
                                                            in RLA or Report of Test.
                                                        </li>
                                                    </ol>
                                                </li>

                                                <li>
                                                    After the conduct of test, the tested samples shall be retained accordingly. RFL12 shall entertain
                                                    inquiries/claims regarding this particular testing work only within this period, 14 days after submission
                                                    of samples. After this period had elapsed, RFL12 implements its procedure for retrieval/disposal of tested samples.
                                                </li>

                                                <li>
                                                    To facilitate the retrieval of tested samples kindly note your intention below:

                                                    <div class="mt-2">
                                                        _____ The customer will retrieve the retained sample.<br>
                                                        _____ The customer will not retrieve the retained sample.
                                                    </div>
                                                </li>

                                                <li>
                                                    Re-test/Re-sampling shall only be conducted for samples that failed with the requirement(s) of the relevant
                                                    Test Method. In this connection please be guided that:

                                                    <ol class="sub-list">
                                                        <li>
                                                            Re-test shall be performed on the retained sample and only for the specific test requirement that
                                                            the sample failed.
                                                        </li>
                                                        <li>
                                                            Re-sampling shall be performed on the new sample drawn and submitted and for all the test
                                                            requirements. RFL12 shall consider this request as new testing work. Thus, another Request for
                                                            Laboratory Analyses shall be filed.
                                                        </li>
                                                    </ol>
                                                </li>

                                                <li>
                                                    The Official Test Report for the sample shall be released on ____________________, in accordance with
                                                    the Work Schedule. For industry samples, official Report of Test shall not be released without the full
                                                    payment of testing fee. RFL12 shall not send official Report of Test through fax or e-mail unless otherwise
                                                    authorized by the Laboratory Manager.
                                                </li>

                                                <li>
                                                    For samples that do not meet the requirements, the customer will sign the Sample Waiver Form, LF 06-07.
                                                </li>
                                            </ol>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                       <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Save</button>
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
                                            <div class="input-group">

                                                <input type="text"
                                                    name="edit_location"
                                                    id="edit_location"
                                                    class="meta-input form-control"
                                                    
                                                    readonly>

                                                <button type="button"
                                                        class="btn btn-primary"
                                                        onclick="openEditMapSwal()">

                                                    <i class="bi bi-geo-alt-fill"></i> See Maps

                                                </button>

                                            </div>
                                        </td>



                                    <script>

                                        let editLeafletMap;
                                        let editLeafletMarker;

                                        function openEditMapSwal()
                                        {
                                            let locationValue = $('#edit_location').val();

                                            console.log('EDIT LOCATION:', locationValue);

                                            let lat = 8.4852;
                                            let lng = 123.8043;

                                            if (locationValue && locationValue !== '')
                                            {
                                                try {

                                                    let coords = locationValue.split(',');

                                                    if (coords.length === 2)
                                                    {
                                                        lat = parseFloat(coords[0].trim());
                                                        lng = parseFloat(coords[1].trim());
                                                    }

                                                } catch (e) {

                                                    console.log('INVALID LOCATION:', e);

                                                }
                                            }

                                            Swal.fire({

                                                title: 'Edit Location Map',

                                                html: `
                                                    <div id="editLeafletMapContainer"
                                                        style="
                                                            width:100%;
                                                            height:650px;
                                                            border-radius:10px;
                                                        ">
                                                    </div>
                                                `,

                                                width: '90%',

                                                showCloseButton: true,

                                                showConfirmButton: false,

                                                didOpen: () => {

                                                    // REMOVE OLD MAP
                                                    if (editLeafletMap) {
                                                        editLeafletMap.remove();
                                                    }

                                                    // SATELLITE
                                                    let satellite = L.tileLayer(
                                                        'https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',
                                                        {
                                                            maxZoom: 20,
                                                            subdomains:['mt0','mt1','mt2','mt3']
                                                        }
                                                    );

                                                    // STREETS
                                                    let streets = L.tileLayer(
                                                        'https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',
                                                        {
                                                            maxZoom: 20,
                                                            subdomains:['mt0','mt1','mt2','mt3']
                                                        }
                                                    );

                                                    // CREATE MAP
                                                    editLeafletMap = L.map('editLeafletMapContainer', {

                                                        center: [lat, lng],

                                                        zoom: 18,

                                                        layers: [satellite]

                                                    });

                                                    // LAYER CONTROL
                                                    let baseLayers = {
                                                        "Satellite": satellite,
                                                        "Streets": streets
                                                    };

                                                    L.control.layers(baseLayers).addTo(editLeafletMap);

                                                    // GREEN ICON
                                                    const greenIcon = L.icon({

                                                        iconUrl:
                                                        'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',

                                                        shadowUrl:
                                                        'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',

                                                        iconSize: [45, 70],

                                                        iconAnchor: [22, 70],

                                                        popupAnchor: [1, -34],

                                                        shadowSize: [70, 70]

                                                    });

                                                    // MARKER
                                                    editLeafletMarker = L.marker([lat, lng], {

                                                        icon: greenIcon

                                                    }).addTo(editLeafletMap);

                                                    // FIX DISPLAY
                                                    setTimeout(() => {
                                                        editLeafletMap.invalidateSize();
                                                    }, 300);

                                                }

                                            });
                                        }
                                    </script>
                                        {{-- <td>
                                            <input type="text" name="edit_location" id="edit_location" class="meta-input form-control">
                                        </td> --}}
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
                          
                            <div class="table-responsive analysis-table-wrapper">
                                <table class="table table-bordered" id="editSampleTable" style="border: #000;">
                                    <thead>
                                        <tr style="text-align:center; font-weight:bold;">
                                            <td class="text-wrap" style="width: 220px;">Laboratory Code</td>
                                            <td class="text-wrap" style="width: 220px;">Sample Description</td>
                                            <td class="text-wrap" style="width: 220px;">Sample Code</td>
                                            <td class="text-wrap" style="width: 220px;">Lab Unit</td>
                                            <td class="text-wrap" style="width: 250px;">Analysis Description</td>
                                            <td class="text-wrap" style="width: 300px;">Analysis Requested</td>
                                            <td class="text-wrap" style="width: 220px;">Test Method</td>
                                            <td style="width: 150px;">Action</td>
                                        </tr>
                                    </thead>

                                    <tbody id="editSampleTableBody"></tbody>
                                </table>
                            </div>
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

                                        <select name="edit_sample_received_by"
                                            id="edit_sample_received_by"
                                            class="meta-input form-control mt-3">
                                            
                                            <option value="">-- Select Personnel --</option>

                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"
                                                    data-role="{{ $user->role }}">

                                                    {{ $user->f_name }}
                                                    {{ $user->m_name ? $user->m_name . ' ' : '' }}
                                                    {{ $user->l_name }}

                                                </option>
                                            @endforeach
                                        </select>

                                        <br><br>

                                        <small>(Customer Service Officer)</small>

                                        <input type="text"
                                            name="edit_service_officer"
                                            id="edit_service_officer"
                                            class="meta-input form-control mt-3"
                                            readonly>

                                        <br><br>
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
        {{-- <script>
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
        </script> --}}
                
<script>
    let editRowIndex = 0;
    let editLaboratoryCodePrefix = '';
    let editNextLaboratoryNumber = 1;

    /*
    |--------------------------------------------------------------------------
    | FIS OPTIONS
    |--------------------------------------------------------------------------
    */
    const editFisDescriptionOptions = [
        'PCR',
        'Parasitological Examination',
        'Gross Examination'
    ];

    const editFisRequestOptions = {
        'PCR': [
            'EMS/AHPND',
            'WSSV',
            'EHP',
            'TILV'
        ],

        'Parasitological Examination': [
            'Parasitological Examination'
        ],

        'Gross Examination': [
            'Gross Examination'
        ]
    };

    /*
    |--------------------------------------------------------------------------
    | CHEM OPTIONS
    |--------------------------------------------------------------------------
    */
    const editChemDescriptionOptions = [
        'HISTAMINE',
        'MOISTURE CONTENT',
        'WATER QUALITY'
    ];

    const editChemRequestOptions = {
        'HISTAMINE': [
            'HISTAMINE'
        ],

        'MOISTURE CONTENT': [
            'MOISTURE CONTENT'
        ],

        'WATER QUALITY': [
            'pH',
            'Alkalinity',
            'Nitrite Nitrogen',
            'Calcium Hardness',
            'Dissolved Oxygen'
        ]
    };

    /*
    |--------------------------------------------------------------------------
    | MIC OPTIONS
    |--------------------------------------------------------------------------
    */
    const editMicDescriptionOptions = [
        'FISH AND FISHERY PRODUCTS',
        'WATER POTABILITY',
        'WATER BACTERIOLOGY'
    ];

    const editMicRequestOptions = {
        'FISH AND FISHERY PRODUCTS': [
            'APC',
            'E COLI',
            'S. AUREUS',
            'SALMONELLA',
            'SHIGELLA'
        ],

        'WATER POTABILITY': [
            'HPC',
            'E COLI',
            'TOTAL COLIFORM',
            'FECAL COLIFORM',
            'ENTEROCOCCI'
        ],

        'WATER BACTERIOLOGY': [
            'TOTAL LUMINOUS BACTERIAL COUNT',
            'TOTAL VIBRIO COUNT',
            '% YELLOW COLONIES',
            '% GREEN COLONIES'
        ]
    };

    function editEscapeHtml(value) {
        if (value === null || value === undefined) {
            return '';
        }

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    function editNormalizeArray(value) {
        if (Array.isArray(value)) {
            return value;
        }

        if (value === null || value === undefined || value === '') {
            return [];
        }

        if (typeof value === 'string') {
            try {
                let parsed = JSON.parse(value);

                if (Array.isArray(parsed)) {
                    return parsed;
                }
            } catch (e) {}

            return value.split(',').map(item => item.trim()).filter(item => item !== '');
        }

        return [];
    }

    function editGetCurrentYearPrefix() {
        let year = new Date().getFullYear().toString().slice(-2);
        return 'RFL12-' + year + '-';
    }

    function editFormatLaboratoryCode(number) {
        let prefix = editLaboratoryCodePrefix || editGetCurrentYearPrefix();
        return prefix + String(number).padStart(3, '0');
    }

    function editGetHighestLabNumberInTable() {
        let highest = 0;

        $('#editSampleTableBody .edit_laboratory_code').each(function () {
            let code = $(this).val();

            if (!code) return;

            let match = code.match(/RFL12-\d{2}-(\d{3})$/);

            if (match) {
                let number = parseInt(match[1]);

                if (number > highest) {
                    highest = number;
                }
            }
        });

        return highest;
    }

    function editGenerateNextLabCode() {
        let currentHighest = editGetHighestLabNumberInTable();
        let globalNext = parseInt(editNextLaboratoryNumber || 1);
        let nextNumber = Math.max(currentHighest + 1, globalNext);

        return editFormatLaboratoryCode(nextNumber);
    }

    function editGetLatestLaboratoryCode() {
        $.ajax({
            url: "{{ route('get.latest.laboratory.code') }}",
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    editLaboratoryCodePrefix = response.prefix;
                    editNextLaboratoryNumber = parseInt(response.next_number);
                }
            }
        });
    }

    function editGenerateRow(row = {}, index = null) {
        let rowIndexValue = index !== null ? index : editRowIndex;

        return `
            <tr>
                <td>
                    <input type="text"
                           name="edit_laboratory_code[]"
                           class="meta-input form-control edit_laboratory_code"
                           style="width: 200px"
                           value="${editEscapeHtml(row.laboratory_code ?? '')}"
                           readonly>
                </td>

                <td>
                    <input type="text"
                           name="edit_sample_description[]"
                           class="meta-input form-control edit_sample_description"
                           style="width: 200px"
                           value="${editEscapeHtml(row.sample_description ?? '')}">
                </td>

                <td>
                    <input type="text"
                           name="edit_sample_code[]"
                           class="meta-input form-control edit_sample_code"
                           style="width: 200px"
                           value="${editEscapeHtml(row.sample_code ?? '')}">
                </td>

                <td>
                    <select name="edit_lab_unit[]"
                            class="meta-input form-control edit_lab_unit"
                            style="width: 200px">
                        <option value="">Select Lab Unit</option>
                        <option value="FIS">FIS</option>
                        <option value="CHEM">CHEM</option>
                        <option value="MIC">MIC</option>
                    </select>
                </td>

                <td>
                    <select name="edit_analysis_description[]"
                            class="meta-input form-control edit_analysis_description"
                            style="width: 220px"
                            disabled>
                        <option value="">N/A</option>
                    </select>
                </td>

                <td>
                    <select name="edit_analysis_requested[${rowIndexValue}][]"
                            class="form-control edit_analysis_requested"
                            multiple>
                    </select>

                    <div class="edit-custom-multi-wrapper">
                        <div class="edit-custom-multi-box">
                            <span class="edit-custom-multi-placeholder">Select Analysis</span>
                            <span class="edit-custom-multi-arrow">⌄</span>
                        </div>
                        <div class="edit-custom-multi-dropdown"></div>
                    </div>
                </td>

                <td>
                    <input type="text"
                           name="edit_test_method[]"
                           class="meta-input form-control edit_test_method"
                           style="width: 200px"
                           value="${editEscapeHtml(row.test_method ?? '')}">
                </td>

                <td>
                    <button type="button" class="btn btn-danger btn-sm editRemoveRow">
                        Remove
                    </button>
                </td>
            </tr>
        `;
    }

    function editCreateCustomMultiSelect(row) {
        const box = row.querySelector('.edit-custom-multi-box');

        if (!box) return;

        editRenderCustomMultiSelect(row);

        box.onclick = function (e) {
            e.stopPropagation();

            if (box.classList.contains('disabled')) {
                return;
            }

            document.querySelectorAll('.edit-custom-multi-wrapper').forEach(function (item) {
                if (item !== row.querySelector('.edit-custom-multi-wrapper')) {
                    item.classList.remove('open');
                }
            });

            row.querySelector('.edit-custom-multi-wrapper').classList.toggle('open');
        };
    }

    function editRenderCustomMultiSelect(row) {
        const select = row.querySelector('.edit_analysis_requested');
        const box = row.querySelector('.edit-custom-multi-box');
        const dropdown = row.querySelector('.edit-custom-multi-dropdown');

        if (!select || !box || !dropdown) return;

        const selectedValues = Array.from(select.selectedOptions).map(option => option.value);

        box.innerHTML = '';

        if (select.options.length === 0) {
            box.classList.add('disabled');
            box.innerHTML = `
                <span class="edit-custom-multi-placeholder">No options</span>
                <span class="edit-custom-multi-arrow">⌄</span>
            `;
        } else {
            box.classList.remove('disabled');

            if (selectedValues.length === 0) {
                box.innerHTML = `<span class="edit-custom-multi-placeholder">Select Analysis</span>`;
            } else {
                selectedValues.forEach(function (value) {
                    const tag = document.createElement('div');
                    tag.className = 'edit-custom-multi-tag';
                    tag.innerHTML = `
                        <span>${editEscapeHtml(value)}</span>
                        <div class="edit-custom-multi-remove" data-value="${editEscapeHtml(value)}">×</div>
                    `;
                    box.appendChild(tag);
                });
            }

            const arrow = document.createElement('span');
            arrow.className = 'edit-custom-multi-arrow';
            arrow.innerHTML = '⌄';
            box.appendChild(arrow);
        }

        dropdown.innerHTML = '';

        Array.from(select.options).forEach(function (option) {
            const item = document.createElement('div');
            item.className = 'edit-custom-multi-option';

            if (option.selected) {
                item.classList.add('selected');
            }

            item.dataset.value = option.value;
            item.innerText = option.text;

            item.addEventListener('click', function (e) {
                e.stopPropagation();

                option.selected = !option.selected;

                editRenderCustomMultiSelect(row);
            });

            dropdown.appendChild(item);
        });

        row.querySelectorAll('.edit-custom-multi-remove').forEach(function (removeBtn) {
            removeBtn.addEventListener('click', function (e) {
                e.stopPropagation();

                const value = this.dataset.value;

                Array.from(select.options).forEach(function (option) {
                    if (option.value === value) {
                        option.selected = false;
                    }
                });

                editRenderCustomMultiSelect(row);
            });
        });
    }

    function editClearAnalysisRequested(row) {
        const requestSelect = row.querySelector('.edit_analysis_requested');

        if (!requestSelect) return;

        requestSelect.innerHTML = '';
        editRenderCustomMultiSelect(row);
    }

    function editLoadAnalysisRequested(row, options, selectedValues = [], autoSelectSingle = false) {
        const requestSelect = row.querySelector('.edit_analysis_requested');

        if (!requestSelect) return;

        requestSelect.innerHTML = '';

        selectedValues = editNormalizeArray(selectedValues);

        options.forEach(function (item) {
            let option = document.createElement('option');
            option.value = item;
            option.text = item;

            if (selectedValues.includes(item)) {
                option.selected = true;
            }

            if (autoSelectSingle && options.length === 1 && selectedValues.length === 0) {
                option.selected = true;
            }

            requestSelect.appendChild(option);
        });

        editRenderCustomMultiSelect(row);
    }

    function editLoadAnalysisDescription(descriptionSelect, options, selectedDescription = '') {
        descriptionSelect.disabled = false;
        descriptionSelect.innerHTML = '<option value="">Select Analysis Description</option>';

        options.forEach(function (item) {
            let option = document.createElement('option');
            option.value = item;
            option.text = item;

            if (item === selectedDescription) {
                option.selected = true;
            }

            descriptionSelect.appendChild(option);
        });
    }

    function editApplyLabUnitToRow(row, selectedLab, selectedDescription = '', selectedRequests = []) {
        let labUnitSelect = row.querySelector('.edit_lab_unit');
        let descriptionSelect = row.querySelector('.edit_analysis_description');

        if (!labUnitSelect || !descriptionSelect) return;

        selectedRequests = editNormalizeArray(selectedRequests);

        labUnitSelect.value = selectedLab || '';

        descriptionSelect.innerHTML = '';
        descriptionSelect.disabled = true;
        descriptionSelect.innerHTML = '<option value="">N/A</option>';

        editClearAnalysisRequested(row);

        if (selectedLab === 'FIS') {
            editLoadAnalysisDescription(descriptionSelect, editFisDescriptionOptions, selectedDescription);

            if (selectedDescription && editFisRequestOptions[selectedDescription]) {
                let autoSelectSingle = selectedDescription === 'Parasitological Examination'
                    || selectedDescription === 'Gross Examination';

                editLoadAnalysisRequested(
                    row,
                    editFisRequestOptions[selectedDescription],
                    selectedRequests,
                    autoSelectSingle
                );
            }

            return;
        }

        if (selectedLab === 'CHEM') {
            editLoadAnalysisDescription(descriptionSelect, editChemDescriptionOptions, selectedDescription);

            if (selectedDescription && editChemRequestOptions[selectedDescription]) {
                let autoSelectSingle = selectedDescription === 'HISTAMINE'
                    || selectedDescription === 'MOISTURE CONTENT';

                editLoadAnalysisRequested(
                    row,
                    editChemRequestOptions[selectedDescription],
                    selectedRequests,
                    autoSelectSingle
                );
            }

            return;
        }

        if (selectedLab === 'MIC') {
            editLoadAnalysisDescription(descriptionSelect, editMicDescriptionOptions, selectedDescription);

            if (selectedDescription && editMicRequestOptions[selectedDescription]) {
                editLoadAnalysisRequested(
                    row,
                    editMicRequestOptions[selectedDescription],
                    selectedRequests,
                    false
                );
            }

            return;
        }

        editRenderCustomMultiSelect(row);
    }

    function editResetSampleTable() {
        editRowIndex = 0;

        $('#editSampleTableBody').html(editGenerateRow({}, 0));

        let firstRow = document.querySelector('#editSampleTableBody tr');

        editCreateCustomMultiSelect(firstRow);
        editApplyLabUnitToRow(firstRow, '', '', []);

        editRowIndex = 1;
    }

    function editLoadSampleRows(rows) {
        let tableBody = $('#editSampleTableBody');
        tableBody.html('');

        editRowIndex = 0;

        if (rows && rows.length > 0) {
            rows.forEach(function (row, index) {
                tableBody.append(editGenerateRow(row, index));

                let createdRow = document.querySelectorAll('#editSampleTableBody tr')[index];

                editCreateCustomMultiSelect(createdRow);

                editApplyLabUnitToRow(
                    createdRow,
                    row.lab_unit ?? '',
                    row.analysis_description ?? '',
                    row.analysis_requested ?? []
                );

                editRowIndex++;
            });
        } else {
            editResetSampleTable();
        }
    }

    $(document).ready(function () {
        editGetLatestLaboratoryCode();

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

        /*
        |--------------------------------------------------------------------------
        | EDIT ADD ROW — COPY LAST ROW VALUES
        |--------------------------------------------------------------------------
        */
        $('#editAddRow').on('click', function () {
            let rows = document.querySelectorAll('#editSampleTableBody tr');
            let sourceRow = rows[rows.length - 1];

            let sourceSampleDescription = sourceRow?.querySelector('.edit_sample_description')?.value ?? '';
            let sourceSampleCode = sourceRow?.querySelector('.edit_sample_code')?.value ?? '';
            let sourceLabUnit = sourceRow?.querySelector('.edit_lab_unit')?.value ?? '';
            let sourceAnalysisDescription = sourceRow?.querySelector('.edit_analysis_description')?.value ?? '';
            let sourceTestMethod = sourceRow?.querySelector('.edit_test_method')?.value ?? '';

            let sourceAnalysisRequested = [];

            let sourceRequestSelect = sourceRow?.querySelector('.edit_analysis_requested');

            if (sourceRequestSelect) {
                sourceAnalysisRequested = Array.from(sourceRequestSelect.selectedOptions).map(option => option.value);
            }

            let newLabCode = editGenerateNextLabCode();

            let newRowData = {
                laboratory_code: newLabCode,
                sample_description: sourceSampleDescription,
                sample_code: sourceSampleCode,
                lab_unit: sourceLabUnit,
                analysis_description: sourceAnalysisDescription,
                analysis_requested: sourceAnalysisRequested,
                test_method: sourceTestMethod
            };

            $('#editSampleTableBody').append(editGenerateRow(newRowData, editRowIndex));

            let createdRows = document.querySelectorAll('#editSampleTableBody tr');
            let newRow = createdRows[createdRows.length - 1];

            editCreateCustomMultiSelect(newRow);

            editApplyLabUnitToRow(
                newRow,
                sourceLabUnit,
                sourceAnalysisDescription,
                sourceAnalysisRequested
            );

            editRowIndex++;
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

        /*
        |--------------------------------------------------------------------------
        | CHANGE LAB UNIT
        |--------------------------------------------------------------------------
        */
        $(document).on('change', '.edit_lab_unit', function () {
            let changedRow = this.closest('tr');
            let selectedLab = this.value;

            editApplyLabUnitToRow(changedRow, selectedLab, '', []);
        });

        /*
        |--------------------------------------------------------------------------
        | CHANGE ANALYSIS DESCRIPTION
        |--------------------------------------------------------------------------
        */
        $(document).on('change', '.edit_analysis_description', function () {
            let row = this.closest('tr');
            let labUnit = row.querySelector('.edit_lab_unit').value;
            let selectedDescription = this.value;

            editClearAnalysisRequested(row);

            if (selectedDescription === '') {
                return;
            }

            if (labUnit === 'FIS') {
                if (editFisRequestOptions[selectedDescription]) {
                    let autoSelectSingle = selectedDescription === 'Parasitological Examination'
                        || selectedDescription === 'Gross Examination';

                    editLoadAnalysisRequested(
                        row,
                        editFisRequestOptions[selectedDescription],
                        [],
                        autoSelectSingle
                    );
                }

                return;
            }

            if (labUnit === 'CHEM') {
                if (editChemRequestOptions[selectedDescription]) {
                    let autoSelectSingle = selectedDescription === 'HISTAMINE'
                        || selectedDescription === 'MOISTURE CONTENT';

                    editLoadAnalysisRequested(
                        row,
                        editChemRequestOptions[selectedDescription],
                        [],
                        autoSelectSingle
                    );
                }

                return;
            }

            if (labUnit === 'MIC') {
                if (editMicRequestOptions[selectedDescription]) {
                    editLoadAnalysisRequested(
                        row,
                        editMicRequestOptions[selectedDescription],
                        [],
                        false
                    );
                }

                return;
            }
        });

        $(document).on('click', function (e) {
            if (!e.target.closest('.edit-custom-multi-wrapper')) {
                document.querySelectorAll('.edit-custom-multi-wrapper').forEach(function (wrapper) {
                    wrapper.classList.remove('open');
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
                       const roleDescriptions = {
                        0: 'Laboratory Manager',
                        1: 'Quality Assurance Manager',
                        2: 'Purchase Supply Officer/ Laboratory Analyst - Fish Health Unit',
                        3: 'Laboratory Analyst - Microbiology Unit',
                        4: 'Laboratory Analyst - Fish Health Unit',
                        5: 'Customer Service Officer',
                        6: 'Utility',
                        7: 'Laboratory Analyst - Chemistry Unit'
                    };
                    $('#edit_id').val(response.id ?? '');
                    $('#edit_company_name').val(response.edit_company_name ?? '');
                    $('#edit_RLA_no').val(response.edit_RLA_no ?? '');
                    $('#edit_location').val(response.edit_location ?? '');
                    $('#edit_contact_no').val(response.edit_contact_no ?? '');
                    $('#edit_source_sample').val(response.edit_source_sample ?? '');
                    $('#edit_date_collected').val(response.edit_date_collected ?? '');
                  
                    $('#edit_date_received').val(response.edit_date_received ?? '');
                    $('#edit_payment').val(response.edit_payment ?? '');
                    $('#edit_date_payment').val(response.edit_date_payment ?? '');
                    $('#edit_or_no').val(response.edit_or_no ?? '');
                    $('#edit_remarks').val(response.edit_remarks ?? '');
                        // SELECT DROPDOWN
                    $('#edit_sample_received_by').val(response.edit_sample_received_by).trigger('change');

                    // AUTO FILL ROLE
                    let selectedRole = $('#edit_sample_received_by option:selected').data('role');

                    $('#edit_service_officer').val(
                        roleDescriptions[selectedRole] ?? ''
                    );

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
        $('#edit_sample_received_by').on('change', function () {

            const roleDescriptions = {
                0: 'Laboratory Manager',
                1: 'Quality Assurance Manager',
                2: 'Purchase Supply Officer/ Laboratory Analyst - Fish Health Unit',
                3: 'Laboratory Analyst - Microbiology Unit',
                4: 'Laboratory Analyst - Fish Health Unit',
                5: 'Customer Service Officer',
                6: 'Utility',
                7: 'Laboratory Analyst - Chemistry Unit'
            };

            let selectedRole = $(this).find('option:selected').data('role');

            $('#edit_service_officer').val(
                roleDescriptions[selectedRole] ?? ''
            );
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