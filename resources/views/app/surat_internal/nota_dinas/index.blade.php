@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
    <div class="jumbotron jumbotron m-b-0" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Nota Dinas</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid container-fixed-lg p-t-10">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Nota Dinas Data</div><br>
            </div>
            <div class="card-body">
                <form id="editCategoryForm">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Tujuan / Penerima</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input name="username" value="" class="form-control" type="text" placeholder="Tujuan / Penerima" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Pemutus / Signer</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="row">
                                <div class="form-group col-md-4">
                                @component('components.form.awesomeSelect', [
                                    'name' => 'tipe_user',
                                    'items' => [['value' => '1', 'label' => 'Checker'], ['value' => '2', 'label' => 'Signer']],
                                    'selected' => ''
                                ])
                                @endcomponent
                                </div>
                                <div class="form-group form-group-default required  col-md-8">
                                    <input name="username" value="" class="form-control" type="text" placeholder="NIP / Nama Checker"  required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                @component('components.form.awesomeSelect', [
                                    'name' => 'tipe_user',
                                    'items' => [['value' => '1', 'label' => 'Checker'], ['value' => '2', 'label' => 'Signer']],
                                    'selected' => ''
                                ])
                                @endcomponent
                                </div>
                                <div class="form-group form-group-default required  col-md-8">
                                    <input name="username" value="" class="form-control" type="text" placeholder="NIP / Nama Signer"  required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Lampiran</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input type="file">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Sifat</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="row">
                                @component('components.form.awesomeSelect', [
                                    'name' => 'tipe_user',
                                    'items' => [
                                        ['value' => '1', 'label' => 'Sangat Segera'], 
                                        ['value' => '2', 'label' => 'Segera'],
                                        ['value' => '3', 'label' => 'Biasa'],
                                        ['value' => '4', 'label' => 'Penting'],
                                        ['value' => '5', 'label' => 'Rahasia']
                                    ],
                                    'selected' => ''
                                ])
                                @endcomponent
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Nomor Surat</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input name="username" value="" class="form-control" type="text" placeholder="Nomor Surat Diisi Secara Manual"  required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Tembusan</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input name="username" value="" class="form-control" type="text" placeholder="Tembusan / Pilih Satker"  required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Hal</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input name="username" value="" class="form-control" type="text" placeholder="Perihal Surat Diisi Secara Manual"  required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Tanggal Surat</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input name="username" value="" class="form-control date" type="text" placeholder="Tanggal Surat Diisi Secara Manual"  required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Isi Surat</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input name="username" value="" class="form-control date" type="text" placeholder="Isi Surat Diisi Secara Manual"  required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
