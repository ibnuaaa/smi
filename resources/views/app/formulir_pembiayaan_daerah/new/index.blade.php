@extends('layout.app')

@section('title', 'Formulir Pembiayaan Daerah')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header ">
                        <div class="card-title">
                            Formulir Pembiayaan Daerah
                        </div>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" id="newUserForm">
                            <div class="form-group form-group-default required ">
                                <label>Pemerintah Daerah</label>
                                <input name="title" value="" class="form-control" type="text" required placeholder="Nama Proyek">
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Nilai Permohonan</label>
                                <input name="title" value="" class="form-control" type="text" required placeholder="Nilai Permohonan">
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Sektor</label>
                                <select id="cars" name="cars">
                                    <option value="volvo">Jalan dan Jembatan</option>
                                    <option value="saab">Pilihan sektor lain 1</option>
                                    <option value="fiat">Pilihan sektor lain 2</option>
                                    <option value="audi">DST.</option>
                                </select>
                                </div>
                            <div class="form-group form-group-default required ">
                                <label>Tenor (Dalam Bulan)</label>
                                <input name="title" value="" class="form-control" type="text" required placeholder="Tenor">
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Masa Konstruksi (Dalam Bulan)</label>
                                <input name="title" value="" class="form-control" type="text" required placeholder="Tenor">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-default card-action">
                    <div class="card-body">
                        <button data-url-next="{{ UrlPrevious(url('/information')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                            <i class="fas fa-save"></i>
                            &nbsp;SUBMIT
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('formValidationScript')
    @include('app.information.new.scripts.form')
@endsection
