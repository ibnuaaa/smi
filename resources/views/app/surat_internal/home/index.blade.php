@extends('layout.app')

@section('title', 'Surat Internal')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg"">
        <div class="card card-white" style="min-height: 700px;">
            <div class="container-fluid container-fixed-lg row p-t-10">
                @if (true)
                    @foreach ($mail_template as $val)
                    <div class="card card-white col-md-3">
                        <div class="card-header ">
                            <div class="card-title">
                                {{ $val->name }}
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="{{ url('/surat_internal/new_surat/' . $val->id) }}">
                                <img alt="" src="{{ url('/assets/img/surat/' . $val->mail_code) }}.png" width="100%" style="border:solid thin #ccc;"/>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="card card-white col-md-12">
                        <div class="card-header ">
                            <div class="card-title">
                                MOHON MAAF, UNTUK SAAT INI FUNGSI BUAT SURAT HANYA ADA DI LEVEL STAFF SAJA. TERIMAKASIH
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
