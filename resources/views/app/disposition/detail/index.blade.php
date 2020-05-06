@extends('layout.app')

@section('title', 'Surat Masuk')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Disposisi {{ $title }}</div><br>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <div class="panel">
                            <ul class="nav nav-tabs nav-tabs-simple">
                                <li class="active">
                                    <a data-toggle="tab" class="active show" href="#tab1">Disposisi</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab2">Surat</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab3">Riwayat Disposisi</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab4">Balasan</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab5">Surat Balasan</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="row column-seperation">
                                        <div class="col-12">
                                            <div style="margin:0px auto;width:100%;">
                                                <iframe src="{{ url('/disposisi/pdf/' . $id) }}" width="100%" height="600px"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="margin:0px auto;width:100%;">
                                                @if ($data->mail_template_id == '9')
                                                    @include('app.preview.mail_import_detail_include')
                                                @else
                                                    @if (!empty(env('ESIGN_USE')) && env('ESIGN_USE') == 'Y' && !empty($data->signed_pdf_path))
                                                        <iframe src="{{ env('ESIGN_URL') . $data->signed_pdf_path }}" width="100%" height="600px"></iframe>
                                                    @else
                                                        <iframe src="{{ url('/surat/pdf/' . $mail_id) }}" width="100%" height="600px"></iframe>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="margin:0px auto;width:100%;">
                                                @include('app.disposition.history')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="margin:0px auto;width:100%;">
                                                @include('app.disposition.replies')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="margin:0px auto;width:100%;">
                                                @include('app.disposition.mail_replies')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
                @include('app.disposition.actions')
            </div>
        </div>
    </div>
@endsection
