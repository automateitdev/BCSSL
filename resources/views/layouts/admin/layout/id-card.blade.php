@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
            $needed_signs['chairman'] = $value;
        }
    }
@endphp

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4 portrait;
            margin: 5px;
        }

        body {
            margin: 0 auto;
            background-color: azure;
        }

        table {
            border-collapse: collapse;
            display: inline-table;
        }

        * {
            font-family: DejaVu Serif;
            font-size: .65rem;
        }

        .pagebreak {
            page-break-inside: avoid !important;
        }

        .center {
            display: flex;
            justify-content: center;
        }

        span.dotted_line {
            border-bottom: 1px dotted #000;
            padding: 0 40px;
            font-weight: bold;
        }

        .parent {
            font-size: 0;
        }

        .parent>.id-card {
            display: block;
            margin: 5px;
            width: 285.6px;
            height: 420.8px;
            position: relative;
            background-color: white;
            page-break-inside: avoid !important;
            float: left;
        }

        .id-card .logo {
            position: absolute;
            width: 40px;
            border-radius: 50%;
            top: 25px;
            left: 10px;
        }


        @font-face {
            font-family: "DejaVu Serif";
            font-style: normal;
            font-weight: normal;
            src: asset('fonts/DejaVuSans.ttf') format('truetype');
        }
    </style>
</head>

