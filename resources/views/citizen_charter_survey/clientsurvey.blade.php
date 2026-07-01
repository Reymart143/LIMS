
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>LIMS </title>
      <link rel="shortcut icon" href="assets/images/bfarlogo.png">
      <link rel="stylesheet" href="/assets/css/core/libs.min.css">
      <link rel="stylesheet" href="/assets/css/hope-ui.min.css?v=4.0.0">
      <link rel="stylesheet" href="/assets/css/custom.min.css?v=4.0.0">
      <link rel="stylesheet" href="/assets/css/customizer.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
       <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
        integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
        integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
        crossorigin=""></script>
        <script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js'></script>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <style>
        body.modal-open {
            overflow: hidden;
        }
        body.modal-open::before {
            content: "";
            position: fixed;
            inset: 0;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            background: rgba(0,0,0,0.3);
            z-index: 1040; 
        }
      </style>
  </head>
  <body class="  ">
         @if(session('success'))
      <div class="mb-3 alert alert-left alert-success alert-dismissible fade show auto-dismiss"
         role="alert"
         style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
         <i class="bi bi-check-circle-fill me-2" style="font-size: 20px;"></i>
         <span>{{ session('success') }}</span>

         <button type="button" class="btn-close btn-close-white"
                  data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif


      @if(session('error'))
      <div class="mb-3 alert alert-bottom alert-danger alert-dismissible fade show auto-dismiss"
         role="alert"
         style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
          <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 20px;"></i>
         <span>{{ session('error') }}</span>

         <button type="button" class="btn-close btn-close-white"
                  data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <script>
      setTimeout(function () {
         document.querySelectorAll('.auto-dismiss').forEach(function(alert) {
            alert.classList.remove('show'); 
            setTimeout(() => alert.remove(), 500);
         });
      }, 4000);
      </script>
