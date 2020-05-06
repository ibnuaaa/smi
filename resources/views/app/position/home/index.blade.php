@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('userManagementMenuClass', 'active')
@section('userManagementRoleUserMenuClass', 'active')

@section('content')
    <div class="container-fluid container-fixed-lg p-t-10">
        <nav class="navbar navbar-default bg-transparent sm-padding-10 full-width p-t-0 p-b-0 m-b-0" style="right: 50px;" role="navigation">
            <div class="container-fluid full-width">
                <div class="navbar-header text-center">
                    <button type="button" class="navbar-toggle collapsed btn btn-link no-padding" data-toggle="collapse" data-target="#sub-nav">
                        <i class="pg pg-more v-align-middle"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse">
                    <div class="row">
                        <div class="col-sm-4">
                            <ul class="navbar-nav d-flex flex-row">
                                <li class="nav-item">
                                    <a href="{{ url('/position/new') }}"><i class="fas fa-plus"></i> Tambah Jabatan</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <ul class="navbar-nav d-flex flex-row">
                            </ul>
                        </div>
                        <div class="col-sm-4" style="left: 100px;">
                            <ul class="navbar-nav d-flex flex-row justify-content-sm-end">
                                <li class="nav-item"><a href="#" class="p-r-10" onclick="$.Pages.setFullScreen(document.querySelector('html'));"><i class="fa fa-expand"></i> Fullscreen</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Data Jabatan</div><br>
            </div>
            <div class="card-body" style="overflow: scroll; overflow-y: hidden;">
                <table id="basic" class="table-bordered table-condensed-custom" style="width:1900px !important;">
                    <thead>
                        <tr>
                            <th>JABATAN</th>
                            <th>PEJABAT / NIP / ESELON</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $item)
                        <tr data-node-id="{{ $item->id }}" class="td-{{ $item->status }}">
                            <td style="height: 10px !important;">
                                {{ $item->name }}
                            </td>
                            <td>
                                {{ $item->user ? $item->user->name : '' }} /
                                {{ $item->user ? $item->user->username : '' }} /
                                {{ $item->eselon_id < 5 ? $item->eselon_id : 'STAFF' }}
                            </td>
                            <td>
                                <a href="{{ url('/position/'.$item->id) }}" class="btn btn-xs btn-success btn-table-action">Edit</a>
                            </td>
                        </tr>
                            @foreach ($item->children as $item2)
                            <tr data-node-id="{{ $item2->id }}" data-node-pid="{{ $item->id }}" class="td-{{ $item2->status }}">
                                <td style="white-space: nowrap;">
                                    {{ $item2->name }}
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $item2->user ? $item2->user->name : '' }} /
                                    {{ $item2->user ? $item2->user->username : '' }} /
                                    {{ $item2->eselon_id < 5 ? 'ESELON ' . $item2->eselon_id : 'STAFF' }}
                                </td>
                                <td>
                                    <a href="{{ url('/position/' . $item2->id) }}" class="btn btn-xs btn-success btn-table-action">Edit</a>
                                </td>
                            </tr>
                            @foreach ($item2->children as $item3)
                                <tr data-node-id="{{ $item3->id }}" data-node-pid="{{ $item2->id }}" class="td-{{ $item3->status }}">
                                    <td style="white-space: nowrap;">
                                        {{ $item3->name }}
                                    </td>
                                    <td style="white-space: nowrap;">
                                        {{ $item3->user ? $item3->user->name : '' }} /
                                        {{ $item3->user ? $item3->user->username : '' }} /
                                        {{ $item3->eselon_id < 5 ? 'ESELON ' . $item3->eselon_id : 'STAFF' }}
                                    </td>
                                    <td>
                                        <a href="{{ url('/position/' . $item3->id) }}" class="btn btn-xs btn-success btn-table-action">Edit</a>
                                    </td>
                                </tr>
                                @foreach ($item3->children as $item4)
                                    <tr data-node-id="{{ $item4->id }}" data-node-pid="{{ $item3->id }}" style="white-space: nowrap;" class="td-{{ $item4->status }}">
                                        <td style="white-space: nowrap;">
                                            {{ $item4->name }}
                                        </td>
                                        <td style="white-space: nowrap;">
                                            {{ $item4->user ? $item4->user->name : '' }} /
                                            {{ $item4->user ? $item4->user->username : '' }} /
                                            {{ $item4->eselon_id < 5 ? 'ESELON ' . $item4->eselon_id : 'STAFF' }}
                                        </td>
                                        <td>
                                            <a href="{{ url('/position/' . $item4->id) }}" class="btn btn-xs btn-success btn-table-action">Edit</a>
                                        </td>
                                    </tr>
                                    @foreach ($item4->children as $item5)
                                        <tr data-node-id="{{ $item5->id }}" data-node-pid="{{ $item4->id }}" class="td-{{ $item5->status }}">
                                            <td>
                                                {{ $item5->name }}
                                            </td>
                                            <td>
                                                {{ $item5->user ? $item5->user->name : '' }} /
                                                {{ $item5->user ? $item5->user->username : '' }} /
                                                {{ $item5->eselon_id < 5 ? 'ESELON ' . $item5->eselon_id : 'STAFF' }}
                                            </td>
                                            <td>
                                                <a href="{{ url('/position/' . $item5->id) }}" class="btn btn-xs btn-success btn-table-action">Edit</a>
                                            </td>
                                        </tr>
                                        @foreach ($item5->children as $item6)
                                            <tr data-node-id="{{ $item6->id }}" data-node-pid="{{ $item5->id }}" class="td-{{ $item6->status }}">
                                                <td>
                                                    {{ $item6->name }}
                                                </td>
                                                <td>

                                                    @foreach ($item6->users as $key => $user)
                                                        {{ $key + 1 }}.) {{ $user ? $user->name : '' }} /
                                                        NIP.{{ $user ? $user->username : '' }}
                                                        <br />
                                                    @endforeach

                                                </td>
                                                <td>
                                                    <a href="{{ url('/position/' . $item6->id) }}" class="btn btn-xs btn-success btn-table-action">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('formValidationScript')
    @include('app.position.home.scripts.form')
@endsection

@section('script')
    @include('app.position.home.style.style')
@endsection
