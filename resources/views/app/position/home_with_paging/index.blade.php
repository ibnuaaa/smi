@extends('layout.app')

@section('title', 'Information')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <nav class="navbar navbar-default bg-transparent sm-padding-10 full-width p-t-0 p-b-0 m-b-0" role="navigation">
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
                                    <a href="{{ url('/information/new') }}"><i class="fas fa-plus"></i> Create</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <ul class="navbar-nav d-flex flex-row">
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <ul class="navbar-nav d-flex flex-row justify-content-sm-end">
                                <li class="nav-item"><a href="#" class="p-r-10" onclick="$.Pages.setFullScreen(document.querySelector('html'));"><i class="fa fa-expand"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Position Data</div><br>
            </div>
            <div class="card-body">
                @component('components.table', ['data' => $data, 'props' => []])
                    @scopedslot('head', ($item))
                        @if($item->label === 'ID')
                            <th style="width: 3%">{{ $item->label }}</th>
                        @elseif ($item->label === 'ACTION')
                            <th style="width: 112px">{{ $item->label }}</th>
                        @else
                            <th style="width:{{$item->width}}px;">
                                {{ $item->label }}
                            </th>
                        @endif
                    @endscopedslot
                    @scopedslot('record', ($item, $props))
                        <tr>
                            <td>
                                <p style="white-space: normal !important; padding-left: {{$item->eselon_id * 20}}px;">
                                    {{ $item->name }}
                                    <br />
                                    [{{ !empty($item->user->name) ? $item->user->name : '' }} /
                                    {{ !empty($item->user->username) ? $item->user->username : '' }}]
                                </p>
                            </td>
                            <td>
                                <p>{{ $item->kunker }}</p>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ url('/position/'.$item->id) }}" class="btn btn-success"><i class="fas fa-pencil-alt"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endscopedslot
                @endcomponent
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.information.home.scripts.index')
@endsection
