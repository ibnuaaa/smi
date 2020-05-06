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
                                        <input name="name" value="" class="form-control" type="text" placeholder="" required>
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
                                    @component('components.form.awesomeSelect', [
                                        'name' => 'parent_id',
                                        'option_all' => ['value' => '', 'label' => 'All'],
                                        'items' => $select['positions'],
                                        'selected' => 0,
                                        'class' => ''
                                    ])
                                    @endcomponent
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
                        <a href="{{ url('/position') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fas fa-arrow-left"></i> Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('formValidationScript')
    @include('app.position.new.scripts.form')
@endsection
