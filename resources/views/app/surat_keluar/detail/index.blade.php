@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg p-t-10">
        <div class="row">
            <div class="col-9">
                <div class="card card-white">
                    <div class="card-body">
                        <form id="editUserForm">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Nama Jabatan</label>
                                    </div>
                                </div>
                                <div class="col-9">

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.surat_keluar.detail.scripts.form')
@endsection
