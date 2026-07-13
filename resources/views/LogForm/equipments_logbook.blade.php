@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

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
        font-size: 12px;
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
 <a class="btn btn-sm btn-icon btn-secondary" style="margin-left:8mm" data-bs-toggle="tooltip" data-bs-placement="top" href="/equipments_usage" aria-label="return" title="return">
    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 12C2 6.48 6.49 2 12 2L12.2798 2.00384C17.6706 2.15216 22 6.57356 22 12C22 17.51 17.52 22 12 22C6.49 22 2 17.51 2 12ZM13.98 16C14.27 15.7 14.27 15.23 13.97 14.94L11.02 12L13.97 9.06C14.27 8.77 14.27 8.29 13.98 8C13.68 7.7 13.21 7.7 12.92 8L9.43 11.47C9.29 11.61 9.21 11.8 9.21 12C9.21 12.2 9.29 12.39 9.43 12.53L12.92 16C13.06 16.15 13.25 16.22 13.44 16.22C13.64 16.22 13.83 16.15 13.98 16Z" fill="currentColor"></path>                            </svg>                        
</a>    
<div class="container-fluid">
    <div class="page-wrap">
        <form method="POST" action="{{ route('equipments.store')}}">
            @csrf
            <input type="hidden" name="equipment_id" value="{{ $id }}">

            <div class="form-sheet">

                <!-- TOP HEADER -->
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
                            <div>Page 1 of 1</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Document Code:</div>
                            <div><strong>LF-03-05</strong></div>
                        </td>
                        <td colspan="3" class="section-title">
                            EQUIPMENT USAGE AND MAINTENANCE LOGBOOK
                        </td>
                    </tr>
                </table>

                <!-- EQUIPMENT DETAILS -->
                <table class="bordered mb-3" style="color:black">
                    <colgroup>
                        <col style="width: 35%;">
                        <col style="width: 35%;">
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                    </colgroup>
                    <tr>
                        <td>
                            <div class="meta-row">
                                <span class="meta-label">Equipment:</span>
                                <input type="text" name="equipment_name" class="meta-input" value="{{ $equipment->equipment ?? '' }}">
                            </div>
                            <div class="meta-row">
                                <span class="meta-label">Brand/Model:</span>
                                <input type="text" name="brand_model" class="meta-input" value="{{ $equipment->model ?? '' }}">
                            </div>
                        </td>
                        <td>
                            <div class="meta-row">
                                <span class="meta-label">Equipment No.:</span>
                                <input type="text" name="equipment_no" class="meta-input" value="{{ $equipment->equipment_no ?? '' }}">
                            </div>
                            <div class="meta-row">
                                <span class="meta-label">Location:</span>
                                <input type="text" name="location" class="meta-input" value="{{ $equipment->location ?? '' }}">
                            </div>
                        </td>
                       @php
                            $months = [
                                '01'=>'January','02'=>'February','03'=>'March','04'=>'April',
                                '05'=>'May','06'=>'June','07'=>'July','08'=>'August',
                                '09'=>'September','10'=>'October','11'=>'November','12'=>'December'
                            ];
                        @endphp

                        <td>
                            <div class="meta-row">
                                <span class="meta-label">Month:</span>
                                <input type="text" name="month" class="meta-input" 
                                    value="{{ $equipment->month ? $months[$equipment->month] : '' }}">
                            </div>
                        </td>

                        <td>
                            <div class="meta-row">
                                <span class="meta-label">Year:</span>
                                <input type="text" name="year" class="meta-input" value="{{ $equipment->year ?? '' }}">
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- MAIN TABLE -->
                <div class="table-responsive" style="color:black">
                    <table class="bordered table-main" id="logTable" >
                        <colgroup>
                            <col style="width: 10%;">
                            <col style="width: 8%;">
                            <col style="width: 8%;">
                            <col style="width: 7%;">
                            <col style="width: 7%;">
                            <col style="width: 12%;">
                            <col style="width: 8%;">
                            <col style="width: 8%;">
                            <col style="width: 8%;">
                            <col style="width: 10%;">
                            <col style="width: 8%;">
                            <col class="action-col screen-only">
                        </colgroup>
                        <thead>
                            <tr>
                                <th colspan="5" class="text-wrap">DAILY ACTIVITIES</th>
                                <th rowspan="2" class="text-wrap">Preventive Maintenance</th>
                                <th colspan="3">Usage</th>
                                <th rowspan="2" class="text-wrap">Laboratory Code</th>
                                <th rowspan="2">Remarks</th>
                                <th rowspan="2" class="text-wrap no-print-export">Action</th>
                            </tr>
                            <tr>
                                <th class="text-wrap">Date</th>
                                <th class="text-wrap">Clean the equipment</th>
                                <th class="text-wrap">Check the power supply</th>
                                <th class="text-wrap">Switch ON the Equipment</th>
                                <th class="text-wrap">Shut Down the Equipment</th>
                                <th class="text-wrap">Name of Analyst</th>
                                <th class="text-wrap">Analysis</th>
                                <th FF>RLA No.</th>
                             
                            </tr>
                        </thead>

                        <tbody>
                           @php $rowCount = max($logs->count(), 15); @endphp

                            @for($i = 0; $i < $rowCount; $i++)
                                @php $log = $logs->get($i); @endphp
                                <tr>
                                    <td>
                                        <input type="hidden" name="log_id[]" value="{{ $log->id ?? '' }}" class="no-print-export">
                                        <input type="date" name="date[]" value="{{ $log->date ?? '' }}" class="form-control-plain">
                                    </td>
                                    <td><input type="text" name="clean_equipment[]" value="{{ $log->clean_equipment ?? '' }}" class="form-control-plain"></td>
                                    <td><input type="text" name="check_powersupply[]" value="{{ $log->check_powersupply ?? '' }}" class="form-control-plain"></td>
                                    <td><input type="text" name="switchon_equipment[]" value="{{ $log->switchon_equipment ?? '' }}" class="form-control-plain"></td>
                                    <td><input type="text" name="shutdown_equipment[]" value="{{ $log->shutdown_equipment ?? '' }}" class="form-control-plain"></td>
                                    <td><input type="text" name="preventive_maintenance[]" value="{{ $log->preventive_maintenance ?? '' }}" class="form-control-plain"></td>
                                    <td><input type="text" name="name_analyst[]" value="{{ $log->name_analyst ?? '' }}" class="form-control-plain"></td>
                                    <td>
                                        <input type="text"
                                            name="analysis[]"
                                            value="{{ $log && $log->analysis ? collect(json_decode($log->analysis, true))->flatten()->implode(', ') : '' }}"
                                            class="form-control-plain">
                                    </td>

                                    <td>
                                        <input type="text"
                                            name="RLA_no[]"
                                            value="{{ $log->RLA_no ?? '' }}"
                                            class="form-control-plain">
                                    </td>

                                    <td>
                                        <input type="text"
                                            name="laboratory_code[]"
                                            value="{{ $log && $log->laboratory_code ? collect(json_decode($log->laboratory_code, true))->flatten()->implode(', ') : '' }}"
                                            class="form-control-plain">
                                    </td>
                                    <td><input type="text" name="remarks[]" value="{{ $log->remarks ?? '' }}" class="form-control-plain"></td>
                                    <td class="text-center align-middle no-print-export" >
                                       <a class="btn btn-sm btn-icon btn-danger removeRow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete">
                                        <span class="btn-inner removeRow">
                                            <svg class="icon-20 removeRow" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                <!-- BUTTONS -->
                <div class="btn-row screen-only">
                    <button type="button" id="addRow" class="btn btn-primary btn-sm">+ Add Row</button>
                    <button type="submit" class="btn btn-success btn-sm">                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 22C6.48 22 2 17.51 2 12C2 6.48 6.48 2 12 2C17.51 2 22 6.48 22 12C22 17.51 17.51 22 12 22ZM16 10.02C15.7 9.73 15.23 9.73 14.94 10.03L12 12.98L9.06 10.03C8.77 9.73 8.29 9.73 8 10.02C7.7 10.32 7.7 10.79 8 11.08L11.47 14.57C11.61 14.71 11.8 14.79 12 14.79C12.2 14.79 12.39 14.71 12.53 14.57L16 11.08C16.15 10.94 16.22 10.75 16.22 10.56C16.22 10.36 16.15 10.17 16 10.02Z" fill="currentColor"></path>                            </svg>                        Save</button>
                    <button type="button" id="printPdf" class="btn btn-danger btn-sm">                                                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                            <path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path>                            </svg>                                               Print PDF</button>
                </div>

                <!-- CHECKED BY -->
                <div class="checked-by">
                    <div class="checked-label">Checked by:</div>
                    <div class="signature-line"></div>
                </div>

            </div>
        </form>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('printPdf');
        if (!btn) return;

        btn.addEventListener('click', async function () {
            const source = document.querySelector('.form-sheet');
            if (!source) {
                alert('Form sheet not found.');
                return;
            }

            const clone = source.cloneNode(true);

            clone.querySelectorAll('.screen-only, .no-print-export').forEach(el => el.remove());

            clone.querySelectorAll('input, textarea, select').forEach(field => {
                const span = document.createElement('span');
                let value = '';

                if (field.tagName === 'SELECT') {
                    value = field.options[field.selectedIndex]?.text || '';
                } else if (field.type === 'checkbox') {
                    value = field.checked ? '✓' : '';
                } else if (field.type === 'radio') {
                    value = field.checked ? field.value : '';
                } else {
                    value = field.value || '';
                }

                span.textContent = value;
                span.style.display = 'block';
                span.style.width = '100%';
                span.style.minHeight = '14px';
                span.style.padding = '1px 2px';
                span.style.lineHeight = '1.1';
                span.style.verticalAlign = 'top';
                span.style.whiteSpace = 'normal';
                span.style.wordBreak = 'break-word';
                span.style.overflowWrap = 'break-word';

                field.parentNode.replaceChild(span, field);
            });

            clone.style.width = '100%';
            clone.style.maxWidth = '100%';
            clone.style.margin = '0';
            clone.style.padding = '0';
            clone.style.background = '#fff';
            clone.style.color = '#000';
            clone.style.fontSize = '11px';
            clone.style.lineHeight = '1.1';
            clone.style.boxSizing = 'border-box';
            clone.style.border = '#000';

            clone.querySelectorAll('*').forEach(el => {
                el.style.boxSizing = 'border-box';
            });

            clone.querySelectorAll('table').forEach(t => {
                t.style.width = '100%';
                t.style.borderCollapse = 'collapse';
                t.style.tableLayout = 'fixed';
                t.style.margin = '0';
                t.style.fontSize = '10px';
              
            });

            clone.querySelectorAll('th, td').forEach(cell => {
                cell.style.padding = '2px 2px';
                cell.style.wordBreak = 'break-word';
                cell.style.overflowWrap = 'break-word';
                cell.style.verticalAlign = 'middle';
                cell.style.lineHeight = '1.1';
            });

            clone.querySelectorAll('.table-main td').forEach(td => {
                td.style.height = 'auto';
                td.style.minHeight = '21px';
                td.style.overflow = 'visible';
            });

            const checkedBy = clone.querySelector('.checked-by');
            if (checkedBy) {
                checkedBy.style.marginTop = '19px';
                checkedBy.style.width = '248px';
            }

            const wrapper = document.createElement('div');
            wrapper.style.position = 'fixed';
            wrapper.style.top = '0';
            wrapper.style.left = '0';
            wrapper.style.width = '100%';
            wrapper.style.background = '#fff';
            wrapper.style.padding = '0';
            wrapper.style.margin = '0';
            wrapper.style.zIndex = '-1';
            wrapper.style.opacity = '0';
            
            wrapper.appendChild(clone);
            document.body.appendChild(wrapper);

            try {
                await html2pdf().set({
                    margin: [5, 6, 5, 6],
                    filename: 'EQUIPMENT USAGE AND MAINTENANCE LOGBOOK.pdf',
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: {
                        scale: 2,
                        useCORS: true,
                        backgroundColor: '#ffffff',
                        scrollY: 0
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'landscape'
                    },
                    pagebreak: {
                        mode: ['css', 'legacy']
                    }
                }).from(clone).save();
            } catch (err) {
                console.error(err);
                alert('Failed to generate PDF.');
            } finally {
                wrapper.remove();
            }
        });
    });
