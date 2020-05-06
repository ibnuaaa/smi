@extends('layout.app')

@section('title', 'Surat Masuk')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">
                    <span>Data Surat Masuk</span>
                </div>
                <i class="pull-right"><span class="btn btn-warning">D</span> : Disposisi</i>
                <br>
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
                        @elseif ($item->name === 'tgl masuk')
                            <th style="width: 140px">{{ $item->name }}</th>
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
                                <p style="white-space: normal;">
                                    {{ dateIndo($item->sent_at) }}<br />
                                    {{ timeIndo($item->sent_at) }}
                                </p>
                            </td>
                            <td class="v-align-middle ">
                                <p>{{ $item->mail_number }}</p>
                            </td>
                            <td class="v-align-middle ">
                                <p>

                                    @if (in_array($item->mail_template_id, array(1,2,3)))

                                    @elseif ($item->mail_template_id == 9)

                                    @else
                                        <span class="btn btn-warning btn-xs" title="Surat Disposisi">D</span>
                                    @endif

                                    <span title="{{ $item->source_position ? $item->source_position->name : '' }}">
                                        @if ($item->mail_template_id == 9)
                                            {{ $item->source_external }}
                                        @else
                                            {{ $item->source_position ? $item->source_position->shortname : '' }}
                                        @endif
                                    </span>
                                </p>
                            </td>
                            <td class="v-align-middle ">
                                <p>{{ $item->about }}</p>
                            </td>
                            <td class="v-align-middle ">
                                <label class="btn btn-{{ config('app.mail_out_status_color.' . (!empty($item->my_inbox->status) ? $item->my_inbox->status : '0')) }} btn-xs">
                                    {{ config('app.mail_in_status.' . (!empty($item->my_inbox->status) ? $item->my_inbox->status : '0')) }}
                                </label>
                            </td>

                            <td class="v-align-middle">
                                <div class="btn-group">
                                    @if (in_array($item->mail_template_id, array(1,2,3)))
                                    <a href="{{ url('surat/preview/' . $item->id . '/surat_masuk') }}" class="btn btn-xs btn-success btn-table-action">Preview</a>
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
@endsection

@section('script')
    @include('app.surat_masuk.home.scripts.form')
@endsection
