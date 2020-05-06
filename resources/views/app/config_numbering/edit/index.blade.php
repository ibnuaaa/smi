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
                            Edit
                        </div>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" id="editUserForm">
                            <div class="form-group form-group-default required ">
                                <label>Tipe</label>
                                <input name="type" value="{{ $data['type'] }}" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Panjang Nomor</label>
                                <input name="length" value="{{ $data['length'] }}" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Nomor terakhir</label>
                                <input name="last_value" value="{{ $data['last_value'] }}" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default">
                                <label>Deskripsi</label>
                                <input name="description" value="{{ $data['description'] }}" class="form-control" type="text" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card card-default card-action">
                    <div class="card-body">
                        <button id="saveAction" class="btn btn-block btn-success btn-cons m-b-10">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <a href="{{ UrlPrevious(url('/config_numbering')) }}" class="btn btn-block btn-primary btn-cons m-b-10">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('formValidationScript')
    @include('app.config_numbering.edit.scripts.form')
@endsection
