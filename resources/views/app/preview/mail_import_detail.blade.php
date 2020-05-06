@extends('layout.app')

@section('title', 'Preview Surat')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">UPLOAD SURAT MASUK</div><br>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 color-black font-surat font-size-surat">




                        <div class="panel">
                            <ul class="nav nav-tabs nav-tabs-simple">
                                <li class="active">
                                    <a data-toggle="tab" class="active show" href="#tab1">Surat</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab2">Riwayat Disposisi</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="row column-seperation">
                                        <div style="margin:0px auto;width:100%;">
                                            @include('app.preview.mail_import_detail_include')
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab2">
                                    <div class="row column-seperation">
                                        <div style="margin:0px auto;width:100%;">
                                            @include('app.disposition.history')
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>











                            <div class="col-md-12 p-t-20 text-center">
                                @if ($eselon_id < 4)
                                <a class="btn btn-primary" href="/disposisi/new/{{ $mail_id }}">
                                    Disposisi
                                </a>
                                @endif

                                @if ($data->created_user_id == MyAccount()->id)
                                    @if ($data->status == '0')
                                    <a class="btn btn-success" href="/upload_surat_masuk/edit/{{ $mail_id }}">
                                        Edit
                                    </a>

                                    <button class="btn btn-primary" id="KirimUploadSuratMasuk">
                                        Kirim Surat
                                    </button>
                                    @endif
                                @endif
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.preview.scripts.index')
@endsection


