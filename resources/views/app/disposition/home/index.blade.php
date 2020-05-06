@extends('layout.app')

@section('title', 'Surat Masuk')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Disposisi Surat</div><br>
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
                        @elseif ($item->name === 'tgl disposisi')
                            <th style="width: 130px">{{ $item->name }}</th>
                        @else
                            <th>{{ $item->name }}</th>
                        @endif
                    @endscopedslot
                    @scopedslot('record', ($item, $props))
                        <tr>
                            <td class="v-align-top ">
                                {{ dateIndo($item->created_at) }}<br />
                                {{ timeIndo($item->created_at) }}
                            </td>
                            <td class="v-align-top ">
                                <p>{{ $item->mail_number }}</p>
                            </td>
                            <td class="v-align-top ">
                                <p>
                                    {{ $item->source_position->shortname }}
                                </p>
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
                                    <a href="{{ url('disposisi/detail/' . $item->disposition->id) }}" class="btn btn-xs btn-success btn-table-action">
                                        Preview
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endscopedslot

                    {{-- @scopedslot('head', ($item))
                        @if($item->name === 'id')
                            <th style="width: 3%">{{ $item->name }}</th>
                        @elseif ($item->name === 'action')
                            <th style="width: 10%">{{ $item->name }}</th>
                        @else
                            <th>{{ $item->name }}</th>
                        @endif
                    @endscopedslot
                    @scopedslot('record', ($item, $props))
                        <tr>
                            <td class="v-align-middle ">
                                <p>{{ $item->id }}</p>
                            </td>
                            <td class="v-align-middle ">
                                <p>{{ $item->mail_to }}</p>
                            </td>
                            <td class="v-align-middle">
                                <p>{{ $item->created_at }}</p>
                            </td>
                            <td class="v-align-middle">
                                <div class="btn-group">
                                    <a href="{{ url('/user/'.$item->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ url('/user/edit/'.$item->id) }}" class="btn btn-success"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#modalDelete" data-toggle="modal" data-record-id="{{$item->id}}" data-record-name="{{$item->name}}" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endscopedslot--}}
                @endcomponent
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.user.home.scripts.index')
@endsection
