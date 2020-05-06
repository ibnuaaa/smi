@extends('layout.app')

@section('title', 'Notifikasi')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Data Notifikasi</div><br>
            </div>
            <div class="card-body">
                @component('components.table', ['data' => $data, 'props' => []])
                    @scopedslot('head', ($item))
                        @if($item->name === 'TANGGAL')
                            <th style="width: 20%">{{ $item->name }}</th>
                        @else
                            <th style="width: 80%;">{{ $item->name }}</th>
                        @endif
                    @endscopedslot
                    @scopedslot('record', ($item, $props))
                        <tr>
                            <td class="v-align-top ">
                                <p>{{ $item->created_at }}</p>
                            </td>
                            <td class="v-align-top ">
                                <p style="white-space: normal !important;">
                                    {!! $item->notification_text !!}
                                </p>
                            </td>
                        </tr>
                    @endscopedslot
                @endcomponent
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.user.home.scripts.index')
@endsection
