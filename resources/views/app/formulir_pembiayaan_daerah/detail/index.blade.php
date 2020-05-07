@extends('layout.app')

@section('title', 'Formulir Pembiayaan Daerah')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="jumbotron jumbotron m-b-0" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Formulir Pembiayaan Daerah</a></li>
                    <li class="breadcrumb-item active">Detail </li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid container-fixed-lg">
        <div class="card card-default m-t-20">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="font-montserrat all-caps hint-text">Formulir Pembiayaan Daerah</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Pemerintah Daerah
                    </div>
                    <div class="col-md-10">
                        Aceh
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Nama Proyek
                    </div>
                    <div class="col-md-10">
                        Pengembangan Jembatan Aceh 2020
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Sektor
                    </div>
                    <div class="col-md-10">
                        Jembatan
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Nilai Permohonan
                    </div>
                    <div class="col-md-10">
                        Rp 2.000.000.000,00
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Tenor
                    </div>
                    <div class="col-md-10">
                        24 Bulan
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Masa Konstruksi
                    </div>
                    <div class="col-md-10">
                        24 Bulan
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        STATUS tahapan proyek
                    </div>
                    <div class="col-md-10">
                        <b>Telah di SUBMIT menunggu REVIEW</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Dokumen</h2>
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th style="width:50px;">
                                    No
                                </th>
                                <th>
                                    Nama Dokumen
                                </th>
                                <th style="width:160px;">
                                    Status
                                </th>
                                <th style="width:400px;">
                                    Aksi
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    1
                                </td>
                                <td>
                                    Kerangka Acuan Kerja
                                </td>
                                <td>
                                    <label class="btn btn-xs">Belum Diupload</label>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="#">Lihat Dokumen</a>
                                    <a class="btn btn-primary" href="#">Upload</a>
                                    <a class="btn btn-primary" href="#">Download Template</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    2
                                </td>
                                <td>
                                    Pakta Integritas
                                </td>
                                <td>
                                    <label class="btn">Belum Diupload</label>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="#">Lihat Dokumen</a>
                                    <a class="btn btn-primary" href="#">Upload</a>
                                    <a class="btn btn-primary" href="#">Download Template</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    3
                                </td>
                                <td>
                                    Perhitungan DSCR
                                </td>
                                <td>
                                    <label class="btn">Belum Diupload</label>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="#">Lihat Dokumen</a>
                                    <a class="btn btn-primary" href="#">Upload</a>
                                    <a class="btn btn-primary" href="#">Download Template</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    4
                                </td>
                                <td>
                                    Pernyataan Tidak Mempunyai Tunggakan
                                </td>
                                <td>
                                    <label class="btn btn-xs">Belum Diupload</label>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="#">Lihat Dokumen</a>
                                    <a class="btn btn-primary" href="#">Upload</a>
                                    <a class="btn btn-primary" href="#">Download Template</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    5
                                </td>
                                <td>
                                    Dokumen Lain
                                </td>
                                <td>
                                    <label class="btn">Belum Diupload</label>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="#">Lihat Dokumen</a>
                                    <a class="btn btn-primary" href="#">Upload</a>
                                    <a class="btn btn-primary" href="#">Download Template</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    6
                                </td>
                                <td>
                                    Dokumen Lain 2
                                </td>
                                <td>
                                    <label class="btn">Belum Diupload</label>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="#">Lihat Dokumen</a>
                                    <a class="btn btn-primary" href="#">Upload</a>
                                    <a class="btn btn-primary" href="#">Download Template</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2>History Feedback</h2>
                    </div>
                </div>
                <div class="row">
                    <br>&nbsp;
                </div>
                @if (MyAccount()->position_id == 1)
                <div class="row">
                    <div class="col-md-12">
                        <a href="#modalTahapan" data-toggle="modal" class="btn btn-success">UPDATE TAHAPAN PROYEK</a>&nbsp;
                        <a href="#modalFeedback" data-toggle="modal" class="btn btn-success">FEEDBACK</a>&nbsp;
                        <a href="#" class="btn btn-success">Sync KEMENDAGRI</a>&nbsp;
                        <a href="#" class="btn btn-success">Sync KEMENKEU</a>&nbsp;
                    </div>
                </div>
                @endif
            </div>

        </div>

    </div>

    <div class="modal fade slide-up disable-scroll" id="modalTahapan" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                        <h5>Update Tahapan Project <span class="semi-bold"></span>
                        <select id="cars" name="cars">
                            <option value="volvo">Tahapan 1</option>
                            <option value="saab">Tahapan 2</option>
                            <option value="fiat">Tahapan 3</option>
                        </select>
                        <br>
                        <br>&nbsp;
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <button id="deleteAction" class="btn btn-cons m-b-10">
                                    <i class="fas fa-times"></i>&nbsp;&nbsp; Cancel
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button id="deleteAction" class="btn btn-success btn-cons m-b-10">
                                    <i class="fas fa-check"></i> &nbsp;&nbsp;Yes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade slide-up disable-scroll" id="modalFeedback" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                        <h5>Masukkan FEEDBACK <span class="semi-bold"></span></h5>
                        <div class="form-group form-group-default required ">
                            <label>Feedback</label>
                            <input name="title" value="" class="form-control" type="text" required>
                        </div>
                        <br>
                        <br>&nbsp;
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <button id="deleteAction" class="btn btn-cons m-b-10">
                                    <i class="fas fa-times"></i>&nbsp;&nbsp; Cancel
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button id="deleteAction" class="btn btn-success btn-cons m-b-10">
                                    <i class="fas fa-check"></i> &nbsp;&nbsp;Yes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.information.detail.scripts.form')
@endsection
