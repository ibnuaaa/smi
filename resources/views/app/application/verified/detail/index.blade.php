@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('ringkasanPengajuanMenuClass', 'active')
@section('ringkasanPengajuanVerifyMenuClass', 'active')

@section('content')
    <div class="jumbotron" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/application/verified') }}">Verify</a></li>
                    <li class="breadcrumb-item active">Detail Verify</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-8">
                <div class="card-group horizontal" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="card card-default m-b-0">
                        <div class="card-header " role="tab" id="headingOne" style="margin-top: -5px;">
                            <h4 class="card-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Info Pengajuan
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="collapse show" role="tabcard" aria-labelledby="headingOne">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Area Pengajuan</label>
                                            <input name="area_pengajuan" value="{{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['AREA_PENGAJUAN'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Cabang Acc</label>
                                            <input name="cabang_acc" value="{{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['CABANG ACC'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Brand</label>
                                            <input name="brand" value="{{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['VEHICLE_BRAND'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Type</label>
                                            <input name="type" value="{{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['VEHICLE_TYPE'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Model</label>
                                            <input name="model" value="{{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['VEHICLE_MODEL'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Tahun Kendaraan</label>
                                            <input name="year_vehicle" value="{{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['TAHUN_KENDARAAN'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>OTR</label>
                                            <input name="otr" value="{{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['OTR'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>DP</label>
                                            <input name="dp" value="{{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['DP'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Tenor</label>
                                            <input name="tenor" value="{{ isset($detail) ? $detail['INFO_PENGAJUAN'][0]['TENOR'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-default m-b-0">
                        <div class="card-header " role="tab" id="headingTwo" style="margin-top: -5px;">
                            <h4 class="card-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Asuransi
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="collapse" role="tabcard" aria-labelledby="headingTwo">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Asuransi Tahun 1</label>
                                            <input name="area_pengajuan" value="{{ isset($detail) ? $detail['ASURANSI'][0]['ASURANSI_TAHUN_1'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Asuransi Tahun 2</label>
                                            <input name="cabang_acc" value="{{ isset($detail) ? $detail['ASURANSI'][0]['ASURANSI_TAHUN_2'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Asuransi Tahun 3</label>
                                            <input name="brand" value="{{ isset($detail) ? $detail['ASURANSI'][0]['ASURANSI_TAHUN_3'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Asuransi Tahun 4</label>
                                            <input name="type" value="{{ isset($detail) ? $detail['ASURANSI'][0]['ASURANSI_TAHUN_4'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Asuransi Tahun 5</label>
                                            <input name="model" value="{{ isset($detail) ? $detail['ASURANSI'][0]['ASURANSI_TAHUN_5'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Kode Plat Nomor Polisi</label>
                                            <input name="year_vehicle" value="{{ isset($detail) ? $detail['ASURANSI'][0]['KODE_PLAT_NOMOR_POLISI'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Wilayah Asuransi</label>
                                            <input name="otr" value="{{ isset($detail) ? $detail['ASURANSI'][0]['WILAYAH_ASURANSI'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Pembayaran Asuransi</label>
                                            <input name="dp" value="{{ isset($detail) ? $detail['ASURANSI'][0]['PEMBAYARAN_ASURANSI'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>ACP</label>
                                            <input name="tenor" value="{{ isset($detail) ? $detail['ASURANSI'][0]['ACP'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>TDP</label>
                                            <input name="tenor" value="{{ isset($detail) ? $detail['ASURANSI'][0]['TDP'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Angsuran</label>
                                            <input name="tenor" value="{{ isset($detail) ? $detail['ASURANSI'][0]['ANGSURAN'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-default m-b-0">
                        <div class="card-header " role="tab" id="headingThree" style="margin-top: -5px;">
                            <h4 class="card-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Data Debitur
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="collapse" role="tabcard" aria-labelledby="headingThree">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Nama sesuai KTP</label>
                                            <input name="area_pengajuan" value="{{ isset($detail) ? $detail['DEBITUR'][0]['NAMA_SESUAI_KTP'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Nomor Handphone</label>
                                            <input name="cabang_acc" value="{{ isset($detail) ? $detail['DEBITUR'][0]['NOMOR_HANDPHONE'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>KTP</label>
                                            <input name="brand" value="{{ isset($detail) ? $detail['DEBITUR'][0]['KTP'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>BPKB</label>
                                            <input name="type" value="{{ isset($detail) ? $detail['DEBITUR'][0]['BPKB'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>STNK</label>
                                            <input name="model" value="{{ isset($detail) ? $detail['DEBITUR'][0]['STNK'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>NPWP</label>
                                            <input name="year_vehicle" value="{{ isset($detail) ? $detail['DEBITUR'][0]['NPWP'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default">
                                            <label>Kartu Keluarga</label>
                                            <input name="otr" value="{{ isset($detail) ? $detail['DEBITUR'][0]['KARTU_KELUARGA'] : '-' }}" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-default card-action">
                    <div class="card-body">
                        <a href="{{ UrlPrevious(url('/application/verified')) }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fas fa-arrow-left"></i> Cancel</a>
                        <a href="{{ url('/application/verified-pdf/' . $enoreg) }}" target="_blank" class="btn btn-block btn-success btn-cons"><i class="fas fa-download"></i> Download PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
