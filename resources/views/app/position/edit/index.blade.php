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
                                    <div class="form-group form-group-default required">
                                        <input name="name" value="{{ $data->name }}" class="form-control" type="text" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Template Tandatangan</label>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group form-group-default required">
                                        <input name="signing_template" value="{{ $data->signing_template }}" class="form-control" type="text" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Singkatan</label>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group form-group-default required">
                                        <input name="shortname" value="{{ $data->shortname }}" class="form-control" type="text" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Kode Nomor Surat (suffix)</label>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group form-group-default required">
                                        <input name="mail_number_suffix_code" value="{{ $data->mail_number_suffix_code }}" class="form-control" type="text" placeholder="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Turunan Dari</label>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <select name="parent_id" class="form-control">
                                        <option value="{{  $data->parent ? $data->parent->id : '' }}">{{  $data->parent ? $data->parent->name : '' }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                    </div>
                                </div>
                                <div class="col-9">
                                    @if (!empty($data['status']) && $data['status'] == 'active')
                                    <input type="button" class="btn btn-primary btn-xs" value="Active" />
                                    @else
                                    <input type="button" class="btn btn-danger btn-xs" value="Inctive" />
                                    @endif
                                </div>
                            </div>
                            <div class="form-group-attached form-group-default">
                                <label>ACCESS MENU</label>
                                @foreach ($permissions as $KeyPermission => $permission)
                                  <div class="row">
                                    @foreach ($permission as $KeyEach => $each)
                                    <div class="col-md-4">
                                        <div class="checkbox check-info">
                                            <input type="checkbox" name="permission" {{$each->checked ? 'checked' : ''}} value="{{$each->id}}" id="checkbox-{{$each->id}}">
                                            <label for="checkbox-{{$each->id}}">{{ $each->label }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                  </div>
                                @endforeach
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

                        @if (!empty($data->status) && $data->status == 'active')
                        <button onClick="changeStatusPosition('inactive')" class="btn btn-block btn-danger btn-cons m-b-10">
                            <i class="fas fa-check"></i> Inactive
                        </button>
                        @else
                        <button onClick="changeStatusPosition('active')" class="btn btn-block btn-primary btn-cons m-b-10">
                            <i class="fas fa-check"></i> Active
                        </button>
                        @endif


                        <a href="{{ url('/position') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fas fa-arrow-left"></i> Cancel</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('formValidationScript')
    @include('app.position.edit.scripts.form')
@endsection