<style>
    .survey-wrapper {
        background: #fff;
        padding: 20px;
        color: #000;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        width: 100%;
        overflow-x: hidden;
    }

    .survey-paper {
        width: 100%;
        max-width: 1100px;
        margin: auto;
        border: 1px solid #ddd;
        padding: 25px;
        background: white;
        box-sizing: border-box;
        overflow: hidden;
    }

    .header-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    .header-table td {
        border: none;
        vertical-align: top;
    }

    .bfar-logo {
        width: 95px;
        height: auto;
    }

    .header-title {
        text-align: left;
        font-size: 16px;
        line-height: 1.1;
        word-break: break-word;
    }

    .header-title .big {
        font-size: 17px;
        color: #154a8b;
        font-weight: bold;
    }

    .top-control-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .version-btn {
        border: 1px solid #000;
        padding: 8px 18px;
        font-weight: bold;
        background: #fff;
        cursor: pointer;
        white-space: nowrap;
    }

    .line-input {
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        width: 180px;
        max-width: 100%;
        padding: 1px 4px;
        background: transparent;
    }

    .line-input-sm {
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        width: 70px;
        max-width: 100%;
        padding: 1px 4px;
        background: transparent;
    }

    .client-box {
        border: 1px solid #000;
        padding: 8px 12px;
        margin-top: 10px;
        margin-bottom: 18px;
        line-height: 1.4;
        width: 100%;
        box-sizing: border-box;
    }

    .client-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 18px;
        align-items: center;
        margin-bottom: 3px;
    }

    .client-row label {
        margin-bottom: 0;
        white-space: nowrap;
    }

    input[type="radio"],
    input[type="checkbox"] {
        accent-color: #000;
    }

    .cc-section {
        line-height: 1.25;
        margin-bottom: 12px;
        word-wrap: break-word;
    }

    .cc-indent {
        margin-left: 55px;
    }

    .survey-table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border: 1px solid #000;
    }

    .survey-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        margin: 0;
        table-layout: fixed;
    }

    .survey-table th,
    .survey-table td {
        border: 1px solid #000;
        padding: 5px;
        vertical-align: middle;
    }

    .survey-table th {
        text-align: center;
    }

    .question-col {
        width: 62%;
        text-align: left;
        line-height: 1.2;
        white-space: normal;
        overflow-wrap: break-word;
    }

    .rate-col {
        width: 6%;
        text-align: center;
        min-width: 48px;
    }

    .emoji {
        font-size: 24px;
        display: block;
        line-height: 1;
        white-space: nowrap;
    }

    .rating-radio {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .small-note {
        font-size: 12px;
        font-style: italic;
        line-height: 1.2;
    }

    .footer-code {
        text-align: right;
        font-size: 13px;
        line-height: 1.2;
        margin-top: 15px;
    }

    .comment-lines textarea {
        width: 100%;
        min-height: 90px;
        border: 1px solid #000;
        resize: vertical;
        padding: 8px;
        box-sizing: border-box;
    }

    .action-area {
        max-width: 1100px;
        margin: 15px auto;
        display: flex;
        gap: 8px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .survey-wrapper {
            padding: 10px;
            font-size: 13px;
        }

        .survey-paper {
            padding: 12px;
        }

        .header-table tr,
        .header-table td {
            display: block;
            width: 100% !important;
            text-align: center !important;
        }

        .header-title {
            text-align: center;
            font-size: 14px;
        }

        .header-title .big {
            font-size: 15px;
        }

        .bfar-logo {
            width: 80px;
            margin-bottom: 5px;
        }

        .line-input {
            width: 100%;
        }

        .client-row {
            display: block;
        }

        .client-row label {
            display: inline-block;
            white-space: normal;
            margin-right: 10px;
            margin-bottom: 4px;
        }

        .cc-indent {
            margin-left: 18px;
        }
    }

    @media print {
        .no-print {
            display: none !important;
        }

        .survey-wrapper {
            padding: 0;
            overflow: visible;
        }

        .survey-paper {
            border: none;
            padding: 0;
            max-width: 100%;
            overflow: visible;
        }

        .survey-table-responsive {
            overflow: visible;
            border: none;
        }

        .survey-table {
            min-width: 100%;
            width: 100%;
            table-layout: fixed;
        }

        .question-col {
            width: 58%;
        }

        .rate-col {
            width: 7%;
        }
    }
</style>

@php
    $isEdit = isset($survey) && $survey;

    $actionUrl = $isEdit
        ? route('citizen-charter-survey.update', $survey->id)
        : route('citizen-charter-survey.store');

    if (!function_exists('checkedRadio')) {
        function checkedRadio($survey, $field, $value) {
            return old($field, $survey->$field ?? '') == $value ? 'checked' : '';
        }
    }

    if (!function_exists('checkedBox')) {
        function checkedBox($survey, $field) {
            return old($field, $survey->$field ?? false) ? 'checked' : '';
        }
    }

    $questions = [
        'sqd0' => [
            'tagalog' => 'Nasiyahan ako sa serbisyong aking natanggap sa napuntahan na tanggapan.',
            'english' => 'I am satisfied with the service/s that I availed in the Bureau.'
        ],
        'sqd1' => [
            'tagalog' => 'Makatwiran ang oras na aking ginugol para sa pagproseso ng aking transaksyon.',
            'english' => 'I spent a reasonable amount of time for my transaction/s.',
            'label' => 'Responsiveness'
        ],
        'sqd2' => [
            'tagalog' => 'Nasunod ng opisina ang mga kinakailangang at hakbang ng transaksyon alinsunod sa ibinigay na impormasyon.',
            'english' => 'The office/s followed the transaction’s requirements and steps based on the information provided.',
            'label' => 'Reliability'
        ],
        'sqd3' => [
            'tagalog' => 'Ang transaksyon ay isinagawa sa madaling paraan at kaaya-ayang kapaligiran.',
            'english' => 'The transaction/s was conducted in an easily accessible and comfortable environment.',
            'label' => 'Access and Facilities'
        ],
        'sqd4' => [
            'tagalog' => 'Madali kong nahanap ang mga impormasyon tungkol sa aking transaksyon mula sa opisina o website nito.',
            'english' => 'I easily found information about my transaction/s from the office or other platforms.',
            'label' => 'Communication'
        ],
        'sqd5' => [
            'tagalog' => 'Nagbayad ako ng makatwirang halaga para sa aking transaksyon.',
            'english' => 'I paid a reasonable amount of fees for my transaction/s.',
            'label' => 'Costs'
        ],
        'sqd6' => [
            'tagalog' => 'Naramdaman ko ang pagiging patas ng opisina sa lahat ng kliyente sa aking transaksyon.',
            'english' => 'I feel the office was fair to everyone, or “walang palakasan”, during my transaction/s.',
            'label' => 'Integrity'
        ],
        'sqd7' => [
            'tagalog' => 'Magalang akong trinato at tinulungan ako ng kawani ng opisina sa aking transaksyon.',
            'english' => 'The BFAR staff I transacted with was courteous, approachable, and well-informed.',
            'label' => 'Assurance'
        ],
        'sqd8' => [
            'tagalog' => 'Nakuha ko ang kinakailangan ko mula sa tanggapan na ito at kung meron mang hindi natugunan, ito ay ipinaliwanag nang malinaw sa akin.',
            'english' => 'I got what I needed from the Bureau, or denial of request/s was sufficiently explained to me.',
            'label' => 'Outcome'
        ],
    ];

    $ratings = [
        1 => '☹',
        2 => '🙁',
        3 => '😐',
        4 => '🙂',
        5 => '😀',
    ];
@endphp

<div class="container-fluid">



    @if($errors->any())
        <div class="alert alert-danger no-print">
            <strong>Naay error:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $actionUrl }}">
        @csrf

        <input type="hidden"
               name="language_version"
               id="language_version"
               value="{{ old('language_version', $survey->language_version ?? 'tagalog') }}">

        <div class="survey-wrapper">
            <div class="survey-paper">

                <table class="header-table">
                    <tr>
                        <td style="width: 130px; text-align:right;">
                            <img src="{{ asset('assets/images/bfarlogo.png') }}"
                                 class="bfar-logo"
                                 onerror="this.style.display='none'">
                        </td>
                        <td class="header-title">
                            <div>Republic of the Philippines</div>
                            <div>Department of Agriculture</div>
                            <div class="big">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
                        </td>
                    </tr>
                </table>

                <div class="top-control-row">
                    <div>
                        <span data-lang-key="control_no">Control No:</span>
                        <input type="text"
                               name="control_no"
                               class="line-input"
                               value="{{ old('control_no', $survey->control_no ?? '') }}">
                    </div>

                    <button type="button" id="languageToggle" class="version-btn">
                        English version
                    </button>
                </div>

                <div class="client-box">
                    <div class="client-row">
                        <strong data-lang-key="office_visited">Pinuntahang opisina:</strong>
                        <input type="text"
                               name="pinuntahang_opisina"
                               class="line-input"
                               style="width:260px;"
                               value="{{ old('pinuntahang_opisina', $survey->pinuntahang_opisina ?? '') }}">

                        <strong data-lang-key="service_availed">Serbisyong natanggap:</strong>
                        <input type="text"
                               name="serbisyong_natanggap"
                               class="line-input"
                               style="width:260px;"
                               value="{{ old('serbisyong_natanggap', $survey->serbisyong_natanggap ?? '') }}">
                    </div>

                    <div class="client-row">
                        <strong data-lang-key="client_type">Uri ng kliyente:</strong>

                        <label>
                            <input type="radio" name="uri_ng_kliyente" value="Mamamayan"
                                {{ checkedRadio($survey, 'uri_ng_kliyente', 'Mamamayan') }}>
                            <span data-lang-key="citizen">Mamamayan</span>
                        </label>

                        <label>
                            <input type="radio" name="uri_ng_kliyente" value="Negosyo"
                                {{ checkedRadio($survey, 'uri_ng_kliyente', 'Negosyo') }}>
                            <span data-lang-key="business">Negosyo</span>
                        </label>

                        <label>
                            <input type="radio" name="uri_ng_kliyente" value="Gobyerno"
                                {{ checkedRadio($survey, 'uri_ng_kliyente', 'Gobyerno') }}>
                            <span data-lang-key="government">Gobyerno (Empleyado o ibang ahensya)</span>
                        </label>
                    </div>

                    <div class="client-row">
                        <strong data-lang-key="are_you">Ikaw ba ay:</strong>

                        <label>
                            <input type="radio" name="ikaw_ba_ay" value="Kliyente sa labas ng kawanihan"
                                {{ checkedRadio($survey, 'ikaw_ba_ay', 'Kliyente sa labas ng kawanihan') }}>
                            <span data-lang-key="external_client">Kliyente sa labas ng kawanihan</span>
                        </label>

                        <label>
                            <input type="radio" name="ikaw_ba_ay" value="Empleyado ng BFAR"
                                {{ checkedRadio($survey, 'ikaw_ba_ay', 'Empleyado ng BFAR') }}>
                            <span data-lang-key="internal_client">Empleyado ng BFAR</span>
                        </label>
                    </div>

                    <div class="client-row">
                        <strong data-lang-key="date">Petsa:</strong>
                        <input type="date"
                               name="petsa"
                               class="line-input"
                               style="width:150px;"
                               value="{{ old('petsa', $survey->petsa ?? '') }}">

                        <strong data-lang-key="sex">Kasarian:</strong>

                        <label>
                            <input type="radio" name="kasarian" value="Lalaki"
                                {{ checkedRadio($survey, 'kasarian', 'Lalaki') }}>
                            <span data-lang-key="male">Lalaki</span>
                        </label>

                        <label>
                            <input type="radio" name="kasarian" value="Babae"
                                {{ checkedRadio($survey, 'kasarian', 'Babae') }}>
                            <span data-lang-key="female">Babae</span>
                        </label>

                        <strong data-lang-key="age">Edad:</strong>
                        <input type="number"
                               name="edad"
                               class="line-input-sm"
                               value="{{ old('edad', $survey->edad ?? '') }}">
                    </div>

                    <div class="client-row">
                        <strong data-lang-key="region">Rehiyon ng tirahan:</strong>
                        <input type="text"
                               name="rehiyon_ng_tirahan"
                               class="line-input"
                               style="width:300px;"
                               value="{{ old('rehiyon_ng_tirahan', $survey->rehiyon_ng_tirahan ?? '') }}">
                    </div>
                </div>

                <div class="cc-section">
                    <span data-lang-key="cc_instruction">
                        Lagyan ng tsek <strong>(✓)</strong> ang iyong sagot sa mga sumusunod na katanungan tungkol sa
                        <strong>Citizen’s Charter (CC):</strong>
                    </span>

                    <div>
                        <strong>CC1</strong>
                        <span data-lang-key="cc1_question">Alin sa mga sumusunod ang higit na naglalarawan ng iyong kaalaman sa CC?</span>
                    </div>

                    <div class="cc-indent">
                        <label>
                            <input type="checkbox" name="cc1_alam_ko_ang_cc" value="1"
                                {{ checkedBox($survey, 'cc1_alam_ko_ang_cc') }}>
                            <span data-lang-key="cc1_a">Alam ko kung ano ang CC at nakita ko ito sa napuntahang opisina.</span>
                        </label><br>

                        <label>
                            <input type="checkbox" name="cc1_alam_ko_hindi_ko_nakita" value="1"
                                {{ checkedBox($survey, 'cc1_alam_ko_hindi_ko_nakita') }}>
                            <span data-lang-key="cc1_b">Alam ko kung ano ang CC subalit HINDI ko ito nakita sa napuntahang opisina.</span>
                        </label><br>

                        <label>
                            <input type="checkbox" name="cc1_nalaman_ko_lang_ngayon" value="1"
                                {{ checkedBox($survey, 'cc1_nalaman_ko_lang_ngayon') }}>
                            <span data-lang-key="cc1_c">Nalaman ko lang ang CC ng makita ko ito sa napuntahang opisina.</span>
                        </label><br>

                        <label>
                            <input type="checkbox" name="cc1_hindi_ko_alam" value="1"
                                {{ checkedBox($survey, 'cc1_hindi_ko_alam') }}>
                            <span data-lang-key="cc1_d">Hindi ko alam kung ano ang CC at wala akong nakita sa napuntahang opisina.</span>
                        </label>
                    </div>

                    <div>
                        <strong>CC2</strong>
                        <span data-lang-key="cc2_question">Kung alam mo ang CC, masasabi mo ba na ang CC ng napuntahang opisina ay...?</span>
                    </div>

                    <div class="cc-indent">
                        <label>
                            <input type="radio" name="cc2_visibility" value="Madaling makita"
                                {{ checkedRadio($survey, 'cc2_visibility', 'Madaling makita') }}>
                            <span data-lang-key="easy_to_see">Madaling makita</span>
                        </label>

                        <label class="ms-3">
                            <input type="radio" name="cc2_visibility" value="Medyo madaling makita"
                                {{ checkedRadio($survey, 'cc2_visibility', 'Medyo madaling makita') }}>
                            <span data-lang-key="somewhat_easy">Medyo madaling makita</span>
                        </label>

                        <label class="ms-3">
                            <input type="radio" name="cc2_visibility" value="Mahirap makita"
                                {{ checkedRadio($survey, 'cc2_visibility', 'Mahirap makita') }}>
                            <span data-lang-key="difficult_to_see">Mahirap makita</span>
                        </label><br>

                        <label>
                            <input type="radio" name="cc2_visibility" value="Hindi makita"
                                {{ checkedRadio($survey, 'cc2_visibility', 'Hindi makita') }}>
                            <span data-lang-key="not_visible">Hindi makita</span>
                        </label>

                        <label class="ms-3">
                            <input type="radio" name="cc2_visibility" value="Hindi angkop"
                                {{ checkedRadio($survey, 'cc2_visibility', 'Hindi angkop') }}>
                            <span data-lang-key="na_text">Hindi angkop</span>
                        </label>
                    </div>

                    <div>
                        <strong>CC3</strong>
                        <span data-lang-key="cc3_question">Kung alam mo ang CC, gaano nakatulong ang CC sa transaksyon mo?</span>
                    </div>

                    <div class="cc-indent">
                        <label>
                            <input type="radio" name="cc3_helpfulness" value="Sobrang nakatulong"
                                {{ checkedRadio($survey, 'cc3_helpfulness', 'Sobrang nakatulong') }}>
                            <span data-lang-key="helped_much">Sobrang nakatulong</span>
                        </label>

                        <label class="ms-3">
                            <input type="radio" name="cc3_helpfulness" value="Medyo nakatulong"
                                {{ checkedRadio($survey, 'cc3_helpfulness', 'Medyo nakatulong') }}>
                            <span data-lang-key="somewhat_helped">Medyo nakatulong</span>
                        </label>

                        <label class="ms-3">
                            <input type="radio" name="cc3_helpfulness" value="Hindi nakatulong"
                                {{ checkedRadio($survey, 'cc3_helpfulness', 'Hindi nakatulong') }}>
                            <span data-lang-key="did_not_help">Hindi nakatulong</span>
                        </label><br>

                        <label>
                            <input type="radio" name="cc3_helpfulness" value="Hindi angkop"
                                {{ checkedRadio($survey, 'cc3_helpfulness', 'Hindi angkop') }}>
                            <span data-lang-key="na_text_2">Hindi angkop</span>
                        </label>
                    </div>
                </div>

                <div class="survey-table-responsive">
                    <table class="survey-table">
                        <thead>
                            <tr>
                                <th class="question-col">
                                    <div style="font-size:18px;" data-lang-key="survey_dimension">Survey Questions Dimension</div>
                                    <div class="small-note" data-lang-key="survey_instruction">
                                        Lagyan ng tsek (✓) ang hanay na pinakaangkop sa iyong sagot.
                                        <strong>(5 ang pinakamataas na puntos)</strong>
                                    </div>
                                </th>

                                @foreach($ratings as $rate => $emoji)
                                    <th class="rate-col">
                                        <span class="emoji">{{ $emoji }}</span>
                                        <strong style="font-size:20px;">{{ $rate }}</strong>
                                    </th>
                                @endforeach

                                <th class="rate-col" data-lang-key="na_header">
                                    Hindi<br>angkop
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($questions as $field => $question)
                                <tr>
                                    <td class="question-col">
                                        <strong>{{ strtoupper($field) }}.</strong>
                                        <span class="question-text"
                                              data-field="{{ $field }}"
                                              data-tagalog="{{ $question['tagalog'] }}"
                                              data-english="{{ $question['english'] }}">
                                            {{ $question['tagalog'] }}
                                        </span>

                                        @if(isset($question['label']))
                                            <em><strong>({{ $question['label'] }})</strong></em>
                                        @endif
                                    </td>

                                    @foreach([1, 2, 3, 4, 5] as $rate)
                                        <td class="text-center">
                                            <input type="radio"
                                                   class="rating-radio"
                                                   name="{{ $field }}"
                                                   value="{{ $rate }}"
                                                   {{ checkedRadio($survey, $field, $rate) }}>
                                        </td>
                                    @endforeach

                                    <td class="text-center">
                                        <input type="radio"
                                               class="rating-radio"
                                               name="{{ $field }}"
                                               value="0"
                                               {{ checkedRadio($survey, $field, 0) }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="comment-lines mt-2">
                    <strong>
                        <em data-lang-key="comment_label">
                            Mga mungkahi o komento kung papaano namin mapapabuti pa ang aming mga serbisyo:
                        </em>
                    </strong>

                    <textarea name="mungkahi_komento">{{ old('mungkahi_komento', $survey->mungkahi_komento ?? '') }}</textarea>
                </div>

                <div class="footer-code">
                    BFAR-F-01<br>
                    Rev. No. 05<br>
                    Effectivity Date: 08.03.23
                </div>

            </div>
        </div>

        <div class="action-area no-print">
            <a href="/kiosk" class="btn btn-secondary">
                Cancel
            </a>

            @if($isEdit)
                <button type="submit" class="btn btn-success">
                    Update Survey
                </button>
            @else
                <button type="submit" class="btn btn-primary">
                    Save Survey
                </button>
            @endif
        </div>
    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentLang = document.getElementById('language_version').value || 'tagalog';

        const translations = {
            tagalog: {
                button: 'English version',
                control_no: 'Control No:',
                office_visited: 'Pinuntahang opisina:',
                service_availed: 'Serbisyong natanggap:',
                client_type: 'Uri ng kliyente:',
                citizen: 'Mamamayan',
                business: 'Negosyo',
                government: 'Gobyerno (Empleyado o ibang ahensya)',
                are_you: 'Ikaw ba ay:',
                external_client: 'Kliyente sa labas ng kawanihan',
                internal_client: 'Empleyado ng BFAR',
                date: 'Petsa:',
                sex: 'Kasarian:',
                male: 'Lalaki',
                female: 'Babae',
                age: 'Edad:',
                region: 'Rehiyon ng tirahan:',
                cc_instruction: 'Lagyan ng tsek <strong>(✓)</strong> ang iyong sagot sa mga sumusunod na katanungan tungkol sa <strong>Citizen’s Charter (CC):</strong>',
                cc1_question: 'Alin sa mga sumusunod ang higit na naglalarawan ng iyong kaalaman sa CC?',
                cc1_a: 'Alam ko kung ano ang CC at nakita ko ito sa napuntahang opisina.',
                cc1_b: 'Alam ko kung ano ang CC subalit HINDI ko ito nakita sa napuntahang opisina.',
                cc1_c: 'Nalaman ko lang ang CC ng makita ko ito sa napuntahang opisina.',
                cc1_d: 'Hindi ko alam kung ano ang CC at wala akong nakita sa napuntahang opisina.',
                cc2_question: 'Kung alam mo ang CC, masasabi mo ba na ang CC ng napuntahang opisina ay...?',
                easy_to_see: 'Madaling makita',
                somewhat_easy: 'Medyo madaling makita',
                difficult_to_see: 'Mahirap makita',
                not_visible: 'Hindi makita',
                na_text: 'Hindi angkop',
                na_text_2: 'Hindi angkop',
                cc3_question: 'Kung alam mo ang CC, gaano nakatulong ang CC sa transaksyon mo?',
                helped_much: 'Sobrang nakatulong',
                somewhat_helped: 'Medyo nakatulong',
                did_not_help: 'Hindi nakatulong',
                survey_dimension: 'Survey Questions Dimension',
                survey_instruction: 'Lagyan ng tsek (✓) ang hanay na pinakaangkop sa iyong sagot. <strong>(5 ang pinakamataas na puntos)</strong>',
                na_header: 'Hindi<br>angkop',
                comment_label: 'Mga mungkahi o komento kung papaano namin mapapabuti pa ang aming mga serbisyo:'
            },
            english: {
                button: 'Tagalog version',
                control_no: 'Control No:',
                office_visited: 'Office/s visited:',
                service_availed: 'Service/s availed:',
                client_type: 'Type of Client:',
                citizen: 'Citizen',
                business: 'Business',
                government: 'Government (Employee or another agency)',
                are_you: 'Are you:',
                external_client: 'External Client',
                internal_client: 'Internal Client',
                date: 'Date:',
                sex: 'Sex:',
                male: 'Male',
                female: 'Female',
                age: 'Age:',
                region: 'Region of Residence:',
                cc_instruction: 'Check mark <strong>(✓)</strong> your answer to the <strong>Citizen’s Charter (CC)</strong> questions:',
                cc1_question: 'Which of the following best describes your awareness of a CC?',
                cc1_a: 'I know what a CC is and I saw this office’s CC.',
                cc1_b: 'I know what a CC is but I did NOT see this office’s CC.',
                cc1_c: 'I learned of the CC only when I saw this office’s CC.',
                cc1_d: 'I do not know what a CC is and I did not see one in this office.',
                cc2_question: 'If aware of CC, would you say that the CC of this office was...?',
                easy_to_see: 'Easy to see',
                somewhat_easy: 'Somewhat easy to see',
                difficult_to_see: 'Difficult to see',
                not_visible: 'Not visible at all',
                na_text: 'N/A',
                na_text_2: 'N/A',
                cc3_question: 'If aware of CC, how much did the CC help you in your transaction?',
                helped_much: 'Helped very much',
                somewhat_helped: 'Somewhat helped',
                did_not_help: 'Did not help',
                survey_dimension: 'Survey Questions Dimension',
                survey_instruction: 'Please put a check mark (✓) on the column that best corresponds to your answer. <strong>(5 is the highest rating)</strong>',
                na_header: 'N/A',
                comment_label: 'Suggestion/s or comment/s on how we can further improve our services:'
            }
        };

        function switchLanguage(lang) {
            Object.keys(translations[lang]).forEach(function (key) {
                const el = document.querySelector('[data-lang-key="' + key + '"]');
                if (el) {
                    el.innerHTML = translations[lang][key];
                }
            });

            document.querySelectorAll('.question-text').forEach(function (el) {
                el.innerText = el.dataset[lang];
            });

            document.getElementById('languageToggle').innerText = translations[lang].button;
            document.getElementById('language_version').value = lang;
        }

        switchLanguage(currentLang);

        document.getElementById('languageToggle').addEventListener('click', function () {
            currentLang = currentLang === 'tagalog' ? 'english' : 'tagalog';
            switchLanguage(currentLang);
        });
    });
