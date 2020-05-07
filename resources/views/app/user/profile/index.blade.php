@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg p-t-10">
        <div class="card card-white">
            <div class="card-body">
                <form id="editUserForm">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div id="img-preview">
                                    @if (!empty($profile_picture_key))
                                        <img src="http://satellite-<?php echo env('APP_DOMAIN') ?>/storage/{{ $profile_picture_key }}" style="width:100px;" />
                                    @else
                                        <img src="{{ url('assets/img/profiles/avatar.jpg') }}" style="width:100px;" />
                                    @endif
                                </div>
                                <input type="file" onchange="prepareUpload(this);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Nama</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default">
                                {{ $data->name }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Jabatan</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default">
                                <?php echo $data->position['name']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row hide">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Jenis User</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="radio radio-default jenis_user_radio">
                                {{ config('app.jenis_user.' . $data->jenis_user) }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.user.profile.scripts.index')
@endsection

@section('formValidationScript')
    @include('app.user.profile.scripts.form')
@endsection
