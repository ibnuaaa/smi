@extends('layout.app')

@section('title', 'Information')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-9">
                <div class="card card-default">
                    <div class="card-header ">
                        <div class="card-title">
                            Data Desa
                        </div>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" id="newUserForm">
                            <div class="form-group form-group-default required ">
                                <label>Provinsi</label>
                                <select id="cars" name="cars">
                                    <option value="volvo">DKI JAKARTA</option>
                                    <option value="saab">JAWA BARAT</option>
                                    <option value="fiat">ACEH</option>
                                </select>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Kabupaten / Kota</label>
                                <select id="cars" name="cars">
                                    <option value="volvo">JAKARTA SELATAN</option>
                                    <option value="saab">JAKARTA UTARA</option>
                                    <option value="fiat">JAKARTA PUSAT</option>
                                </select>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Kecamatan</label>
                                <select id="cars" name="cars">
                                    <option value="volvo">Mampang Prapatan</option>
                                    <option value="saab">Kalibata</option>
                                </select>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Desa</label>
                                <input name="title" value="" class="form-control" type="text" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card card-default card-action">
                    <div class="card-body">
                        <button data-url-next="{{ UrlPrevious(url('/desa')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                            <i class="fas fa-save"></i>
                            &nbsp;Save
                        </button>
                        <a href="{{ url('/desa') }}" class="btn btn-block btn-danger btn-cons m-b-10"><i class="fas fa-arrow-left"></i>&nbsp;Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('formValidationScript')
    @include('app.information.new.scripts.form')
@endsection
