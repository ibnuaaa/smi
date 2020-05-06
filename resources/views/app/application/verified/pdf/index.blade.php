<?php setlocale (LC_TIME, "id-ID"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        @font-face {
            font-family: NeoMedium;
            src: url({{ storage_path('fonts/neo/Neo_Sans_Medium.ttf') }}) format("truetype");
        }
        @font-face {
            font-family: SourceSans;
            src: url({{ storage_path('fonts/OpenSans/OpenSans-Light.ttf') }}) format("truetype");
        }
        @font-face {
            font-family: OpenSansBold;
            src: url({{ storage_path('fonts/OpenSans/OpenSans-Bold.ttf') }}) format("truetype");
        }
        @page { margin: 0in; }
        body {
            font-family: 'SourceSans';
            line-height: 12px;
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
            display: block;
            background-color: white;
            border-radius: 20px;
            width: 635px;
            height: 991px;
            top: 35px;
            right: 0px;
            bottom: 0px;
            left: 48px;
            position: absolute;
            z-index: -900;
            padding: 30px;
        }

        @media print {
            body, page {
                margin: 0;
                box-shadow: 0;
            }
        }
        .header-title {
            font-family: 'NeoMedium';
        }
        .text {
            color: #231F20;
            font-weight: 400;
        }

        .text-title {
            font-family: 'SourceSans';
            padding-bottom: 3px;
        }

        .text-notes {
        }

        .text-bold {
            font-family: 'OpenSansBold';
            color: #231F20;
        }

        hr {
            height: 4px;
            background: #D2D3D5;
            border-width: 0px;
        }

        .dot-bull {
            font-family: 'NeoMedium';
            font-size: 19px;
            color: #EF4036;
        }
    </style>
</head>
<body>
    <img class="bg" src="{{ url('/assets/img/bgprintbiru.png') }}">
    <page size="A4">
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
                                        <td style="padding-top: 50px" valign="center" align="center">
                                            <span class="header-title" style="font-size:26px; font-weight: 400; color: #0a56ad;">SIMULASI PERHITUNGAN KREDIT</span>
                                        </td>
                                        <td style="padding-top: 10px; padidng-bottom: 10px" width="95px">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="body" width="100%" cellpadding="0" cellspacing="0">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Nama</th>
                                                    <td class="text">: {{ $nama_ktp }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Handphone</th>
                                                    <td class="text">: {{ $no_hp }}</td>
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
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Dealer</th>
                                                    <td class="text">: {{ $nama_dealer }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Nama Sales Dealer</th>
                                                    <td class="text">: {{ $username }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Cabang ACC</th>
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
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Brand</th>
                                                    <td class="text">: {{ $brand_name }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Type</th>
                                                    <td class="text">: {{ $type_name }}</td>
                                                </tr>

                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Model</th>
                                                    <td class="text">: {{ $model_name }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Tahun Kendaraan</th>
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
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">OTR</th>
                                                    <td class="text">: {{ "Rp " . number_format($otr,0,',','.') }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">DP</th>
                                                    <td class="text">: {{ isset($dp) ? $dp . " %" : null }}</td>
                                                </tr>

                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Tenor</th>
                                                    <td class="text">: {{ isset($tenor) ? $tenor . " Bulan" : null }}</td>
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
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-bold text-title" width="27%">Asuransi</th>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                            </table>
                                        </td>
                                    </tr>
                                    @foreach ($asuransi_list as $asuransi)
                                        <tr>
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr align="left">
                                                        <th class="text text-title" width="27%">{{ isset($asuransi['tahun']) ? "Tahun " . $asuransi['tahun'] : null}}</th>
                                                        <td class="text">: {{ $asuransi['pilihan_asuransi'] }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <th colspan="2" style="padding-top: 15px"><hr/></th>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Pembayaran Asuransi</th>
                                                    <td class="text">: {{ ucfirst($pembayaran_asuransi) }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">ACP</th>
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
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Total Biaya Pertama</th>
                                                    <td class="text">: {{ "Rp " . number_format($tdp,0,',','.') }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="27%">Angsuran Per bulan</th>
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
                            <td class="footer body-title" width="50%" cellpadding="0" cellspacing="0">
                                <table style="position: absolute;bottom: 95px; left: 30px;" width="100%" cellpadding="0" cellspacing="0">
                                    <tr align="left">
                                        <th class="text text-notes"><span class="dot-bull">&bull;</span> Perhitungan bersifat estimasi</th>
                                    </tr>
                                    <tr align="left">
                                        <th class="text text-notes"><span class="dot-bull">&bull;</span> Total Down Payment sudah termasuk pembayaran angsuran pertama dan biaya</th>
                                    </tr>
                                    <tr align="left">
                                        <th class="text text-notes"><span>&nbsp;&nbsp;</span> administrasi fidusia</th>
                                    </tr>
                                    <tr align="left">
                                        <th class="text text-notes"><span class="dot-bull">&bull;</span> ACP (ACC Credit Protection)</th>
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