<body>
    <main class="parent">
        @forelse ($data as $key => $member)
            @if ($key != 0 && $key % 2 == 0)
                <div style="clear:both"></div>
            @endif

            @php
                $text = 'Established 2022, House No:738,Flat:2b, Ibrahimpur, Dhaka';
                $qr_code_infos = ['Member Email:' . $member['email']];

                foreach ($qr_code_infos as $qr_code_info) {
                    $text = $text . "\n" . $qr_code_info;
                }
            @endphp

            <div class="id-card front">
                <div style="position: relative; background-color:midnightblue; text-align:center; padding:10px 0">
                    <img class="logo"
                        src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/images/logo.jpeg'))) }}"
                        alt="">
                    <p style="width:65%; margin:10px auto; text-align:center; color:#fff; font-weight:bold, font-size:0.6rem">
                        বন্ধন চাকুরিজীবী সমবায় সমিতি লিমিটেড (BCSSL), </p>

                    <p style="width:60%; margin:0 auto; text-align:center; color:#fff; font-size:0.5rem">Registration no. 1
                        (Department of Cooperatives), Date 23.02.2023</p>
                    {{-- <table
                        style="width: 100%; color: #fff; text-align: center; border-collapse: collapse; margin: 0 auto;">
                        <tr>
                            <td style="padding:2px; font-size: 0.4rem; text-align: left; width: 50%;">

                            </td>
                            <td style="padding:2px; font-size: 0.4rem; text-align: right; width: 50%;">
                                Date 23.02.2023
                            </td>
                        </tr>
                    </table> --}}
                </div>
                <div style="text-align: center">
                    <label for=""
                        style="display:inline-block; color:white; font-weight: bold; font-style:italic; border-radius:5px; background-color:midnightblue; padding: 5px 15px; margin:10px auto">Identity
                        Card</label>
                </div>
                <div style="width: 100px; height:100px; overflow:hidden; margin:0 auto; background-color:whitesmoke">
                    @if (file_exists(storage_path('app/public/member/user/' . $member['image'])))
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/member/user/' . $member['image']))) }}"
                            alt="" style="width: 100%; height:auto">
                    @else
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/images/logo.jpeg'))) }}"
                            alt="" style="opacity:0; width: 100%; height:auto">
                    @endif
                </div>
                <p style="text-align: center; color:midnightblue; font-weight:bold; text-transform:capitalize">
                    {{ $member['name'] }}</p>

                <ul
                    style="list-style: none;
                margin:0 auto;
                margin-bottom:20px;
                padding:0">
                    <li style="text-transform: uppercase; padding:2px 20px; font-size:.56rem">Member No.
                        {{ $member['associators_info']['membershp_number'] }} </li>
                    <li style="text-transform: uppercase; padding:2px 20px; font-size:.56rem">BCS:
                        {{ $member['bcs_batch'] }}</li>
                    <li style="text-transform: uppercase; padding:2px 20px; font-size:.56rem">Mobile No.
                        {{ $member['mobile'] }}</li>
                </ul>

                <table
                    style="width: 100%; border-collapse:collapse; position:absolute; bottom:20px; background-color:midnightblue;color:white">
                    <tbody>
                        <tr>
                            <td style="text-align: center; color:midnightblue; padding:4px; font-size:.6rem">
                                www.bcssl.com.bd</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="id-card back">
                <div style="position: relative; tex-align:center; background-color:midnightblue; padding:10px 0">
                    <p style="font-style: italic; color:white; text-align:center"><small>This Card is the property of
                            Cadre Officers' Co-operative Society Limited</small></p>
                    <p style="width:60%; margin:0 auto; padding:0; text-align:center; color:#fff; font-size:0.5rem">Registration no. 1
                        (Department of Cooperatives), Date 23.02.2023</p>
                    {{-- <table
                        style="width: 100%; color: #fff; text-align: center; border-collapse: collapse; margin: 0 auto;">
                        <tr>
                            <td style="padding:2px; font-size: 0.4rem; text-align: left; width: 50%;">
                                Registration no. 1 (Department of Cooperatives),
                            </td>
                            <td style="padding:2px; font-size: 0.4rem; text-align: right; width: 50%;">
                                Date 23.02.2023
                            </td>
                        </tr>
                    </table> --}}
                </div>
                <p style="text-align: center; font-size:.6rem">If found please return this to following address</p>
                <!-- <div style="text-align:center">
                    <label for=""
                        style="display:inline-block; font-weight: bold; padding:10px; border-bottom:1px solid midnightblue; border-top:1px solid midnightblue">Established
                        2022</label>
                </div> -->
                <ul style="list-style: none; padding:0; text-align:center; font-size:.6rem">
                    <li style="padding: 2px; font-size:.6rem">House No:738,Flat:2b</li>
                    <li style="padding: 2px; font-size:.6rem">Ibrahimpur,Pst Office:Kafrul</li>
                    <li style="padding: 2px; font-size:.6rem">Police Station:Kafrul</li>
                    <li style="padding: 2px; font-size:.6rem">District: Dhaka</li>
                </ul>

                <div style="margin: 0 auto; text-align:center">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->generate($text)) !!} " alt=""
                        style="display:block; width: 80px; margin:0 auto">
                </div>

                <table
                    style="width: 85%; border-collapse:collapse; position:absolute; bottom:50px; left:50%; transform:translateX(-50%)">
                    <tbody>
                        <tr>
                            <td style="text-align: center">
                                @if (array_key_exists('secretary', $needed_signs))
                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $needed_signs['secretary']['file_location']))) }}"
                                        alt="" style="width: 40px; height:auto; display:block, margin:0 auto">
                                @endif
                                <div style="padding:0 10px; font-size:.6rem; border-top:1px solid black">Secretary</div>
                            </td>
                            <td style="text-align: center"><span style="padding:10px 20px"></span></td>
                            <td style="text-align: center">
                                @if (array_key_exists('chairman', $needed_signs))
                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $needed_signs['chairman']['file_location']))) }}"
                                        alt="" style="width: 40px; height:auto; display:block, margin:0 auto">
                                @endif
                                <div style="padding:0 10px; font-size:.6rem; border-top:1px solid black">Chairman</div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="width: 100%; border-collapse:collapse; position:absolute; bottom:20px; background-color:midnightblue;color:white">
                    <tbody>
                        <tr>
                            <td style="text-align: center; color:white; padding:4px; font-size:.6rem">www.coscol.com.bd
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @empty
            <p>No Member Chosen</p>
        @endforelse
    </main>
</body>
