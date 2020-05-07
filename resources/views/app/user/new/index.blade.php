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
                            Buat User
                        </div>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" id="newUserForm">
                            <div class="form-group form-group-default required ">
                                <label>Nama</label>
                                <input name="satker" value="" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Golongan</label>
                                <input name="golongan" value="" class="form-control" type="text" required>
                            </div>

                            <div class="form-group form-group-default required ">
                                <label>Password</label>
                                <input autocomplete="new-password" name="password" class="form-control" type="password" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Confirmation Password</label>
                                <input name="confirmPassword" class="form-control" type="password" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Email</label>
                                <input name="email" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default form-group-default-select2 required">
                                <label class="">Jabatan</label>
                                <select name="position_id" class="form-control">
                                </select>
                            </div>
                            <div class="form-group form-group-default form-group-default-select2 required">
                                <label class="">Gender</label>
                                @component('components.form.awesomeSelect', [
                                    'name' => 'gender',
                                    'items' => [['value' => 'male', 'label' => 'Male'], ['value' => 'female', 'label' => 'Female']],
                                    'selected' => null
                                ])
                                @endcomponent
                            </div>
                            <div class="form-group">
                                <label>Jenis User</label>
                                <div class="radio radio-default jenis_user_radio">
                                    <input type="radio" value="1" name="jenis_user" id="radio1">
                                    <label for="radio1">Admin Surat</label>
                                    <input type="radio" value="2" name="jenis_user" id="radio2">
                                    <label for="radio2">User</label>
                                    <input type="radio" value="3" name="jenis_user" id="radio3">
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
                        <button data-url-next="{{ UrlPrevious(url('/user')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                            <i class="fas fa-save"></i>
                            Save
                        </button>

                        <button data-is-recreate="true" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                            <i class="fas fa-save"></i>
                            Save & New
                        </button>

                        <a href="{{ url('/user') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fas fa-arrow-left"></i> Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.user.new.scripts.index')
@endsection

@section('formValidationScript')
    @include('app.user.new.scripts.form')
@endsection
