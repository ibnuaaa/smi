@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg p-t-10">
        <div class="card card-white">
            <div class="card-body">
                <form id="changePasswordForm">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Password Lama</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input name="password" value="" class="form-control" type="password" placeholder="Password Lama" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Password Baru</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input name="new_password" value="" class="form-control" type="password" placeholder="Passwor Baru" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input name="new_password_confirmation" value="" class="form-control" type="password" placeholder="Konfirmasi Password baru" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                        </div>
                        <div class="col-9">
                            <button id="saveAction" class="btn btn-block btn-success btn-cons m-b-10">
                                <i class="fas fa-save"></i>
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.user.change_password.scripts.form')
@endsection
