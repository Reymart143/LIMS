<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>RLA PDF</title>
    <style>
        @page {
            margin: 12px 18px 12px 18px;
        }

        body {
           font-family: Cambria, "Times New Roman", serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .bordered td,
        .bordered th {
            border: 1px solid #000;
            vertical-align: top;
            padding: 2px 4px;
        }

        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 6px; }
        .mb-3 { margin-bottom: 8px; }

        .header-title {
            /* text-align: center; */
            line-height: 1.12;
            font-size: 9px;
        }

        .big {
            font-weight: bold;
            font-size: 10px;
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            vertical-align: middle !important;
            font-size: 11px;
        }

        .logo-cell {
            width: 90px;
            text-align: center;
            vertical-align: middle !important;
        }

        .logo-cell img {
            max-width: 58px;
            max-height: 58px;
        }

        .value-box {
            min-height: 10px;
            line-height: 1.1;
            word-wrap: break-word;
        }

        .table-header td {
            text-align: center;
            font-weight: bold;
            vertical-align: middle !important;
            font-size: 10px;
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .small-note {
            font-size: 9px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .tiny {
            font-size: 8.5px;
        }

        .terms-title {
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 3px;
        }

        .terms {
            font-size: 8px;
            line-height: 1.05;
            text-align: justify;
        }

        .indent {
            padding-left: 14px;
        }

        .sample-row td {
            height: 14px;
            padding-top: 2px;
            padding-bottom: 2px;
            font-size: 9px;
        }

        .footer-box td {
            font-size: 9px;
            padding: 2px 4px;
        }

        .nowrap {
            white-space: nowrap;
        }
        .page-break {
    page-break-before: always;
}

.page2 {
    font-size: 10px;
    line-height: 1.2;
}

.page2-title {
    font-weight: bold;
    margin-bottom: 8px;
}

.page2-subtitle {
    font-weight: bold;
    text-decoration: underline;
    margin-top: 8px;
    margin-bottom: 4px;
}

.page2-note {
    font-style: italic;
}

.page2 p {
    margin: 0 0 5px 0;
}

.page2 .indent {
    margin-left: 18px;
}

.page2 .indent2 {
    margin-left: 34px;
}

.page2 .red {
    color: red;
    font-weight: bold;
}

.page2 .remarks-box {
    border: 1px solid #000;
    width: 250px;
    height: 65px;
    padding: 4px;
    margin-top: 10px;
}

.page2 .remarks-line {
    border-bottom: 1px solid #000;
    height: 14px;
}

/* .page2-map {
    width: 250px;
    border: 1px solid #000;
    margin-top: 10px;
}

.page2-map td {
    border: 1px solid #999;
    font-size: 9px;
    text-align: center;
    padding: 8px 4px;
}

.page2-map .main {
    font-size: 20px;
    font-weight: bold;
}

.page2-map .street {
    font-size: 10px;
    font-weight: bold;
} */

.page2-left {
    width: 58%;
    vertical-align: top;
}

.page2-right {
    width: 42%;
    vertical-align: bottom;
}   
   .page2-map {
        width: 260px;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .page2-map td {
        border: 2px solid #c0392b; 
        text-align: center;
        vertical-align: middle;
        padding: 8px 4px;
        font-size: 9px;
        background-color: #a9c3dd; 
    }

    .page2-map .box {
        height: 45px;
    }

    .page2-map .main {
        font-size: 20px;
        font-weight: bold;
        letter-spacing: 1px;
    }

    .page2-map .street-box {
        background-color: #d9e3ef; 
        font-size: 11px;
        font-weight: bold;
        padding: 10px 0;
        border-left: 2px solid #c0392b;
        border-right: 2px solid #c0392b;
        border-top: 2px solid #c0392b;
        border-bottom: 2px solid #c0392b;
    }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <table class="bordered mb-1">
        <colgroup>
            <col style="width: 78px;">
            <col>
        </colgroup>
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('assets/images/bfarlogo.png') }}" width="150" alt="Logo">
            </td>
            <td class="header-title">
                <div>Republic of the Philippines</div>
                <div>Department of Agriculture</div>
                <div class="big">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
                <div class="big">REGIONAL FISHERIES LABORATORY XII</div>
                <div>J. Catolico St., Lagao, General Santos City</div>
            </td>
        </tr>
    </table>

    {{-- DOCUMENT INFO --}}
    <table class="bordered mb-1">
        <colgroup>
            <col style="width: 22%;">
            <col style="width: 22%;">
            <col style="width: 30%;">
            <col style="width: 26%;">
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
                <div>13 August 2019</div>
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

    {{-- MAIN INFO --}}
    <table class="bordered mb-1">
        <colgroup>
            <col style="width: 28%;">
            <col style="width: 31%;">
            <col style="width: 41%;">
        </colgroup>

        <tr>
            <td>Name of Company</td>
            <td>
                <div class="value-box">{{ $client->company_name ?? '' }}</div>
            </td>
            <td>
                <span class="bold">RLA No.  {{ $rla->RLA_no ?? '' }}</span>
                <div class="value-box"></div>
            </td>
        </tr>

        <tr>
            <td>Address</td>
            <td>
                <div class="value-box">{{ $displayAddress ?? '' }}</div>
            </td>
            <td class="center tiny">
                <div><strong>ATTN: EUGENE GAY B. JAMORA</strong></div>
                <div>Laboratory Manager</div>
                <div>Telefax: (083)5529328</div>
            </td>
        </tr>

        <tr>
            <td>Contact No</td>
            <td>
                <div class="value-box">{{ $client->contact_no ?? $rla->contact_no ?? '' }}</div>
            </td>
            <td></td>
        </tr>

        <tr>
            <td>Source of Sample</td>
            <td>
                <div class="value-box">{{ $rla->source_sample ?? '' }}</div>
            </td>
            <td>
             @php
                $sampleType = strtolower(trim($rla->sample ?? ''));
            @endphp

            <div class="nowrap" style="font-size:11px; margin-top:7px;">

                {{-- OFFICIAL --}}
                <span style="display:inline-block; margin-right:20px;">
                    <span style="
                        display:inline-block;
                        width:13px;
                        height:13px;
                        border:1px solid #000;
                        background-color: {{ strpos($sampleType, 'official') !== false ? '#28a745' : 'transparent' }};
                        vertical-align:middle;
                        margin-right:5px;
                    "></span>
                    <span style="vertical-align:middle;">Official Sample</span>
                </span>

                {{-- INDUSTRY --}}
                <span style="display:inline-block;">
                    <span style="
                        display:inline-block;
                        width:13px;
                        height:13px;
                        border:1px solid #000;
                        background-color: {{ strpos($sampleType, 'industry') !== false ? '#28a745' : 'transparent' }};
                        vertical-align:middle;
                        margin-right:5px;
                    "></span>
                    <span style="vertical-align:middle;">Industry Sample</span>
                </span>

            </div>
                <div class="mt-1">
                    Date Collected:
                    {{ !empty($rla->date_collected) ? \Carbon\Carbon::parse($rla->date_collected)->format('m/d/Y') : '' }}
                </div>
            </td>
        </tr>
    </table>

    {{-- SAMPLE TABLE --}}
    <table class="bordered mb-1">
        <thead>
            <tr class="table-header">
                <td style="width:22%;">Laboratory Code</td>
                <td style="width:20%;">Sample Description</td>
                <td style="width:14%;">Sample Code</td>
                <td style="width:18%;">Analyses Requested</td>
                <td style="width:18%;">Test Method</td>
            </tr>
        </thead>
        <tbody>
            @php
                $displayRows = count($rows) > 0 ? $rows : [['laboratory_code'=>'','sample_description'=>'','sample_code'=>'','analysis_requested'=>'','test_method'=>'']];
                $targetRows = 9;
            @endphp

            @foreach($displayRows as $row)
                <tr class="sample-row">
                    <td>{{ $row['laboratory_code'] ?? '' }}</td>
                    <td>{{ $row['sample_description'] ?? '' }}</td>
                    <td>{{ $row['sample_code'] ?? '' }}</td>
                    <td>{{ $row['analysis_requested'] ?? '' }}</td>
                    <td>{{ $row['test_method'] ?? '' }}</td>
                </tr>
            @endforeach

            @for($i = count($displayRows); $i < $targetRows; $i++)
                <tr class="sample-row">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            @endfor
        </tbody>
    </table>
<style>
    .terms-title-check {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: bold;
}

.pdf-checkbox {
    display: inline-block;
    width: 13px;
    height: 13px;
    border: 1px solid #000;
    font-size: 10px;
    line-height: 12px;
    text-align: center;
    font-weight: bold;
    font-family: DejaVu Sans, sans-serif;
}
</style>
    {{-- TERMS --}}
    <table class="bordered mb-1">
        <tr>
            <td style="padding: 5px 6px;">
                <div class="terms-title terms-title-check">
                    <span class="pdf-checkbox">&#10003;</span>
                    <span>Terms and Conditions</span>
                </div>
                <div class="terms">
                    <div>1. Within the testing capability and resources of RFL12, the abovementioned request for test shall be conducted.</div>
                    <div>2. The tests shall be conducted in reference to the abovementioned Test Method.</div>
                    <div>3. The customer shall be informed immediately if any deviation from the contract occurs.</div>
                    <div>4. In the event that RFL12 does not have available capability and resources, RFL12 shall inform the customer (through telephone/writing) and refer them to other laboratory that meets their requirements.</div>
                    <div>5. In the event that samples need to be subcontracted, RFL12 shall inform the customer (through telephone/writing) that these samples shall be sent (preferably) at an ISO/IEC 17025 (or equivalent QS) accredited laboratory. In this connection, please be informed that:</div>
                    <div class="indent">5.1 RFL12 shall act accordingly upon the written reply from the customer.</div>
                    <div class="indent">5.2 If samples will be sent at an ISO/17025 accredited laboratory, RFL12 shall not be liable for whatever damage the sample will sustain brought about by the destructive tests (if any) performed on the sample.</div>
                    <div>6. Change(s) in the request for testing work should be relayed to RFL12, in writing, addressed to the Laboratory Manager, and/or fill up the ACTION SLIP. In connection with this, please be informed that:</div>
                    <div class="indent">6.1 If request of halt of all/some tests is made, excess/undue payment (if any) shall be refunded only by way of crediting this payment to future financial obligation of the payer to RFL12.</div>
                    <div class="indent">6.2 RFL12 shall consider request for additional test(s) as new testing work. Thus, another Request for Laboratory Analyses shall be filed.</div>
                    <div class="indent">6.3 RFL12 shall consider request for changes to entry (Address, Consignee, Destination, Product Code) in RLA or Report of Test.</div>
                    <div>7. After the conduct of test, the tested samples shall be retained accordingly. RFL12 shall entertain inquiries/claims regarding this particular testing work only within this period (14 days after submission of samples). After this period had elapsed, RFL12 implements its procedure for retrieval/disposal of tested samples.</div>
                    <div>8. To facilitate the retrieval of tested samples kindly note your intention below:</div>
                    <div class="indent">_____ The customer will retrieve the retained sample.</div>
                    <div class="indent">_____ The customer will not retrieve the retained sample.</div>
                    <div>9. Re-test/Re-sampling shall only be conducted for samples that failed with a (the) requirement(s) of the relevant Test Method. In this connection please be guided that:</div>
                    <div class="indent">9.1 Re-test shall be performed on the retained sample and only for the specific test requirement that the sample failed.</div>
                    <div class="indent">9.2 Re-sampling shall be performed on the new sample drawn and submitted and for all the test requirements. RFL12 shall consider this request as new testing work. Thus, another Request for Laboratory Analyses shall be filed.</div>
                    <div>10. The Official Test Report for the sample shall be released on ____________________, in accordance with the Work Schedule. For industry samples, official Report of Test shall not be released without the full payment of testing fee. RFL12 shall not send official Report of Test through fax or e-mail unless otherwise authorized by the Laboratory Manager.</div>
                    <div>11. For samples that don’t meet the requirements, the customer will sign the Sample Waiver Form, LF 06-07.</div>
                </div>

                <table style="width:100%; margin-top:4px; border-collapse:collapse;">
                    <tr>
                        <td style="width:11%; font-size:8px; font-weight:bold;">CONFORME:</td>
                        <td style="width:39%; border-bottom:1px solid #000;"></td>
                        <td style="width:7%; font-size:8px; text-align:center;">Date:</td>
                        <td style="width:18%; border-bottom:1px solid #000;"></td>
                        <td style="width:25%; font-size:8px; text-align:center; font-weight:bold;">Reviewed By:</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align:center; font-size:7px; padding-top:2px;">Name and Signature (Company Representative)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- BOTTOM INFO --}}
    <table class="bordered footer-box mb-1">
        <colgroup>
            <col style="width: 29%;">
            <col style="width: 15%;">
            <col style="width: 18%;">
            <col style="width: 18%;">
            <col style="width: 20%;">
        </colgroup>
        <tr>
            <td rowspan="2">
                Sample Received by:
                <div class="value-box" style="height:18px;">{{ $rla->sample_received_by ?? '' }}</div>
                <div class="small-note">(Customer Service Officer)</div>
                {{ $rla->service_officer ?? '' }}<
            </td>
            <td rowspan="2">
                Date Received
                <div class="value-box">{{ !empty($rla->date_received) ? \Carbon\Carbon::parse($rla->date_received)->format('m/d/Y') : '' }}</div>
            </td>
            <td colspan="3">
                <strong>Payment (Partial / Full) Amount</strong>
                <span style="float:right;">{{ $rla->payment ?? '' }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Date payment received
                <div class="value-box">{{ !empty($rla->date_payment) ? \Carbon\Carbon::parse($rla->date_payment)->format('m/d/Y') : '' }}</div>
            </td>
            <td>
                <strong>OR No.:</strong>
                <div class="value-box">{{ $rla->or_no ?? '' }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="5">
                Remarks:
                <div class="value-box">{{ $rla->remarks ?? '' }}</div>
            </td>
        </tr>
    </table>
    <div class="page-break"></div>
<div class="page2">
    <table class="bordered mb-2">
        <colgroup>
            <col style="width: 78px;">
            <col>
        </colgroup>
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('assets/images/bfarlogo.png') }}" alt="Logo">
            </td>
            <td class="header-title">
                <div>Republic of the Philippines</div>
                <div>Department of Agriculture</div>
                <div class="big">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
                <div class="big">REGIONAL FISHERIES LABORATORY XII</div>
                <div>J. Catolico St., Lagao, General Santos City</div>
            </td>
        </tr>
    </table>

    <table class="bordered mb-2">
        <colgroup>
            <col style="width: 22%;">
            <col style="width: 22%;">
            <col style="width: 30%;">
            <col style="width: 26%;">
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
                <div>13 August 2019</div>
            </td>
            <td>
                <div>Page No:</div>
                <div>Page 2 of 2</div>
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

    <p><strong>To all RFL12 Customers:</strong></p>

    <p>
        For your guidance please read the following
        <strong>General Information in the Acceptance of Testing Work at RFL12.</strong>
    </p>

    <div class="page2-subtitle">Submission of samples and payment of testing fees</div>

    <p><strong>A. For Industry Samples:</strong></p>
    <p class="indent">1. Samples to be submitted should be accompanied with completely and accurately filled up (in duplicate copies) Request for Laboratory Analyses form.</p>
    <p class="indent">2. To validate the drawn samples, the sample itself (where applicable) should be duly signed/dated by the Authorized personnel of the company who drew the said samples.</p>
    <p class="indent">3. In cases where samples maybe sent through courier, RFL12 may accept the samples but it reserves the right not to officially log the samples and subsequently test them until payment has been made. Such sample shall be stored only for one week, after which, it will be disposed of appropriately.</p>
    <p class="indent">4. Number/Amount of samples to be submitted should be adequate (and where practicable including its required retained sample). The quantity/description and specification of the fish product samples should reflect what is declared in the Request for Laboratory Analyses form.</p>
    <p class="indent">5. Additional testing fee maybe charged after the actual assessment made by RFL12.</p>

    <p><strong>B. For Official Samples.</strong></p>
    <p class="indent">1. Customer shall completely and accurately fill up (in duplicate copies) the Request for Laboratory Analyses form or provide the necessary information. The Customer Service Officer will fill up the form based on the information.</p>

    <p><strong>C. For all types of customer</strong></p>
    <p class="indent">1. The customers are advised to protect their samples from damage/deterioration during transport from their premise to RFL</p>
    <p class="indent">2. The customer is advised to submit samples that are ice packed or frozen. Refer to LF 04-01 (List of Analyses, Subcontractors and Fees)</p>

    <p class="page2-note">
        <strong>Note:</strong> The Laboratory is not liable for samples while they are in transit, prior to their acceptance.
    </p>

    <div class="page2-subtitle">Testing of Samples</div>

    <p class="indent">1. RFL12 follows the “first in first out policy” in accomplishing its testing work.</p>
    <p class="indent">2. RFL12 maintains a tentative due date for the completion of its testing work, depending on the workload of the concerned laboratory.</p>
    <p class="indent">3. RFL12 will not entertain follow up on status of testing.</p>
    <p class="indent">4. For official and/or experimental samples, RFL12 will request the concerned customer to submit another sample (e.g. from other batch) if results of monitoring are outside the specified limit. This will however be allowed twice, otherwise, customers will be advised to undertake the necessary corrective actions.</p>

    <div class="page2-subtitle">After test</div>
    <p>Only the written Report of Test approved by the Laboratory Manager, RFL12 shall be considered valid.</p>

    <div class="page2-subtitle">Retrieval of tested samples</div>
    <p>
        <strong>Note:</strong> The customer should state his/her intention (see front) to retrieve the tested sample.
        To retrieve the retained sample, the company representative must present the duplicate copy of Request for the
        Laboratory Analysis together with Company ID at the Customer Service of RFL12.
    </p>

    <p class="red">All results are strictly confidential….</p>

    <table style="width:100%; border-collapse:collapse; margin-top:10px;">
        <tr>
            <td class="page2-left">
                <div class="page2-subtitle">Service to Customer</div>
                <p class="indent">1. For our continuous improvement, we encourage our customer to fill up our “Customer Satisfaction Survey” upon submission of the samples.</p>
                <p class="indent">2. RFL12 accepts samples at the BFAR RFL Building, J. Catolico St., General Santos City</p>

                <div class="page2-subtitle">Disclaimer</div>
                <p>
                    RFL12 is not held responsible for results that exceeds the standard limits when test items submitted
                    have known deviations (i.e. not properly stored; spoiled/rotten; experimental items)
                </p>

                <div class="remarks-box">
                    <strong>Remarks:</strong>
                    <div class="remarks-line"></div>
                    <div class="remarks-line"></div>
                    <div class="remarks-line"></div>
                </div>
            </td>
            <td class="page2-right">
                <table class="page2-map" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="box">Tiongson<br>Street</td>
                        <td class="box">
                            J.<br>
                            <span style="text-decoration:underline;">Saddik</span><br>
                            <span style="text-decoration:underline;">Litson</span><br>
                            <span style="text-decoration:underline;">Manok</span>
                        </td>
                        <td class="box main">BFAR</td>
                        <td class="box">Jollibee</td>
                    </tr>

                    <tr>
                        <td colspan="4" class="street-box">
                            - - - - - - - - J. Catolico Street - - - - - - - -
                        </td>
                    </tr>

                    <tr>
                        <td class="box">Caltex<br>Station</td>
                        <td class="box">Tiongson<br>Extension<br>Street</td>
                        <td class="box">Geronimo<br>Street</td>
                        <td class="box">McDonalds</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>