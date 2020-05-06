@extends('layout.app')

@section('title', 'User')
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
                                <label>Nama Satker</label>
                                <input name="satker" value="{{ $data['satker'] }}" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Nama Pejabat</label>
                                <input name="name" value="{{ $data['name'] }}" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Golongan</label>
                                <input name="golongan" value="{{ $data['golongan'] }}" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>NIP</label>
                                <input name="username" value="{{ $data['username'] }}" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>NIK</label>
                                <input name="nik" value="{{ $data['nik'] }}" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default form-group-default-select2 required">
                                <label class="">Jabatan</label>
                                <select name="position_id" class="form-control">
                                    <option value="{{  $data->position ? $data->position['id'] : '' }}">{{  $data->position ? $data->position['name'] : '' }}</option>
                                </select>
                            </div>
                            <div class="form-group form-group-default">
                                <label>Password</label>
                                <input autocomplete="new-password" name="password" class="form-control" type="password">
                            </div>
                            <div class="form-group form-group-default">
                                <label>Confirmation Password</label>
                                <input name="confirmPassword" class="form-control" type="password">
                            </div>
                            <div class="form-group">
                                <label>Jenis User</label>
                                <div class="radio radio-default jenis_user_radio">
                                    <input type="radio" value="1" name="jenis_user" id="radio1" {{ $data['jenis_user'] == '1' ? 'checked' : '' }}>
                                    <label for="radio1">Admin Surat</label>
                                    <input type="radio" value="2" name="jenis_user" id="radio2" {{ $data['jenis_user'] == '2' ? 'checked' : '' }}>
                                    <label for="radio2">User</label>
                                    <input type="radio" value="3" name="jenis_user" id="radio3" {{ $data['jenis_user'] == '3' ? 'checked' : '' }}>
                                    <label for="radio3">Superadmin</label>
                                </div>
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
                        <a href="{{ UrlPrevious(url('/user')) }}" class="btn btn-block btn-primary btn-cons m-b-10">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button id="deleteOpenModal" class="btn btn-block btn-danger btn-cons">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete Modal --}}
    <div class="modal fade slide-up disable-scroll" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                        <h5>Delete <span class="semi-bold">User</span></h5>
                        <p class="p-b-10">Are you sure you want to delete this entries?</p>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                            </div>
                            <div class="col-md-4 m-t-10 sm-m-t-10">
                                <button id="deleteAction" class="btn btn-block btn-danger btn-cons m-b-10"><i class="fas fa-trash"></i> Yes Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- /.Delete Modal --}}
@endsection

@section('script')
    @include('app.user.edit.scripts.index')
@endsection

@section('formValidationScript')
    @include('app.user.edit.scripts.form')
@endsection
