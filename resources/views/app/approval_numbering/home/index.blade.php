@extends('layout.app')

@section('title', 'Surat Masuk')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Permintaan Penomoran Surat</div><br>
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
                            <td class="v-align-top " >
                                <p style="white-space: normal;">
                                    {{ dateIndo($item->created_at) }} <br />
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
                                                {{ !empty($value->position->name) ? $value->position->shortname : '' }} /
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
                                <label class="btn btn-{{ config('app.mail_approval_color.' . $item->mail_number_status) }} btn-xs">
                                    {{ config('app.mail_number_status.' . $item->mail_number_status) }}
                                </label>
                            </td>

                            <td class="v-align-top">
                                <div class="btn-group">
                                    <a href="{{ url('surat/preview/' . $item->id. '/approval_numbering') }}" class="btn btn-xs btn-success btn-table-action">
                                        Detail
                                    </a>
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
    @include('app.approval.home.scripts.form')
@endsection
