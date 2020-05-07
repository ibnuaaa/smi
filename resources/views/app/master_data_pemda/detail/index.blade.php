@extends('layout.app')

@section('title', 'Master Data Pemda')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="jumbotron jumbotron m-b-0" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/information') }}">Master Data Pemda</a></li>
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
                        <h2 class="font-montserrat all-caps hint-text">Master data Pemda</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Pemda
                    </div>
                    <div class="col-md-10">
                        DKI JAKARTA
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        PIC Contact
                    </div>
                    <div class="col-md-10">
                        Mulyadi
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Email
                    </div>
                    <div class="col-md-10">
                        lalalal@lala.com
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Phone Number
                    </div>
                    <div class="col-md-10">
                        +6285656565656
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="font-montserrat all-caps hint-text">History Pengajuan Pinjaman</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <b>No</b>
                    </div>
                    <div class="col-md-4">
                        <b>Tanggal Pengajuan</b>
                    </div>
                    <div class="col-md-4">
                        <b>Nama Proyek</b>
                    </div>
                    <div class="col-md-2">
                        <b>Status</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        1
                    </div>
                    <div class="col-md-4">
                        20 Januari 2020
                    </div>
                    <div class="col-md-4">
                        Pembangunan Jembatan
                    </div>
                    <div class="col-md-2">
                        Diproses
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('script')
    @include('app.information.detail.scripts.form')
@endsection
