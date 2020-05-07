@extends('layout.app')

@section('title', 'Master Data Provinsi')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="jumbotron jumbotron m-b-0" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/request_user') }}">Detail Request User</a></li>
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
                        <h2 class="font-montserrat all-caps hint-text">Request Approval User</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Pemda
                    </div>
                    <div class="col-md-10">
                        JAWA BARAT
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        CONTACT PERSON
                    </div>
                    <div class="col-md-10">
                        JOKO SUSILO
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        JABATAN PIC
                    </div>
                    <div class="col-md-10">
                        MANAGER
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        EMAIL
                    </div>
                    <div class="col-md-10">
                        aaa@aa.com
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        NOMOR HANDPHONE
                    </div>
                    <div class="col-md-10">
                        +62812345678
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        STATUS
                    </div>
                    <div class="col-md-10">
                        Pending
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('script')
    @include('app.information.detail.scripts.form')
@endsection
