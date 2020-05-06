<?php setlocale (LC_TIME, "id-ID"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="/fonts/exo/font.css" rel="stylesheet" type="text/css">
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
            font-family: 'ExoBold';
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
                            <td class="body" width="100%" cellpadding="0" cellspacing="0">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Nama</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['DEBITUR'][0]['NAMA_SESUAI_KTP'] : '-' }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Handphone</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['DEBITUR'][0]['NOMOR_HANDPHONE'] : '-' }}</td>
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
                                                    <th class="text text-title" width="23%">Dealer</th>
                                                    <td class="text">:</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Nama Sales Dealer</th>
                                                    <td class="text">:</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Cabang ACC</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['CABANG ACC'] : '-' }}</td>
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
                                                    <th class="text text-title" width="23%">Brand</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['VEHICLE_BRAND'] : '-' }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Type</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['VEHICLE_TYPE'] : '-' }}</td>
                                                </tr>

                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Model</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['VEHICLE_MODEL'] : '-' }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Tahun Kendaraan</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['TAHUN_KENDARAAN'] : '-' }}</td>
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
                                                    <th class="text text-title" width="23%">OTR</th>
                                                    <td class="text">: {{ isset($detail) ? "Rp " . number_format($detail['INFO_PENGAJUAN'][0]['OTR'],0,',','.') : '-' }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">DP</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['DP'] . ' %' : '-' }}</td>
                                                </tr>

                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Tenor</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['TENOR'] . ' Bulan' : '-' }}</td>
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
                                                    <th class="text-bold text-title" width="42%" style="padding-bottom: 5px">Asuransi</th>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Tahun 1</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['ASURANSI'][0]['ASURANSI_TAHUN_1'] : '-' }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Tahun 2</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['ASURANSI'][0]['ASURANSI_TAHUN_2'] : '-' }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Tahun 3</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['ASURANSI'][0]['ASURANSI_TAHUN_3'] : '-' }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Tahun 4</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['ASURANSI'][0]['ASURANSI_TAHUN_4'] : '-' }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Tahun 5</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['ASURANSI'][0]['ASURANSI_TAHUN_5'] : '-' }}</td>
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
                                                    <th class="text text-title" width="23%">Pembayaran Asuransi</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['ASURANSI'][0]['PEMBAYARAN_ASURANSI'] : '-' }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">ACP</th>
                                                    <td class="text">: {{ isset($detail) ? $detail['ASURANSI'][0]['ACP'] : '-' }}</td>
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
                                                    <th class="text text-title" width="23%">Total Biaya Pertama</th>
                                                    <td class="text">: {{ isset($detail) ? "Rp " . number_format($detail['ASURANSI'][0]['TDP'],0,',','.') : '-' }}</td>
                                                </tr>
                                                <tr align="left">
                                                    <th class="text text-title" width="23%">Angsuran Per bulan</th>
                                                    <td class="text">: {{ isset($detail) ? "Rp " . number_format($detail['ASURANSI'][0]['ANGSURAN'],0,',','.') : '-' }}</td>
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
                            <td class="footer" width="100%" cellpadding="0" cellspacing="0">
                                <table style="position: absolute;bottom: 20px; left: 30px;" width="100%" cellpadding="0" cellspacing="0">
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
