@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>

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
                            <h4 class="card-title"><span class="badge bg-warning p-3">DOCUMENT CODE : LF 06-06 - SAMPLE RECEIVING AND RELEASING LOGBOOK</span></h4>
                         
                        </div>
                        <a class="btn btn-danger btn-icon"
                                href="#"
                                id="downloadPdfBtn"
                                data-bs-toggle="tooltip"
                                title="Download PDF">
                                <span class="btn-inner">
                                    <svg class="icon-25" width="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                            </a>
                        </div>
                        <div class="card-body ">
                            <input type="text" id="searchInput" style="width: 50%"  placeholder="Search Document Code or Title" class="form-control mb-3">
                            

                            <div class="table-responsive">
                               <style>
                                        .table-responsive {
                                            overflow-x: auto;
                                        }

                                        .custom-table {
                                            width: 100%;
                                            min-width: 1400px;
                                        }

                                        .custom-table th,
                                        .custom-table td {
                                            vertical-align: top;
                                            white-space: normal !important;
                                            word-break: break-word;
                                            font-size: 14px;
                                            padding: 12px 10px;
                                        }

                                    .multi-line {
                                            white-space: normal !important;
                                            word-break: break-word;
                                            line-height: 1.8;
                                        }

                                        .table-responsive {
                                            overflow-x: auto;
                                        }

                                        #documentsTable {
                                            min-width: 1400px;
                                        }

                                        #documentsTable th,
                                        #documentsTable td {
                                            vertical-align: top;
                                            font-size: 14px;
                                            padding: 12px;
                                        }

                                        .nowrap {
                                            white-space: nowrap !important;
                                        }
                                    </style>

                                    <div class="table-responsive">

                                        <table id="documentsTable"
                                            class="table table-striped custom-table"
                                            role="grid"
                                            data-bs-toggle="data-table">

                                            <thead>
                                                <tr class="bg-info text-white" >
                                                    <th class="nowrap">NO.</th>
                                                    <th class="nowrap">RLA NO.</th>
                                                    <th>Customer</th>
                                                    <th>Sample Description</th>
                                                    <th>Sample Code</th>
                                                    <th class="text-wrap" style="width: 220px">Laboratory Code</th>
                                                    <th>Received By</th>
                                                    <th>Date Received</th>
                                                    <th class="text-wrap" style="width: 220px">Report Test No.</th>
                                                    <th>Official Receipt No.</th>
                                                    <th>Date Released</th>
                                                    <th>Released To</th>
                                                </tr>
                                            </thead>

                                        <tbody>
                                    @foreach ($rla as $index => $r)
                                        <tr>

                                            <td>{{ $index + 1 }}</td>

                                            <td>{{ $r->RLA_no ?? '' }}</td>

                                            <td>{{ $r->company_name ?? '' }}</td>

                                            {{-- SAMPLE DESCRIPTION --}}
                                            <td class="multi-line">
                                                @if (!empty($r->sample_description) && count($r->sample_description) > 0)
                                                {{ $r->sample_description[0] ?? '' }}
                                                @endif
                                            </td>

                                            {{-- SAMPLE CODE --}}
                                            <td class="multi-line">
                                                @if (!empty($r->sample_code) && count($r->sample_code) > 0)
                                                    @foreach ($r->sample_code as $code)
                                                        {{ $code }} <br>
                                                    @endforeach
                                                @endif
                                            </td>

                                            {{-- LABORATORY CODE --}}
                                            <td class="multi-line">
                                                @if (!empty($r->laboratory_code) && count($r->laboratory_code) > 0)
                                                    @foreach ($r->laboratory_code as $code)
                                                        {{ $code }} <br>
                                                    @endforeach
                                                @endif
                                            </td>

                                            <td>{{ $r->sample_received_by ?? '' }}</td>

                                            <td class="nowrap">
                                                {{ $r->date_received 
                                                    ? \Carbon\Carbon::parse($r->date_received)->format('m/d/Y') 
                                                    : '' }}
                                            </td>

                                        <td class="multi-line">
                                            @php
                                                $reportTestNos = is_array($r->report_test_no)
                                                    ? $r->report_test_no
                                                    : json_decode($r->report_test_no ?? '[]', true);

                                                if (!is_array($reportTestNos)) {
                                                    $reportTestNos = [];
                                                }
                                            @endphp

                                            @foreach ($reportTestNos as $reportNo)
                                                {{ $reportNo }} <br>
                                            @endforeach
                                        </td>

                                            <td>{{ $r->or_no ?? '' }}</td>

                                            <td class="nowrap">
                                                {{ $r->date_approved_release
                                                    ? \Carbon\Carbon::parse($r->date_approved_release)->format('m/d/Y')
                                                    : '' }}
                                            </td>

                                            <td>{{ $r->sample_received_by ?? '' }}</td>

                                        

                                        </tr>
                                    @endforeach
                                    </tbody>
                                        </table>

                                    </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-end">
                                    {{ $rla->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
 
    </div>
<div class="modal fade" id="signatureModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Draw your Signature</h5>
            </div>

            <div class="modal-body">

                <canvas id="signature-pad"
                        style="border:1px solid #ccc;width:100%;height:200px;">
                </canvas>

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary" id="clearSignature">
                    Clear
                </button>

                <button class="btn btn-primary" id="saveSignature">
                    Download PDF
                </button>

            </div>

        </div>
    </div>
</div>
    <script>
        $(document).ready(function () {

    let signaturePad;

    $('#downloadPdfBtn').on('click', function (e) {
        e.preventDefault();

        $('#signatureModal').modal('show');
    });

    $('#signatureModal').on('shown.bs.modal', function () {

        const canvas = document.getElementById('signature-pad');

        canvas.width = canvas.offsetWidth;
        canvas.height = 200;

        signaturePad = new SignaturePad(canvas);

    });

    $('#clearSignature').on('click', function () {
        signaturePad.clear();
    });

    $('#saveSignature').on('click', function () {

        if (signaturePad.isEmpty()) {
            alert('Please provide your signature.');
            return;
        }

        let signature = signaturePad.toDataURL();

        let form = $('<form>', {
            method: 'GET',
            action: "{{ route('releasing.download.pdf') }}"
        });

        form.append($('<input>', {
            type: 'hidden',
            name: '_token',
            value: "{{ csrf_token() }}"
        }));

        form.append($('<input>', {
            type: 'hidden',
            name: 'signature',
            value: signature
        }));

        $('body').append(form);

        form.submit();
    });

});
    </script>

@endsection