</script>

</div>


<script>
document.getElementById('addRow').addEventListener('click', function () {
    let row = `
        <tr>
            <td>
                <input type="hidden" name="log_id[]" value="" class="no-print-export">
                <input type="date" name="date[]" class="form-control-plain">
            </td>
            <td><input type="text" name="clean_equipment[]" class="form-control-plain"></td>
            <td><input type="text" name="check_powersupply[]" class="form-control-plain"></td>
            <td><input type="text" name="switchon_equipment[]" class="form-control-plain"></td>
            <td><input type="text" name="shutdown_equipment[]" class="form-control-plain"></td>
            <td><input type="text" name="preventive_maintenance[]" class="form-control-plain"></td>
            <td><input type="text" name="name_analyst[]" class="form-control-plain"></td>
            <td><input type="text" name="analysis[]" class="form-control-plain"></td>
            <td><input type="text" name="RLA_no[]" class="form-control-plain"></td>
            <td><input type="text" name="laboratory_code[]" class="form-control-plain"></td>
            <td><input type="text" name="remarks[]" class="form-control-plain"></td>
            <td class="text-center align-middle">
                  <a class="btn btn-sm btn-icon btn-danger removeRow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete">
                    <span class="btn-inner removeRow">
                        <svg class="icon-20 removeRow" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                            <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    </a>
            </td>
        </tr>
    `;

    document.querySelector('#logTable tbody').insertAdjacentHTML('beforeend', row);
});

document.addEventListener('click', function(e){
    if(e.target.classList.contains('removeRow')){
        e.target.closest('tr').remove();
    }
});
</script>
@endsection