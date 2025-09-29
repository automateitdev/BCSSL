@php
    ini_set('memory_limit', '1024M');
    $date = date('d/m/y');
    $i = 0;
    $data = json_decode($data, true);

    // $data = [1,2,3,4,5,6,7,8,10]
    $signs = json_decode($signs, true);

    $needed_signs = [];
    foreach ($signs as $key => $value) {
        if ($value['title'] == 'secretary') {
            $needed_signs['secretary'] = $value;
        }
        if ($value['title'] == 'chairman') {
            $needed_signs['president'] = $value;
        }
    }
@endphp

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4 landscape;
            margin: 30px;
        }

        body {
            background-color: azure;
        }

        table {
            border-collapse: collapse;
            display: inline-table;
        }

        table>tr>td {
            margin-right: 40px;
        }

        * {
            font-family: DejaVu Serif;
            font-size: 1rem;
        }

        table tr td {
            color: black;
            border-color: black !important;
        }

        .pagebreak {
            page-break-inside: avoid;
        }

        .center {
            display: flex;
            justify-content: center;
            /* Corrected closing quotes and semicolon */
        }

        span.dotted_line {
            border-bottom: 1px dotted #000;
            padding: 0 40px;
            font-weight: bold;
        }

        /* span.dotted_line:after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            width: 100%;
            height: 1px;
            border-bottom: 1px solid saddlebrown;
        } */

        @font-face {
            font-family: "DejaVu Serif";
            font-style: normal;
            font-weight: normal;
            src: asset('fonts/DejaVuSans.ttf') format('truetype');
        }
    </style>
</head>

<body>
    @forelse ($data as $member)
        <main
            style="
        background-color: #fffaf1;
        position: relative;
        background-image: url('data:image/jpeg;base64,{{ base64_encode(file_get_contents(storage_path('app/public/images/border_design.jpeg'))) }}');
        background-size: contain; /* Adjust the background size here */
        background-repeat: no-repeat; /* Ensure the background does not repeat */
        background-color: white;
        background-position:center center;
      ">
            <div style="
          width: 100%;
          height: 100%;
          margin: 0 auto;
        ">
                <div style="">
                    <div style="position:relative">

                        <div style="position:absolute; top:130px; left:8%; display: inline-block; width: 180px; height: 180px"
                            class="center">
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/images/logo.jpeg'))) }}"
                                alt="" style="width: 100%; height: auto">
                        </div>
                        <div
                            style="display: inline-block; width: 100%; margin:0 auto; margin-top:120px; text-align:center">
                            <h1 style="font-size: 1.2rem; text-transform: capitalize">
                                {{ config('app.title') }}
                            </h1>
                            <div
                                style="
                                width: 100%;
                                text-align:center;
                            ">
                                <p style="margin:0 auto"><span>Registration No:01/2023</span> <span
                                        style="margin-left: 40px">Date:23/02/23</span></p>

                            </div>
                            <p
                                style="
                            width: 100%;
                            text-align:center;
                            margin-top:0;
                            ">
                                E-mail:
                            </p>
                            <div class="center">
                                <div
                                    style="width:20%; margin:10px auto; color:#fff; background-color:darkblue; padding:10px 30px; border-radius:10px">
                                    <h1 style="font-size: 1rem; text-align: center; text-transform:uppercase">
                                        Share Certificate
                                    </h1>
                                </div>
                            </div>
                            <div style="text-align: center">
                                <p style="font-style:italic; font-weight:bold; margin-bottom:0">
                                    Registered Under Co-operative society act 2001 (amendment 2002
                                    & 2013)
                                </p>
                            </div>
                            <div
                                style="
                                width: 100%;
                                margin:0 auto;
                                text-align: center;
                                ">
                                <p style="margin-top:0; font-weight:bold">
                                    Authorized capital taka 10000000.00 (One Crore) and divided into 10000.00 (Ten
                                    Thousand)
                                    shares.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="" style="">
                    <p style="width:85%; margin:0 auto; text-align: justify; font-style: italic;">
                        This is to certify {{ $member['gender'] == 'male' ? 'Mr.' : '' }}
                        {{ $member['gender'] == 'female' ? 'Mrs.' : '' }} {{ $member['gender'] == 'others' ? '-' : '' }}
                        <span class="dotted_line">{{ $member['name'] }}</span> Father <span
                            class="dotted_line">{{ $member['father_name'] }}</span> BCS batch and Cadre <span
                            class="dotted_line">{{ $member['bcs_batch'] }}</span> Permanent address <span
                            class="dotted_line">{{ $member['permanent_address'] }}</span>. As per Co-Operative Society
                        Act, Rules & Registered Bye law {{ $member['gender'] == 'male' ? 'he' : '' }}
                        {{ $member['gender'] == 'female' ? 'sh' : '' }} {{ $member['gender'] == 'others' ? '-' : '' }}
                        is entitled <span class="dotted_line">{{ $member['associators_info']['num_or_shares'] }}</span>
                        share of taka 1000/- (One Thousand) of {{ config('app.short_code') }} {{ $member['gender'] == 'male' ? 'His' : '' }}
                        {{ $member['gender'] == 'female' ? 'Her' : '' }} {{ $member['gender'] == 'others' ? '-' : '' }} Member
                        ID is <span class="dotted_line">{{ $member['associators_info']['membershp_number'] }}</span>
                    </p>
                </div>


                <div style="position: absolute; bottom: 15%; left:50%; transform:translateX(-50%)">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/images/logo.jpeg'))) }}"
                        alt="" style="width: 550px; opacity: 10%; margin: auto ">
                </div>


                <table style="width: 85%; border-collapse:collapse; position:absolute; bottom:200px; left:50%; transform:translateX(-50%)">
                    <tbody>
                        <tr>
                            <td style="text-align: left">
                                <div style="margin-bottom:10px"></div>
                                <span style="border-top: 1px solid black; padding:10px">Seal</span>
                            </td>
                            <td style="text-align: center">
                                <div style="margin-bottom:10px">
                                @if (array_key_exists('secretary', $needed_signs))
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $needed_signs['secretary']['file_location']))) }}"
                                    alt="" style="width: 100px; height:auto; display:block, margin:0 auto">
                                @endif
                                </div>
                                <span style="border-top: 1px solid black; padding:10px">Secretary</span>
                            </td>
                            <td style="text-align: right">
                                <div style="margin-bottom:10px">
                                @if (array_key_exists('president', $needed_signs))
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $needed_signs['president']['file_location']))) }}"
                                    alt="" style="width: 100px; height:auto; display:block, margin:0 auto">
                                @endif
                                </div>
                                <span style="border-top: 1px solid black; padding:10px">President</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    @empty
        <p>No Member Chosen</p>
    @endforelse
</body>
