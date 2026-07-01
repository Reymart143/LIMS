@extends('layouts.app')
@section('content')
<style>
    :root{
        --teal:#007a78;
        --teal-dark:#006663;
        --teal-line:#168b8b;
        --soft:#f8ffff;
        --text:#0f1720;
    }

    .choices,
    .choices__inner,
    .choices__input{width:100%!important;box-sizing:border-box;}

    .content-inner{color:var(--text);}
    .form-sheet{
        width:100%;
        max-width:1750px;
        margin:0 auto;
        padding:14px;
        background:#fff;
        border:3px solid var(--teal);
        border-radius:10px;
        box-shadow:0 2px 12px rgba(0,0,0,.08);
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    .table-responsive-fix{
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    *,*::before,*::after{box-sizing:border-box;}

    table{width:100%;border-collapse:collapse;table-layout:fixed;}
    .bordered td,.bordered th{border:1px solid var(--teal-line)!important;padding:5px 8px;vertical-align:middle;}
    .header-title{line-height:1.15;font-size:13px;color:var(--text);}
    .header-title .big{font-weight:800;}
    .logo-cell{width:110px;text-align:center;vertical-align:middle;}
    .logo-cell img{max-width:78px;height:auto;}
    .section-title{font-weight:800;text-align:center;font-size:13px;}

    .micro-table{
        width:100%;
        min-width:1180px;
        border:2px solid var(--teal-line);
        font-family:Arial, Helvetica, sans-serif;
        font-size:clamp(12px, .85vw, 16px);
        color:var(--text);
    }
    .micro-table td,.micro-table th{
        border:1px solid var(--teal-line);
        padding:4px 8px;
        vertical-align:middle;
        background:#fff;
        overflow:hidden;
        overflow-wrap:anywhere;
    }
    .micro-table input{
        width:100%;
        min-width:0;
        border:0;
        border-bottom:1px solid #777;
        outline:0;
        background:transparent;
        font-size:inherit;
        padding:1px 2px;
    }
    .micro-table input[type="datetime-local"]{font-size:18px;}

    .teal-head{
        background:linear-gradient(180deg,var(--teal),var(--teal-dark))!important;
        color:#fff;
        font-weight:800;
        text-align:center;
        letter-spacing:.3px;
        text-shadow:0 1px 2px rgba(0,0,0,.35);
    }
    .light-cell{background:linear-gradient(90deg,#faffff,#eefafa)!important;}
    .top-info{font-size:clamp(15px,1.25vw,22px);font-family:Georgia,'Times New Roman',serif;font-weight:800;padding:10px 14px!important;}
    .top-field{display:flex;align-items:center;gap:6px;white-space:nowrap;}
    .top-field input{flex:1 1 130px;min-width:130px;}
    .test-name{font-weight:800;font-size:clamp(13px,1vw,18px);background:linear-gradient(90deg,#fbffff,#eefafa)!important;}
    .italic{font-style:italic;}
    .center{text-align:center;}.left{text-align:left;}.right{text-align:right;}.bold{font-weight:800;}
    .small{font-size:12px;font-weight:700;}.tiny{font-size:10px;font-weight:700;}
    .dilution{font-size:clamp(15px,1.25vw,21px);font-weight:900;text-align:center;}
    .sub-dilution{font-size:13px;text-align:center;font-weight:800;}
    .result-cell{font-size:clamp(13px,1vw,18px);font-weight:800;text-align:right;background:linear-gradient(90deg,#fbffff,#eefafa)!important;white-space:nowrap;}
    .result-cell input{width:62%;display:inline-block;margin-right:6px;}
    .separator td{height:10px!important;padding:0!important;background:#d5c9df!important;border-top:1px solid #222!important;border-bottom:1px solid #222!important;}
    .blank{height:36px;}
    .dash-input{display:inline-block;width:72%;border-bottom:1px solid #333;height:16px;vertical-align:middle;}
    .no-pad{padding:0!important;}

    @media print{
        .card-header,.text-end{display:none!important;}
        .form-sheet{border:2px solid var(--teal);box-shadow:none;padding:5px;}
        .micro-table{min-width:0;font-size:12px;}
        .top-info{font-size:16px;}
        .test-name,.result-cell{font-size:13px;}
        .dilution{font-size:15px;}
    }
    .qc-header {
    background: #0f766e;
    color: #fff;
    font-size: 16px;
    padding: 6px;
}

.qc-subheader {
    background: #d1d5db;
}

.micro-table td,
.micro-table th {
    border: 1px solid #0f766e;
    padding: 6px;
    vertical-align: top;
}

.micro-table {
    width: 100%;
    border-collapse: collapse;
}

.center {
    text-align: center;
}

.bold {
    font-weight: bold;
}

.italic {
    font-style: italic;
}
.formula-box {
    width: 100%;
    min-height: 80px;
    border: 1px solid #0f766e;
    margin-top: 5px;
    padding: 6px;
    resize: vertical;
    font-size: 13px;
    outline: none;
}

.formula-box:focus {
    border-color: #065f46;
}
</style>

<div class="conatiner-fluid content-inner mt-n5 py-0">

    <div class="card">
        <div class="card-header d-flex justify-content-between">
        <a class="btn btn-sm btn-icon btn-secondary" style="margin-left:8mm" data-bs-toggle="tooltip" data-bs-placement="top" href="/analyst_worksheet" aria-label="return" title="return">
            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 12C2 6.48 6.49 2 12 2L12.2798 2.00384C17.6706 2.15216 22 6.57356 22 12C22 17.51 17.52 22 12 22C6.49 22 2 17.51 2 12ZM13.98 16C14.27 15.7 14.27 15.23 13.97 14.94L11.02 12L13.97 9.06C14.27 8.77 14.27 8.29 13.98 8C13.68 7.7 13.21 7.7 12.92 8L9.43 11.47C9.29 11.61 9.21 11.8 9.21 12C9.21 12.2 9.29 12.39 9.43 12.53L12.92 16C13.06 16.15 13.25 16.22 13.44 16.22C13.64 16.22 13.83 16.15 13.98 16Z" fill="currentColor"></path>                            </svg>                        
        </a>   
        </div>
        <div class="card-body">
            <div class="form-sheet">
                <table class="bordered mb-2">
                    <colgroup><col style="width:110px;"><col></colgroup>
                    <tr>
                        <td class="logo-cell"><img src="../assets/images/bfarlogo.png" alt="Logo" onerror="this.style.display='none'"></td>
                        <td class="header-title">
                            <div>Republic of the Philippines</div>
                            <div>Department of Agriculture</div>
                            <div class="big">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
                            <div class="big">REGIONAL FISHERIES LABORATORY XII</div>
                            <div>J. Catolico St., Lagao, General Santos City</div>
                        </td>
                    </tr>
                </table>

                <table class="bordered mb-3">
                    <colgroup><col style="width:23%;"><col style="width:26%;"><col style="width:28%;"><col style="width:23%;"></colgroup>
                    <tr>
                        <td><div>Document Type</div><div><strong>Laboratory Form</strong></div></td>
                        <td><div>Revision No:</div><div>0</div></td>
                        <td><div>Date Adopted:</div><div>13 Aug 2019</div></td>
                        <td><div>Page No:</div><div>Page 1 of 2</div></td>
                    </tr>
                    <tr>
                        <td><div>Document Code:</div><div><strong>LF-W01-MIC-03</strong></div></td>
                        <td colspan="3" class="section-title">ANALYST WORKSHEET FOR BACTERIOLOGICAL EXAMINATION OF 
                        FISH AND FISHERY PRODUCTS
                        </td>
                    </tr>
                </table>

               <form method="POST" action="{{ route('analysis_worksheet.store', $id) }}">
    @csrf

    <div class="table-responsive-fix">

        <table class="micro-table">
            <colgroup>
                <col style="width:25%;">
                <col span="12" style="width:6.25%;">
                <col style="width:13%;">
            </colgroup>

            <tr>
                <td colspan="1" class="top-info light-cell">
                    RLA No.:
                    <input type="text" id="RLA_no" name="RLA_no"
                        value="{{ old('RLA_no', $worksheet->RLA_no ?? $rla->RLA_no ?? '') }}" readonly>
                </td>

                <td colspan="4" class="top-info light-cell">
                    Lab Code:
                    <input type="text" id="laboratory_code" name="laboratory_code"
                        value="{{ old('laboratory_code', $worksheet->laboratory_code ?? $firstLabCode ?? '') }}" readonly>
                </td>

                <td colspan="5" class="top-info light-cell">
                    <div>Date Started:</div>
                    <input type="date" id="date_started" name="date_started"
                        value="{{ old('date_started', $worksheet->date_started ?? '') }}">

                    <div>Time Started:</div>
                    <input type="time" id="time_started" name="time_started"
                        value="{{ old('time_started', $worksheet->time_started ?? '') }}">
                </td>

                <td colspan="5" class="top-info light-cell">
                    <div>Date Finished:</div>
                    <input type="date" id="date_finish" name="date_finish"
                        value="{{ old('date_finish', $worksheet->date_finish ?? '') }}">

                    <div>Time Finished:</div>
                    <input type="time" id="time_finish" name="time_finish"
                        value="{{ old('time_finish', $worksheet->time_finish ?? '') }}">
                </td>
            </tr>

            <tr>
                <td rowspan="2" class="teal-head">TESTS</td>
                <td colspan="12" class="teal-head" style="font-size:22px;">DILUTIONS</td>
                <td rowspan="2" class="teal-head">RESULTS</td>
            </tr>

            <tr>
                <td colspan="2" class="teal-head dilution">10<sup>-1</sup></td>
                <td colspan="2" class="teal-head dilution">10<sup>-2</sup></td>
                <td colspan="2" class="teal-head dilution">10<sup>-3</sup></td>
                <td colspan="2" class="teal-head dilution">10<sup>-4</sup></td>
                <td colspan="2" class="teal-head dilution">10<sup>-5</sup></td>
                <td colspan="2" class="teal-head dilution">10<sup>-6</sup></td>
            </tr>

            <tr>
                <td class="test-name">Aerobic Plate Count</td>
                @for($i = 1; $i <= 6; $i++)
                    <td class="sub-dilution">R1</td>
                    <td class="sub-dilution">R2</td>
                @endfor
                <td class="result-cell">
                    <input type="text" id="aerobic_plate_count_result" name="aerobic_plate_count_result"
                        value="{{ old('aerobic_plate_count_result', $worksheet->aerobic_plate_count_result ?? '') }}">
                    cfu/g
                </td>
            </tr>

            <tr class="separator"><td colspan="14"></td></tr>

            <tr>
                <td class="light-cell"></td>
                <td colspan="12" class="teal-head">NO. OF + REPLICATES</td>
                <td class="light-cell"></td>
            </tr>

            <tr>
                <td class="light-cell"></td>
                <td colspan="4" class="dilution">10<sup>-1</sup> (0.1)</td>
                <td colspan="4" class="dilution">10<sup>-2</sup> (0.01)</td>
                <td colspan="4" class="dilution">10<sup>-3</sup> (0.001)</td>
                <td class="light-cell"></td>
            </tr>

            <tr>
                <td class="light-cell"></td>
                <td colspan="4">LST Broth:</td>
                <td colspan="4">LST Broth:</td>
                <td colspan="4">LST Broth:</td>
                <td class="light-cell"></td>
            </tr>

            <tr>
                <td class="test-name">Total Coliform Count</td>
                <td colspan="4">BGLB Broth:</td>
                <td colspan="4">BGLB Broth:</td>
                <td colspan="4">BGLB Broth:</td>
                <td class="result-cell">
                    <input type="text" id="total_col_count_result" name="total_col_count_result"
                        value="{{ old('total_col_count_result', $worksheet->total_col_count_result ?? '') }}">
                    MPN/g
                </td>
            </tr>

            <tr>
                <td class="test-name">Fecal Coliform Count</td>
                <td colspan="4">EC Broth:</td>
                <td colspan="4">EC Broth:</td>
                <td colspan="4">EC Broth:</td>
                <td class="result-cell">
                    <input type="text" id="fecal_col_count_result" name="fecal_col_count_result"
                        value="{{ old('fecal_col_count_result', $worksheet->fecal_col_count_result ?? '') }}">
                    MPN/g
                </td>
            </tr>

            <tr>
                <td class="test-name italic">Escherichia coli Count</td>
                <td colspan="4">L-EMB Agar:<br>Confirmed Tests:</td>
                <td colspan="4">L-EMB Agar:<br>Confirmed Tests:</td>
                <td colspan="4">L-EMB Agar:<br>Confirmed Tests:</td>
                <td class="result-cell">
                    <input type="text" id="esc_coli_count_result" name="esc_coli_count_result"
                        value="{{ old('esc_coli_count_result', $worksheet->esc_coli_count_result ?? '') }}">
                    MPN/g
                </td>
            </tr>

            <tr class="separator"><td colspan="14"></td></tr>

            <tr>
                <td rowspan="3" class="test-name italic">Staphylococcus aureus Count</td>
                <td colspan="4" class="teal-head dilution">10<sup>-1</sup></td>
                <td colspan="4" class="teal-head dilution">10<sup>-2</sup></td>
                <td colspan="4" class="teal-head dilution">10<sup>-3</sup></td>
                <td rowspan="3" class="result-cell">
                    <input type="text" id="staphy_aureus_count_result" name="staphy_aureus_count_result"
                        value="{{ old('staphy_aureus_count_result', $worksheet->staphy_aureus_count_result ?? '') }}">
                    cfu/g
                </td>
            </tr>

            <tr>
                @for($i = 1; $i <= 3; $i++)
                    <td class="tiny">R1 0.3 ml</td>
                    <td class="tiny">R2 0.3 ml</td>
                    <td colspan="2" class="tiny">R3 0.4 ml</td>
                @endfor
            </tr>

            <tr>
                @for($i = 1; $i <= 3; $i++)
                    <td colspan="2" class="tiny">Coagulase Test</td>
                    <td colspan="2" class="tiny">Catalase Test</td>
                @endfor
            </tr>

            <tr class="separator"><td colspan="14"></td></tr>

            <tr>
                <td rowspan="6" class="test-name italic">Salmonella sp.</td>
                <td colspan="2">pH:</td>
                <td colspan="10" class="center">
                    Incubation at Room Temperature:
                    &nbsp;&nbsp; Time Started:
                    &nbsp;&nbsp;&nbsp;&nbsp; Time Ended:
                </td>
                <td rowspan="6" class="result-cell">
                    <input type="text" id="salmonella_result" name="salmonella_result"
                        value="{{ old('salmonella_result', $worksheet->salmonella_result ?? '') }}">
                    <br>per 25 g sample
                </td>
            </tr>

            <tr>
                <td colspan="2">Isolation</td>
                <td colspan="5" class="bold center">RV Medium</td>
                <td colspan="5" class="bold center">TT Broth</td>
            </tr>

            <tr>
                <td colspan="2"></td>
                <td class="center">BS Agar</td>
                <td colspan="2" class="center">XLD Agar</td>
                <td colspan="2" class="center">HE Agar</td>
                <td class="center">BS Agar</td>
                <td colspan="2" class="center">XLD Agar</td>
                <td colspan="2" class="center">HE Agar</td>
            </tr>

            <tr>
                <td colspan="2">TSI Agar Slant<br>TSI Agar Butt</td>
                <td colspan="10" class="blank"></td>
            </tr>

            <tr>
                <td colspan="2">LIA Butt</td>
                <td colspan="10" class="blank"></td>
            </tr>

            <tr>
                <td colspan="2">Biochemical<br>Tests / API</td>
                <td colspan="10" class="blank"></td>
            </tr>

            <tr class="separator"><td colspan="14"></td></tr>

            <tr>
                <td rowspan="2" class="test-name italic">Shigella sp.</td>
                <td colspan="3">Isolation: McConkey Agar<br>Plate</td>
                <td colspan="9" class="blank"></td>
                <td rowspan="2" class="result-cell">
                    <input type="text" id="shigella_result" name="shigella_result"
                        value="{{ old('shigella_result', $worksheet->shigella_result ?? '') }}">
                    <br>per 25 g sample
                </td>
            </tr>

            <tr>
                <td colspan="3">Biochemical Tests / API</td>
                <td colspan="9" class="blank"></td>
            </tr>
        </table>

        <table class="micro-table mt-2">
            <tr>
                <td colspan="4" class="center bold qc-header">QC RESULTS</td>
            </tr>

            <tr class="qc-subheader">
                <td class="center bold">Tests</td>
                <td class="center bold">QC Checks</td>
                <td class="center bold">Negative Control</td>
                <td class="center bold">Positive Control</td>
            </tr>

            <tr>
                <td>Aerobic Plate Count</td>
                <td>PCA</td>
                <td></td>
                <td>white colonies</td>
            </tr>

            <tr>
                <td>Presumptive Tests for TC, FC, EC</td>
                <td>LST Broth</td>
                <td></td>
                <td>with gas production, turbid with effervescence</td>
            </tr>

            <tr>
                <td>Total Coliform</td>
                <td>BGLB</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Fecal Coliform</td>
                <td>EC Broth</td>
                <td></td>
                <td>with gas production, turbid with effervescence</td>
            </tr>

            <tr>
                <td class="italic">E. coli</td>
                <td>
                    EMB Agar<br>
                    Gram Reaction<br>
                    TB / Indole Test<br>
                    Voges Proskauer<br>
                    Methyl Red<br>
                    SCA / KCB / Citrate Utilization<br>
                    Gas Production
                </td>
                <td></td>
                <td>
                    ☐ greenish metallic sheen<br>
                    ☐ gram (-)<br>
                    ☐ red color<br>
                    ☐ red color<br>
                    ☐ yellow color (-)<br>
                    ☐ no color change<br>
                    ☐ with gas production
                </td>
            </tr>

            <tr>
                <td class="italic">Staphylococcus aureus</td>
                <td></td>
                <td><em>E. coli</em> - inhibition</td>
                <td></td>
            </tr>

            <tr>
                <td class="italic">Salmonella sp.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td class="italic">Shigella sp.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td class="bold">Formula / Computation</td>
                <td colspan="3">
                    <textarea id="formula" name="formula" class="formula-box">{{ old('formula', $worksheet->formula ?? '') }}</textarea>
                </td>
            </tr>
        </table>

    </div>

    <div class="text-end mt-3">
        <button type="submit" class="btn btn-success">
            {{ isset($worksheet) ? 'Update' : 'Save' }}
        </button>
    </div>
</form>

<script>
document.querySelectorAll('.formula-box').forEach(el => {
    el.style.height = 'auto';
    el.style.height = el.scrollHeight + 'px';

    el.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
});
</script>
            </div>
        </div>
    </div>
</div>
@endsection
