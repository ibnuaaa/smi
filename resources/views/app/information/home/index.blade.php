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
                <div class="card-title">User Data</div><br>
            </div>
            <div class="card-body">
                @component('components.table', ['data' => $data, 'props' => []])
                    @scopedslot('head', ($item))
                        @if($item->name === 'ID')
                            <th style="width: 3%">{{ $item->name }}</th>
                        @elseif ($item->name === 'ACTION')
                            <th style="width: 112px" class="hide">{{ $item->name }}</th>
                        @else
                            <th style="position: relative;cursor: pointer" onClick="sortBy('{{ $item->name }}', '{{ !empty($_GET['sort_type']) ? $_GET['sort_type'] : '' }}' )">
                                {{ $item->name }}

                                <?php if(!empty($_GET['sort_type']) && $_GET['sort_type'] == 'asc' && $_GET['sort'] == $item->name): ?>
                                <span>
                                    <i class="fas fa-angle-up text-grey" style="position: absolute;top: 10px;right: 10px;color: #757575;"></i>
                                </span>
                                <?php elseif(!empty($_GET['sort_type']) && $_GET['sort_type'] == 'desc' && $_GET['sort'] == $item->name): ?>
                                <span>
                                    <i class="fas fa-angle-down" style="position: absolute;top: 18px;right: 10px;color: #757575;"></i>
                                </span>
                                <?php else: ?>
                                    <span>
                                        <i class="fas fa-angle-up text-grey" style="position: absolute;top: 10px;right: 10px;color: #757575;"></i>
                                        <i class="fas fa-angle-down" style="position: absolute;top: 18px;right: 10px;color: #757575;"></i>
                                    </span>
                                <?php endif; ?>
                            </th>
                        @endif
                    @endscopedslot
                    @scopedslot('record', ($item, $props))
                        <tr>
                            <td class="v-align-middle ">
                                <p>{{ $item->id }}</p>
                            </td>
                            <td class="v-align-middle ">
                                <p>{{ $item->title }}</p>
                            </td>
                            <td class="v-align-middle ">
                                <p>{{ $item->content }}</p>
                            </td>
                            <td class="v-align-middle ">
                                <p>{{ $item->created_at }}</p>
                            </td>
                            <td class="v-align-middle">
                                <div class="btn-group">
                                    <a href="{{ url('/information/'.$item->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ url('/information/edit/'.$item->id) }}" class="btn btn-success"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#modalDelete" data-toggle="modal" data-record-id="{{$item->id}}" data-record-name="{{$item->name}}" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endscopedslot


                @endcomponent
            </div>
        </div>
    </div>
    {{-- Detail Modal --}}
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
    @include('app.information.home.scripts.index')
@endsection
