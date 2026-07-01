<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Citizen Charter Survey</title>

    <style>
        @page {
            margin: 18px 18px 18px 18px;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11.5px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .paper {
            width: 100%;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .header-table td {
            border: none;
            vertical-align: top;
        }

        .logo {
            width: 110px;
            height: auto;
        }

        .header-title {
            font-size: 15px;
            line-height: 1.08;
        }

        .big {
            font-size: 17px;
            color: #154a8b;
            font-weight: bold;
        }

        .version-box {
            border: 1px solid #000;
            padding: 7px 15px;
            font-weight: bold;
            text-align: center;
            width: 135px;
            float: right;
        }

        .client-box {
            border: 1px solid #000;
            padding: 8px;
            margin-top: 10px;
            margin-bottom: 12px;
            line-height: 1.35;
        }

        .line {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 130px;
            padding: 0 4px;
            min-height: 12px;
        }

        .line-sm {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 60px;
            padding: 0 4px;
            min-height: 12px;
        }

        .check {
            font-family: DejaVu Sans, sans-serif;
        }

        .cc-indent {
            margin-left: 40px;
        }

        .survey-table {
            margin-top: 10px;
        }

        .survey-table th,
        .survey-table td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
        }

        .question-col {
            width: 60%;
            line-height: 1.08;
        }

        .rate-col {
            width: 6.66%;
            text-align: center;
        }

        .face-wrap {
            text-align: center;
        }

        .face-svg {
            width: 28px;
            height: 28px;
            display: block;
            margin: 0 auto 2px auto;
        }

        .rate-number {
            font-size: 16px;
            font-weight: bold;
            line-height: 1;
        }

        .small-note {
            font-size: 10.5px;
            font-style: italic;
            line-height: 1.1;
        }

        .selected-mark {
            font-family: DejaVu Sans, sans-serif;
            font-size: 18px;
            font-weight: bold;
            line-height: 1;
        }

        .comment-line {
            border-bottom: 1px solid #000;
            min-height: 20px;
            padding-top: 3px;
        }

        .footer {
            text-align: right;
            margin-top: 14px;
            line-height: 1.2;
        }
    </style>
</head>
<body>

@php
    $lang = $survey->language_version ?? 'tagalog';

    if (!function_exists('boxCheckPdf')) {
        function boxCheckPdf($condition) {
            return $condition ? '☑' : '☐';
        }
    }

    if (!function_exists('rateCheckPdf')) {
        function rateCheckPdf($value, $rate) {
            return (string)$value === (string)$rate ? '✓' : '';
        }
    }

    if (!function_exists('faceSvgPdf')) {
        function faceSvgPdf($level) {
            $mouth = '';

            switch ($level) {
                case 1:
                    $mouth = '<path d="M9 22 Q16 14 23 22" stroke="#000" stroke-width="2" fill="none" stroke-linecap="round"/>';
                    break;
                case 2:
                    $mouth = '<path d="M9 21 Q16 17 23 21" stroke="#000" stroke-width="2" fill="none" stroke-linecap="round"/>';
                    break;
                case 3:
                    $mouth = '<line x1="10" y1="20" x2="22" y2="20" stroke="#000" stroke-width="2" stroke-linecap="round"/>';
                    break;
                case 4:
                    $mouth = '<path d="M9 19 Q16 23 23 19" stroke="#000" stroke-width="2" fill="none" stroke-linecap="round"/>';
                    break;
                case 5:
                    $mouth = '<path d="M8 18 Q16 26 24 18" stroke="#000" stroke-width="2" fill="none" stroke-linecap="round"/>';
                    break;
            }

            return '
                <svg class="face-svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="16" cy="16" r="14" fill="none" stroke="#000" stroke-width="2"/>
                    <circle cx="11" cy="12" r="1.5" fill="#000"/>
                    <circle cx="21" cy="12" r="1.5" fill="#000"/>
                    ' . $mouth . '
                </svg>
            ';
        }
    }

    $t = [
        'tagalog' => [
            'version' => 'Tagalog version',
            'control_no' => 'Control No:',
            'office_visited' => 'Pinuntahang opisina:',
            'service_availed' => 'Serbisyong natanggap:',
            'client_type' => 'Uri ng kliyente:',
            'citizen' => 'Mamamayan',
            'business' => 'Negosyo',
            'government' => 'Gobyerno (Empleyado o ibang ahensya)',
            'are_you' => 'Ikaw ba ay:',
            'external_client' => 'Kliyente sa labas ng kawanihan',
            'internal_client' => 'Empleyado ng BFAR',
            'date' => 'Petsa:',
            'sex' => 'Kasarian:',
            'male' => 'Lalaki',
            'female' => 'Babae',
            'age' => 'Edad:',
            'region' => 'Rehiyon ng tirahan:',
            'cc_instruction' => 'Lagyan ng tsek <strong>(✓)</strong> ang iyong sagot sa mga sumusunod na katanungan tungkol sa <strong>Citizen’s Charter (CC):</strong>',
            'cc1_question' => 'Alin sa mga sumusunod ang higit na naglalarawan ng iyong kaalaman sa CC?',
            'cc1_a' => 'Alam ko kung ano ang CC at nakita ko ito sa napuntahang opisina.',
            'cc1_b' => 'Alam ko kung ano ang CC subalit HINDI ko ito nakita sa napuntahang opisina.',
            'cc1_c' => 'Nalaman ko lang ang CC ng makita ko ito sa napuntahang opisina.',
            'cc1_d' => 'Hindi ko alam kung ano ang CC at wala akong nakita sa napuntahang opisina.',
            'cc2_question' => 'Kung alam mo ang CC, masasabi mo ba na ang CC ng napuntahang opisina ay...?',
            'easy_to_see' => 'Madaling makita',
            'somewhat_easy' => 'Medyo madaling makita',
            'difficult_to_see' => 'Mahirap makita',
            'not_visible' => 'Hindi makita',
            'na_text' => 'Hindi angkop',
            'cc3_question' => 'Kung alam mo ang CC, gaano nakatulong ang CC sa transaksyon mo?',
            'helped_much' => 'Sobrang nakatulong',
            'somewhat_helped' => 'Medyo nakatulong',
            'did_not_help' => 'Hindi nakatulong',
            'survey_dimension' => 'Survey Questions Dimension',
            'survey_instruction' => 'Lagyan ng tsek (✓) ang hanay na pinakaangkop sa iyong sagot. <strong>(5 ang pinakamataas na puntos)</strong>',
            'na_header' => 'Hindi<br>angkop',
            'comment_label' => 'Mga mungkahi o komento kung papaano namin mapapabuti pa ang aming mga serbisyo:',
            'footer_code' => 'BFAR-F-01a',
            'rev_no' => 'Rev. No. 01',
        ],
        'english' => [
            'version' => 'English version',
            'control_no' => 'Control No:',
            'office_visited' => 'Office/s visited:',
            'service_availed' => 'Service/s availed:',
            'client_type' => 'Type of Client:',
            'citizen' => 'Citizen',
            'business' => 'Business',
            'government' => 'Government (Employee or another agency)',
            'are_you' => 'Are you:',
            'external_client' => 'External Client',
            'internal_client' => 'Internal Client',
            'date' => 'Date:',
            'sex' => 'Sex:',
            'male' => 'Male',
            'female' => 'Female',
            'age' => 'Age:',
            'region' => 'Region of Residence:',
            'cc_instruction' => 'Check mark <strong>(✓)</strong> your answer to the <strong>Citizen’s Charter (CC)</strong> questions:',
            'cc1_question' => 'Which of the following best describes your awareness of a CC?',
            'cc1_a' => 'I know what a CC is and I saw this office’s CC.',
            'cc1_b' => 'I know what a CC is but I did NOT see this office’s CC.',
            'cc1_c' => 'I learned of the CC only when I saw this office’s CC.',
            'cc1_d' => 'I do not know what a CC is and I did not see one in this office.',
            'cc2_question' => 'If aware of CC, would you say that the CC of this office was...?',
            'easy_to_see' => 'Easy to see',
            'somewhat_easy' => 'Somewhat easy to see',
            'difficult_to_see' => 'Difficult to see',
            'not_visible' => 'Not visible at all',
            'na_text' => 'N/A',
            'cc3_question' => 'If aware of CC, how much did the CC help you in your transaction?',
            'helped_much' => 'Helped very much',
            'somewhat_helped' => 'Somewhat helped',
            'did_not_help' => 'Did not help',
            'survey_dimension' => 'Survey Questions Dimension',
            'survey_instruction' => 'Please put a check mark (✓) on the column that best corresponds to your answer. <strong>(5 is the highest rating)</strong>',
            'na_header' => 'N/A',
            'comment_label' => 'Suggestion/s or comment/s on how we can further improve our services:',
            'footer_code' => 'BFAR-F-01',
            'rev_no' => 'Rev. No. 05',
        ],
    ];

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
@endphp

<div class="paper">

    <table class="header-table">
        <tr>
            <td style="width: 125px; text-align:right;">
                <img src="{{ public_path('assets/images/bfarlogo.png') }}" class="logo">
            </td>
            <td class="header-title">
                <div>Republic of the Philippines</div>
                <div>Department of Agriculture</div>
                <div class="big">BUREAU OF FISHERIES AND AQUATIC RESOURCES</div>
            </td>
        </tr>
    </table>

    <div style="margin-top:5%">
        {{ $t[$lang]['control_no'] }}
        <span class="line">{{ $survey->control_no }}</span>

        <span class="version-box">
            {{ $t[$lang]['version'] }}
        </span>
    </div>

    <div style="clear: both;"></div>

    <div class="client-box">
        <strong>{{ $t[$lang]['office_visited'] }}</strong>
        <span class="line">{{ $survey->pinuntahang_opisina }}</span>

        <strong style="margin-left:15px;">{{ $t[$lang]['service_availed'] }}</strong>
        <span class="line">{{ $survey->serbisyong_natanggap }}</span>
        <br>

        <strong>{{ $t[$lang]['client_type'] }}</strong>

        <span class="check">{{ boxCheckPdf($survey->uri_ng_kliyente == 'Mamamayan') }}</span>
        {{ $t[$lang]['citizen'] }}

        <span class="check">{{ boxCheckPdf($survey->uri_ng_kliyente == 'Negosyo') }}</span>
        {{ $t[$lang]['business'] }}

        <span class="check">{{ boxCheckPdf($survey->uri_ng_kliyente == 'Gobyerno') }}</span>
        {{ $t[$lang]['government'] }}
        <br>

        <strong>{{ $t[$lang]['are_you'] }}</strong>

        <span class="check">{{ boxCheckPdf($survey->ikaw_ba_ay == 'Kliyente sa labas ng kawanihan') }}</span>
        {{ $t[$lang]['external_client'] }}

        <span class="check">{{ boxCheckPdf($survey->ikaw_ba_ay == 'Empleyado ng BFAR') }}</span>
        {{ $t[$lang]['internal_client'] }}
        <br>

        <strong>{{ $t[$lang]['date'] }}</strong>
        <span class="line-sm">{{ $survey->petsa }}</span>

        <strong>{{ $t[$lang]['sex'] }}</strong>

        <span class="check">{{ boxCheckPdf($survey->kasarian == 'Lalaki') }}</span>
        {{ $t[$lang]['male'] }}

        <span class="check">{{ boxCheckPdf($survey->kasarian == 'Babae') }}</span>
        {{ $t[$lang]['female'] }}

        <strong style="margin-left:15px;">{{ $t[$lang]['age'] }}</strong>
        <span class="line-sm">{{ $survey->edad }}</span>
        <br>

        <strong>{{ $t[$lang]['region'] }}</strong>
        <span class="line">{{ $survey->rehiyon_ng_tirahan }}</span>
    </div>

    <div>
        {!! $t[$lang]['cc_instruction'] !!}
    </div>

    <div>
        <strong>CC1</strong> {{ $t[$lang]['cc1_question'] }}
    </div>

    <div class="cc-indent check">
        {{ boxCheckPdf($survey->cc1_alam_ko_ang_cc) }} {{ $t[$lang]['cc1_a'] }}<br>
        {{ boxCheckPdf($survey->cc1_alam_ko_hindi_ko_nakita) }} {{ $t[$lang]['cc1_b'] }}<br>
        {{ boxCheckPdf($survey->cc1_nalaman_ko_lang_ngayon) }} {{ $t[$lang]['cc1_c'] }}<br>
        {{ boxCheckPdf($survey->cc1_hindi_ko_alam) }} {{ $t[$lang]['cc1_d'] }}
    </div>

    <div>
        <strong>CC2</strong> {{ $t[$lang]['cc2_question'] }}
    </div>

    <div class="cc-indent check">
        {{ boxCheckPdf($survey->cc2_visibility == 'Madaling makita') }} {{ $t[$lang]['easy_to_see'] }}
        {{ boxCheckPdf($survey->cc2_visibility == 'Medyo madaling makita') }} {{ $t[$lang]['somewhat_easy'] }}
        {{ boxCheckPdf($survey->cc2_visibility == 'Mahirap makita') }} {{ $t[$lang]['difficult_to_see'] }}
        {{ boxCheckPdf($survey->cc2_visibility == 'Hindi makita') }} {{ $t[$lang]['not_visible'] }}
        {{ boxCheckPdf($survey->cc2_visibility == 'Hindi angkop') }} {{ $t[$lang]['na_text'] }}
    </div>

    <div>
        <strong>CC3</strong> {{ $t[$lang]['cc3_question'] }}
    </div>

    <div class="cc-indent check">
        {{ boxCheckPdf($survey->cc3_helpfulness == 'Sobrang nakatulong') }} {{ $t[$lang]['helped_much'] }}
        {{ boxCheckPdf($survey->cc3_helpfulness == 'Medyo nakatulong') }} {{ $t[$lang]['somewhat_helped'] }}
        {{ boxCheckPdf($survey->cc3_helpfulness == 'Hindi nakatulong') }} {{ $t[$lang]['did_not_help'] }}
        {{ boxCheckPdf($survey->cc3_helpfulness == 'Hindi angkop') }} {{ $t[$lang]['na_text'] }}
    </div>

    <table class="survey-table">
        <thead>
            <tr>
                <th class="question-col">
                    <div style="font-size:16px;">{{ $t[$lang]['survey_dimension'] }}</div>
                    <div class="small-note">
                        {!! $t[$lang]['survey_instruction'] !!}
                    </div>
                </th>

                <th class="rate-col">
                    <div class="face-wrap">
                        {!! faceSvgPdf(1) !!}
                        <div class="rate-number">1</div>
                    </div>
                </th>

                <th class="rate-col">
                    <div class="face-wrap">
                        {!! faceSvgPdf(2) !!}
                        <div class="rate-number">2</div>
                    </div>
                </th>

                <th class="rate-col">
                    <div class="face-wrap">
                        {!! faceSvgPdf(3) !!}
                        <div class="rate-number">3</div>
                    </div>
                </th>

                <th class="rate-col">
                    <div class="face-wrap">
                        {!! faceSvgPdf(4) !!}
                        <div class="rate-number">4</div>
                    </div>
                </th>

                <th class="rate-col">
                    <div class="face-wrap">
                        {!! faceSvgPdf(5) !!}
                        <div class="rate-number">5</div>
                    </div>
                </th>

                <th class="rate-col">{!! $t[$lang]['na_header'] !!}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($questions as $field => $question)
                <tr>
                    <td class="question-col">
                        <strong>{{ strtoupper($field) }}.</strong>
                        {{ $question[$lang] }}

                        @if(isset($question['label']))
                            <em><strong>({{ $question['label'] }})</strong></em>
                        @endif
                    </td>

                    @foreach([1, 2, 3, 4, 5] as $rate)
                        <td class="rate-col">
                            <span class="selected-mark">{{ rateCheckPdf($survey->$field, $rate) }}</span>
                        </td>
                    @endforeach

                    <td class="rate-col">
                        <span class="selected-mark">{{ rateCheckPdf($survey->$field, 0) }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <strong><em>{{ $t[$lang]['comment_label'] }}</em></strong>
    <div class="comment-line">{{ $survey->mungkahi_komento }}</div>
    <div class="comment-line"></div>

    <div class="footer">
        {{ $t[$lang]['footer_code'] }}<br>
        {{ $t[$lang]['rev_no'] }}<br>
        Effectivity Date: 08.03.23
    </div>

</div>

</body>
</html>