<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Health Certificate</title>

<style>
    @page {
        size: legal portrait;
        margin: 12px 18px 10px 18px;
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: Cambria, DejaVu Serif, serif;
        font-size: 12px;
        color: #000;
        margin: 0;
        padding: 0;
        line-height: 1.12;
    }

    .page {
        width: 100%;
        position: relative;
    }

    .header-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2px;
    }

    .header-table td {
        border: none;
        vertical-align: top;
        padding: 0;
    }

    .logo-cell {
        width: 120px;
        text-align: center;
    }

    .logo-cell img {
        width: 150px;
        height: 100px;
    }

    .header-text {
        font-size: 11px;
        line-height: 1.08;
        font-weight: bold;
    }

    .header-text .small {
        font-weight: normal;
    }

    .stamp {
        position: absolute;
        top: 3px;
        right: 30px;
        border: 1.5px solid #123c8c;
        color: #123c8c;
        font-size: 11px;
        font-weight: bold;
        padding: 4px 11px;
        transform: rotate(-2deg);
    }

    .main-title {
        text-align: center;
        font-weight: bold;
        font-size: 11.8px;
        margin-top: 5px;
        margin-bottom: 2px;
        line-height: 1.12;
    }

    .cert-no {
        text-align: right;
        font-weight: bold;
        font-size: 11.5px;
        margin-bottom: 0;
        padding-right: 6px;
    }

    .outer-box {
        border: 1px solid #000;
        width: 100%;
        min-height: auto !important;
        height: auto !important;
    }

    .section {
        border-bottom: 1px solid #000;
        padding: 6px 10px;
        page-break-inside: avoid;
    }

    .section-title {
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 3px;
        font-size: 12px;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
    }

    .info-table td {
        border: none;
        padding: 1.5px 0;
        vertical-align: top;
    }

    .label {
        width: 220px;
        font-weight: normal;
    }

    .colon {
        width: 14px;
        text-align: center;
    }

    .value {
        font-weight: bold;
    }

    .italic {
        font-style: italic;
    }

    .declaration {
        padding: 8px 10px 6px 10px;
        font-size: 12px;
        line-height: 1.18;
        text-align: justify;
        page-break-inside: avoid;
    }

    .declaration p {
        margin: 7px 0;
    }

    .underline {
        text-decoration: underline;
        font-weight: bold;
    }

    .center-text {
        text-align: center;
        margin-top: -1px;
        margin-bottom: 3px;
    }

    .seal-sign-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        page-break-inside: avoid;
    }

    .seal-sign-table td {
        border: none;
        vertical-align: top;
    }

    .seal-cell {
        width: 28%;
    }

    .seal {
        width: 100px;
        height: 100px;
        border: 2px dashed #000;
        border-radius: 50%;
        text-align: center;
        font-size: 9.5px;
        font-style: italic;
        padding-top: 27px;
        box-sizing: border-box;
    }

    .authority {
        text-align: center;
        font-size: 12px;
        padding-top: 4px;
    }

    .signature-space {
        height: 36px;
    }

    .officer-name {
        font-weight: bold;
        text-decoration: underline;
        font-size: 12px;
    }

    .footer-fees {
        margin-top: 5px;
        font-size: 12px;
        line-height: 1.12;
    }

    .footer-fees span {
        text-decoration: underline;
        font-weight: bold;
    }
</style>
</head>

<body>

@php
    $departureDate = !empty($certificate->date_of_departure)
        ? \Carbon\Carbon::parse($certificate->date_of_departure)->format('d F Y')
        : '';

    $analysisDate = !empty($certificate->analysis_date)
        ? \Carbon\Carbon::parse($certificate->analysis_date)->format('d F Y')
        : '';

    $issuedDate = !empty($certificate->issued_date)
        ? \Carbon\Carbon::parse($certificate->issued_date)->format('d F Y')
        : '';

    $orDate = !empty($certificate->or_date)
        ? \Carbon\Carbon::parse($certificate->or_date)->format('d F Y')
        : '';

    $logoPath = public_path('assets/images/bfarlogo.png');
@endphp

