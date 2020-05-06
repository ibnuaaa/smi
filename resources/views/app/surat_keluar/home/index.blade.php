@extends('layout.app')

@section('title', 'Surat Keluar')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Data Surat Keluar</div><br>
            </div>
            <div class="card-body">
                @component('components.table', ['data' => $data, 'props' => []])
                    @scopedslot('head', ($item))
                        @if($item->name === 'ID')
                            <th style="width: 3%">{{ $item->name }}</th>
                        @elseif ($item->name === 'action')
                            <th style="width: 95px">{{ $item->name }}</th>
                        @elseif ($item->name === 'status')
                            <th style="width: 110px">{{ $item->name }}</th>
                        @elseif ($item->name === 'hal')
                            <th style="width: 120px">{{ $item->name }}</th>
                        @elseif ($item->name === 'no')
                            <th style="width: 120px">{{ $item->name }}</th>
                        @elseif ($item->name === 'tgl dibuat')
                            <th style="width: 120px">{{ $item->name }}</th>
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
                            <td class="v-align-top ">
                                <p>{{ dateIndo($item->created_at) }} <br />
                                    {{ timeIndo($item->created_at) }}
                                </p>
                            </td>
                            <td class="v-align-top ">
                                <p>{{ $item->mail_number }}</p>
                            </td>
                            <td class="v-align-top ">
                                @if ($item->mail_destination)
                                    <ol style="padding-left: 0px;">
                                        <?php foreach ($item->mail_destination as $key => $value) : ?>
                                            <li style="white-space: normal;">
                                                {{ !empty($value->position->shortname) ? $value->position->shortname : '' }} /
                                                (Pejabat: {{ !empty($value->position->user->name) ? $value->position->user->name : '' }}
                                                NIP.{{ !empty($value->position->user->username) ? $value->position->user->username : '' }})
                                            </li>
                                        <?php endforeach ?>
                                    </ol>
                                @endif
                            </td>
                            <td class="v-align-top ">
                                <p>{{ $item->about }}</p>
                            </td>
                            <td class="v-align-top ">
                                <label class="btn btn-{{ config('app.mail_out_status_color.' . $item->status) }} btn-xs">
                                    {{ config('app.mail_out_status.' . $item->status) }}
                                </label>
                            </td>

                            <td class="v-align-top">
                                <div class="btn-group">
                                    @if (in_array($item->mail_template_id, array(1,2,3)))
                                    <a href="{{ url('surat/preview/' . $item->id . '/surat_keluar') }}" class="btn btn-xs btn-success btn-table-action">Preview</a>
                                    @elseif ($item->mail_template_id == 9)
                                    <a href="{{ url('surat/mail_import_detail/' . $item->id) }}" class="btn btn-xs btn-success btn-table-action">Preview</a>
                                    @else
                                    <a href="{{ url('disposisi/detail/' . ($item->disposition && $item->disposition->id ? $item->disposition->id : '')) }}" class="btn btn-xs btn-success btn-table-action">Preview</a>
                                    @endif
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
    @include('app.surat_keluar.home.scripts.form')
@endsection
