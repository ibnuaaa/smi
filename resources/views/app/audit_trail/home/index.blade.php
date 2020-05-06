@extends('layout.app')

@section('title', 'Audit Trail')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">

        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Audit Trail</div><br>
            </div>
            <div class="card-body">
                @component('components.table', ['data' => $data, 'props' => []])
                    @scopedslot('head', ($item))
                        @if($item->name === 'ID')
                            <th style="width: 3%">{{ $item->name }}</th>
                        @elseif ($item->name === 'ACTION')
                            <th style="width: 112px" class="hide">{{ $item->name }}</th>
                        @else
                            <th>
                                {{ $item->name }}
                            </th>
                        @endif
                    @endscopedslot
                    @scopedslot('record', ($item, $props))
                        <tr onClick="openModalDetail('{{ $item->id }}')">
                            <td>
                                <p>{{ $item->created_at }}</p>
                            </td>
                            <td>
                                <p>{{ $item->id }}</p>
                            </td>
                            <td>
                                <p>{{ $item->modul }}</p>
                            </td>
                            <td>

                                @if ($item->activity == 'Insert')
                                    <span class="btn btn-primary btn-xs">{{ $item->activity }}</span>
                                @elseif ($item->activity == 'Update')
                                    <span class="btn btn-warning btn-xs">{{ $item->activity }}</span>
                                @elseif ($item->activity == 'Delete')
                                    <span class="btn btn-danger btn-xs">{{ $item->activity }}</span>
                                @else
                                    <span class="btn">{{ $item->activity }}</span>
                                @endif

                            </td>
                            <td>
                                <p>{{ $item->ip_client }}</p>
                            </td>
                            <td>
                                <p>{{ $item->browser }}</p>
                            </td>
                        </tr>
                    @endscopedslot
                @endcomponent
            </div>
        </div>
    </div>
    {{-- Detail Modal --}}
    <div class="modal fade slide-up disable-scroll" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <h5>
                            <span class="semi-bold">
                                Audit Trail Detail
                            </span>
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered table-condensed" style="width:900px;">
                                    <tr>
                                        <td>Dibuat pada</td>
                                        <td id="created_at"></td>
                                    </tr>
                                    <tr>
                                        <td>ID</td>
                                        <td id="id"></td>
                                    </tr>
                                    <tr>
                                        <td>Modul</td>
                                        <td id="modul"></td>
                                    </tr>
                                    <tr>
                                        <td>Aktivitas</td>
                                        <td id="activity"></td>
                                    </tr>
                                    <tr>
                                        <td>IP</td>
                                        <td id="ip_client"></td>
                                    </tr>
                                    <tr>
                                        <td>Browser</td>
                                        <td id="browser"></td>
                                    </tr>
                                    <tr>
                                        <td>User ID</td>
                                        <td id="user_id"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <iframe id="data_iframe" src="" style="width:100%; height:100%;"></iframe>>
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
    @include('app.audit_trail.home.scripts.index')
@endsection
