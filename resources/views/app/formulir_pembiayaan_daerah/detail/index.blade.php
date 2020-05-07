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
                    <br>&nbsp;
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-success" href="#">UPDATE TAHAPAN PROYEK</a>
                        <a class="btn btn-success" href="#">FEEDBACK</a>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection

@section('script')
    @include('app.information.detail.scripts.form')
@endsection
