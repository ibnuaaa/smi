@extends('layout.app')

@section('title', 'Preview Surat')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<?php setlocale(LC_ALL, 'id-ID'); ?>
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">SURAT</div><br>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @if (!empty(env('ESIGN_USE')) && env('ESIGN_USE') == 'Y' && !empty($data->signed_pdf_path))
                            <iframe src="{{ $config['protocol'] }}://{{ env('APP_DOMAIN') }}/pdf/{{ str_replace('/','0!0', $config['esign_url'] . $data->signed_pdf_path) }}" width="100%" height="600px"></iframe>
                        @else
                            <iframe src="{{ url('/surat/pdf/' . $mail_id) }}" width="100%" height="600px"></iframe>
                        @endif
                    </div>

                    @include('app.preview.actions')

                </div>
            </div>
        </div>
    </div>

    @include('app.preview.modals')

@endsection

@section('script')
    @include('app.preview.scripts.index')
@endsection
