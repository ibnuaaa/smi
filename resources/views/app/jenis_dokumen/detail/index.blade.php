@extends('layout.app')

@section('title', 'Jenis Dokumen')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="jumbotron jumbotron m-b-0" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/jenis_dokumen') }}">Jenis Dokumen</a></li>
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
                        <h2 class="font-montserrat all-caps hint-text">Jenis Dokumen</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Nama Sektor
                    </div>
                    <div class="col-md-10">
                        Sektor A
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Dokumen</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 130px;">
                                    No
                                </th>
                                <th>
                                    Dokumen
                                </th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    1
                                </td>
                                <td>
                                    Dokumen 1
                                </td>
                                <td>
                                    <a href="#modalDelete" data-toggle="modal" data-record-id="1" data-record-name="" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    2
                                </td>
                                <td>
                                    Dokumen 2
                                </td>
                                <td>
                                    <a href="#modalDelete" data-toggle="modal" data-record-id="1" data-record-name="" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    3
                                </td>
                                <td>
                                    Dokumen 3
                                </td>
                                <td>
                                    <a href="#modalDelete" data-toggle="modal" data-record-id="1" data-record-name="" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br>
                <a href="#modalFeedback" data-toggle="modal" class="btn btn-success">Tambah Dokumen</a>&nbsp;
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
                        <h5>Masukkan Dokumen Baru <span class="semi-bold"></span></h5>
                        <div class="form-group form-group-default required ">
                            <label>Dokumen Baru</label>
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
@endsection

@section('script')
    @include('app.information.detail.scripts.form')
@endsection
