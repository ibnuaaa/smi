<?php setlocale (LC_TIME, "id-ID"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="/fonts/neo/font.css?v=1" rel="stylesheet" type="text/css">
    <link href="/fonts/frutiger/font.css?v=1" rel="stylesheet" type="text/css">
    <style>
        @page { margin: 0in; }
        body {
            background: rgb(204,204,204);
        }
        .bg {
            top: 0px;
            right: 0px;
            bottom: 0px;
            left: 0px;
            position: absolute;
            z-index: -1000;
            width: 100%;
            height: 100%;
        }
        page {
            position: relative;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
            padding: 25px 50px 0px 50px;
        }
        page[size="A4"] {
            width: 21cm;
            height: 29.7cm;
        }
        page[size="A4"][layout="landscape"] {
            width: 29.7cm;
            height: 21cm;
        }
        page[size="A3"] {
            width: 29.7cm;
            height: 42cm;
        }
        page[size="A3"][layout="landscape"] {
            width: 42cm;
            height: 29.7cm;
        }
        page[size="A5"] {
            width: 14.8cm;
            height: 21cm;
        }
        page[size="A5"][layout="landscape"] {
            width: 21cm;
            height: 14.8cm;
        }
        @media print {
            body, page {
                margin: 0;
                box-shadow: 0;
            }
        }
        table.wrapper {
            display: block;
            background-color: white;
            border-radius: 20px;
            width: 711px;
            height: 1014px;
            top: 37px;
            right: 0px;
            bottom: 0px;
            left: 60px;
            position: absolute;
            z-index: -900;
            padding: 30px;
        }
        .header-title {
            font-family: 'NeoMedium';
        }
        .body-title {
            font-family: 'Frutiger';
        }
        .text {
            color: #231F20;
            font-weight: 400;
        }
        .text-title {
            padding-bottom: 3px;
        }
        .text-bold {
            color: #231F20;
            font-weight: bold;
        }
        hr {
            height: 4px;
            background: #D2D3D5;
            border-width: 0px;
        }
        .dot-bull {
            color: #EF4036;
        }
        tbody {
            width: 100%;
            display: table;
        }
    </style>
</head>
<body>
    <page size="A4">
        <img class="bg" src="{{ url('/assets/img/bgprintbiru.png') }}">
        <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <table class="content" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="header" style="padding-bottom: 30px">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding-top: 10px; padidng-bottom: 10px" width="95px">
                                            <img src="{{ URL::asset('assets/img/logo-astra.png') }}" alt="" style="height: 95px; width: auto;">
                                        </td>
                                        <td style="padding-top: 20px" valign="center" align="center">
                                            <span class="header-title" style="font-size:26px; font-weight: 400; color: #0a56ad;">SIMULASI PERHITUNGAN KREDIT</span>
                                        </td>
                                        <td style="padding-top: 10px; padidng-bottom: 10px" width="95px">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="body body-title" width="100%" cellpadding="0" cellspacing="0">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <table width="50%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Nama</th>
                                                    <td class="text">: {{ $nama_ktp }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Handphone</th>
                                                    <td class="text">: {{ $no_hp }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan="2" style="padding-top: 15px"><hr/></th>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table width="50%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Dealer</th>
                                                    <td class="text">: {{ $nama_dealer }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Nama Sales Dealer</th>
                                                    <td class="text">: {{ $username }}</td>
                                                </tr>

                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Cabang ACC</th>
                                                    <td class="text">: {{ $cabang_name }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan="2" style="padding-top: 15px"><hr/></th>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table width="50%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Brand</th>
                                                    <td class="text">: {{ $brand_name }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Type</th>
                                                    <td class="text">: {{ $type_name }}</td>
                                                </tr>

                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Model</th>
                                                    <td class="text">: {{ $model_name }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Tahun Kendaraan</th>
                                                    <td class="text">: {{ $tahun }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan="2" style="padding-top: 15px"><hr/></th>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table width="50%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">OTR</th>
                                                    <td class="text">: {{ "Rp " . number_format($otr,0,',','.') }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">DP</th>
                                                    <td class="text">: {{ $dp . " %" }}</td>
                                                </tr>

                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Tenor</th>
                                                    <td class="text">: {{ $tenor . " Bulan" }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan="2" style="padding-top: 15px"><hr/></th>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table width="50%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text-bold text-title" width="42%" style="padding-bottom: 5px">Asuransi</th>
                                                </tr>
                                                @foreach ($asuransi_list as $asuransi)
                                                    <tr align="left">
                                                        <th class="text text-title" width="50%">{{ "Tahun " . $asuransi['tahun'] }}</th>
                                                        <td class="text">: {{ $asuransi['pilihan_asuransi'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan="2" style="padding-top: 15px"><hr/></th>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table width="50%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Pembayaran Asuransi</th>
                                                    <td class="text">: {{ ucfirst($pembayaran_asuransi) }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">ACP</th>
                                                    <td class="text">: {{ $acp }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan="2" style="padding-top: 15px"><hr/></th>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table width="50%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Total Biaya Pertama</th>
                                                    <td class="text">: {{ "Rp " . number_format($tdp,,0',','.') }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="50%">Angsuran Perbulan</th>
                                                    <td class="text">: {{ "Rp " . number_format($angsuran,0,',','.') }}</td>
                                                </tr>
                                            </table>
                                            
                                        </td>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                            </table>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="footer body-title" width="100%" cellpadding="0" cellspacing="0">
                                <table style="position: absolute;bottom: 20px; left: 15px;" width="100%" cellpadding="0" cellspacing="0">
                                    <tr align="left">
                                        <th class="text"><span class="dot-bull">&bull;</span> Perhitungan bersifat estimasi</th>
                                    </tr>
                                    <tr align="left">
                                        <th class="text"><span class="dot-bull">&bull;</span> Total Down Payment sudah termasuk pembayaran angsuran pertama dan biaya administrasi fidusia</th>
                                    </tr>
                                    <tr align="left">
                                        <th class="text"><span class="dot-bull">&bull;</span> ACP (ACC Credit Protection)</th>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </page>
</body>
</html>