</script>
<footer class="footer">
          <div class="footer-body">
              <ul class="left-panel list-inline mb-0 p-0">
                  <li class="list-inline-item"><a href="../dashboard/extra/privacy-policy.html">Privacy Policy</a></li>
                  <li class="list-inline-item"><a href="../dashboard/extra/terms-of-service.html">Terms of Use</a></li>
              </ul>
              <div class="right-panel">
                  ©<script>document.write(new Date().getFullYear())</script> LIMS - GENSAN CITY
                  <span class="">
                      <svg class="icon-15" width="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M15.85 2.50065C16.481 2.50065 17.111 2.58965 17.71 2.79065C21.401 3.99065 22.731 8.04065 21.62 11.5806C20.99 13.3896 19.96 15.0406 18.611 16.3896C16.68 18.2596 14.561 19.9196 12.28 21.3496L12.03 21.5006L11.77 21.3396C9.48102 19.9196 7.35002 18.2596 5.40102 16.3796C4.06102 15.0306 3.03002 13.3896 2.39002 11.5806C1.26002 8.04065 2.59002 3.99065 6.32102 2.76965C6.61102 2.66965 6.91002 2.59965 7.21002 2.56065H7.33002C7.61102 2.51965 7.89002 2.50065 8.17002 2.50065H8.28002C8.91002 2.51965 9.52002 2.62965 10.111 2.83065H10.17C10.21 2.84965 10.24 2.87065 10.26 2.88965C10.481 2.96065 10.69 3.04065 10.89 3.15065L11.27 3.32065C11.3618 3.36962 11.4649 3.44445 11.554 3.50912C11.6104 3.55009 11.6612 3.58699 11.7 3.61065C11.7163 3.62028 11.7329 3.62996 11.7496 3.63972C11.8354 3.68977 11.9247 3.74191 12 3.79965C13.111 2.95065 14.46 2.49065 15.85 2.50065ZM18.51 9.70065C18.92 9.68965 19.27 9.36065 19.3 8.93965V8.82065C19.33 7.41965 18.481 6.15065 17.19 5.66065C16.78 5.51965 16.33 5.74065 16.18 6.16065C16.04 6.58065 16.26 7.04065 16.68 7.18965C17.321 7.42965 17.75 8.06065 17.75 8.75965V8.79065C17.731 9.01965 17.8 9.24065 17.94 9.41065C18.08 9.58065 18.29 9.67965 18.51 9.70065Z" fill="currentColor"></path>
                      </svg>
                  </span><a href="https://iqonic.design/"> Designed by OBX SOLUTIONS TECHNOLOGY INC.</a>
              </div>
          </div>
      </footer>
      <!-- Footer Section End -->   
     </main>
  
    <script>
      $(document).on('click', '[data-setting]', function () {
      let data = {
          _token: $('meta[name="csrf-token"]').attr('content'),
          color_mode: $('[data-setting="color-mode"].active').data('value'),
          theme_color: $('[data-setting="color-mode1"].active').data('value'),
          sidebar_color: $('[data-name="sidebar-color"].active').data('value'),
          sidebar_type: $('[data-name="sidebar-type"].active').data('value'),
          sidebar_item: $('[data-name="sidebar-item"].active').data('value'),
          navbar_type: $('[data-name="navbar-type"].active').data('value'),
      };

      $.ajax({
          url: '/save-settings',
          type: 'POST',
          data: data,
          success: function (res) {
              console.log('Settings saved');
          }
      });
  });

    </script>
    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="/assets/js/core/libs.min.js"></script>
    <script src="/assets/js/core/external.min.js"></script>
    <script src="/assets/js/charts/widgetcharts.js"></script>
    <script src="/assets/js/charts/vectore-chart.js"></script>
    <script src="/assets/js/charts/dashboard.js" ></script>
    <script src="/assets/js/plugins/fslightbox.js"></script>
    <script src="/assets/js/plugins/setting.js"></script>
    <script src="/assets/js/plugins/slider-tabs.js"></script>
    <script src="/assets/js/plugins/form-wizard.js"></script>
    <script src="/assets/vendor/aos/dist/aos.js"></script>
    <script src="/assets/js/hope-ui.js" defer></script>
  </body>
</html>
