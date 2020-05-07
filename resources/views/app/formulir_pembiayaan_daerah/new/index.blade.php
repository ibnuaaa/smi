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
                            Formulir Pembiayaan Daerah
                        </div>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" id="newUserForm">
                            <div class="form-group form-group-default required ">
                                <label>Pemerintah Daerah</label>
                                <input name="title" value="" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Nilai Permohonan</label>
                                <input name="title" value="" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Sektor</label>
                                <input name="title" value="" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Tenor</label>
                                <input name="title" value="" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Masa Konstruksi</label>
                                <input name="title" value="" class="form-control" type="text" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card card-default card-action">
                    <div class="card-body">
                        <button data-url-next="{{ UrlPrevious(url('/information')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                            <i class="fas fa-save"></i>
                            Save
                        </button>
                        <a href="{{ url('/information') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fas fa-arrow-left"></i> Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('formValidationScript')
    @include('app.information.new.scripts.form')
@endsection