<div class="page">

    <div class="stamp">
        INFORMATION
    </div>

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                @if(file_exists($logoPath))
                    <img src="{{ $logoPath }}" alt="Logo">
                @endif
            </td>

            <td>
                <div class="header-text">
                    Republic of the Philippines<br>
                    Department of Agriculture<br>
                    BUREAU OF FISHERIES AND AQUATIC RESOURCES<br>
                    <span class="small">
                        Regional Government Center, Carpenter Hill, Koronadal City<br>
                        Tel/Fax No. (083)228-1898; 228-1897; 228-1899
                    </span>
                </div>
            </td>
        </tr>
    </table>

    <div class="main-title">
        HEALTH CERTIFICATE FOR TRANSBOUNDARY MOVEMENT OF LIVE FISH AND<br>
        FISHERY/AQUATIC PRODUCTS
    </div>

    <div class="cert-no">
        Health Certificate No. {{ $certificate->health_certificate_no ?? '' }}
    </div>

    <div class="outer-box">

        {{-- I. CONSIGNOR --}}
        <div class="section">
            <div class="section-title">I. CONSIGNOR</div>

            <table class="info-table">
                <tr>
                    <td class="label">Name of Shipper</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->shipper_name ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Address</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->shipper_address ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Name of Company/Facility</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->company_facility_name ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Address</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->company_facility_address ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Telephone Number</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->shipper_telephone ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Registration Number</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->shipper_registration_no ?? '' }}</td>
                </tr>
            </table>
        </div>

        {{-- II. COMMODITY --}}
        <div class="section">
            <div class="section-title">II. COMMODITY</div>

            <table class="info-table">
                <tr>
                    <td class="label">Description of Commodity</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->commodity_description ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Scientific Name</td>
                    <td class="colon">:</td>
                    <td class="value italic">{{ $certificate->scientific_name ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Quantity (no. of pieces/kgs)</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->quantity ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Location of Source</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->location_of_source ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Wild caught / Culture</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->wild_caught_culture ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Tank Number</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->tank_number ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Pond/Cage Number</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->pond_cage_number ?? '' }}</td>
                </tr>
            </table>
        </div>

        {{-- III. CONSIGNEE --}}
        <div class="section">
            <div class="section-title">III. CONSIGNEE</div>

            <table class="info-table">
                <tr>
                    <td class="label">Name of Consignee</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->consignee_name ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Address</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->consignee_address ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Registration Number</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->consignee_registration_no ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Telephone Number</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->consignee_telephone ?? '' }}</td>
                </tr>
            </table>
        </div>

        {{-- IV. SHIPMENT DETAILS --}}
        <div class="section">
            <div class="section-title">IV. SHIPMENT DETAILS</div>

            <table class="info-table">
                <tr>
                    <td class="label">Place of Loading</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->place_of_loading ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Address</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->loading_address ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Date of Departure</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $departureDate }}</td>
                </tr>
                <tr>
                    <td class="label">Means of Transport</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->means_of_transport ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Port of Destination</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $certificate->port_of_destination ?? '' }}</td>
                </tr>
            </table>
        </div>

        {{-- V. DECLARATION --}}
        <div class="declaration">
            <div class="section-title">V. DECLARATION</div>

            <p>
                This is to certify that the above-mentioned commodity with Sample Code
                <span class="underline">{{ $certificate->sample_code ?? '' }}</span>
                were subjected to laboratory analyses and showed
                <span class="underline">{{ $certificate->result ?? '' }}</span>
                for
                <span class="underline">{{ $certificate->disease_toxin_microbes ?? '' }}</span>
                dated
                <span class="underline">{{ $analysisDate }}</span>.
            </p>

            <div class="center-text">
                (Name of Disease/s/Toxin/Microbes)
            </div>

            <p>
                Issued at the <strong>{{ $certificate->issued_at ?? 'BFAR RFL 12' }}</strong>
                on
                <span class="underline">{{ $issuedDate }}</span>
                for trans-boundary movement of live fish and fishery/aquatic products in compliance with
                relevant rules, regulations and legislations of the Republic of the Philippines.
            </p>

            <table class="seal-sign-table">
                <tr>
                    <td class="seal-cell">
                        <div class="seal">
                            Valid only<br>
                            with the<br>
                            BFAR<br>
                            Official Dry<br>
                            Seal.
                        </div>
                    </td>

                    <td class="authority">
                        By the Authority of the Regional Director :

                        <div class="signature-space"></div>

                        <div class="officer-name">
                            {{ strtoupper($certificate->certifying_officer ?? '') }}
                        </div>

                        <div>
                            {{ $certificate->certifying_officer_position ?? 'Certifying Officer' }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

    <div class="footer-fees">
        Fees collected: <span>{{ $certificate->fees_collected ?? '' }}</span><br>
        OR No.: <span>{{ $certificate->or_no ?? '' }}</span><br>
        OR Date: <span>{{ $orDate }}</span>
    </div>

</div>

</body>
</html>