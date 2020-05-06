@extends('layout.app')

@section('title', 'Information')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">User Data</div><br>
            </div>
            <div class="card-body">
                @component('components.table', ['data' => $data, 'props' => []])
                    @scopedslot('head', ($item))
                        @if($item->name === 'ID')
                            <th style="width: 3%">{{ $item->label }}</th>
                        @else
                            <th>{{ $item->label }}</th>
                        @endif
                    @endscopedslot
                    @scopedslot('record', ($item, $props))
                        <tr>
                            <td>
                                <p>{{ $item->id }}</p>
                            </td>
                            <td>
                                <p>{{ $item->type }}</p>
                            </td>
                            <td>
                                <p>{{ $item->length }}</p>
                            </td>
                            <td>
                                <p>{{ $item->last_value }}</p>
                            </td>
                            <td>
                                <p>{{ $item->description }}</p>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ url('/config_numbering/edit/'.$item->id) }}" class="btn btn-success"><i class="fas fa-pencil-alt"></i></a>
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
    @include('app.config_numbering.home.scripts.index')
@endsection
