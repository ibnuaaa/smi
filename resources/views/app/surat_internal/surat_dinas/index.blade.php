@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        @if (true)
            <div class="card card-white">
                <div class="card-body">
                    <form id="saveMailForm">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ $mail_template->name }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Dari</label>
                                </div>
                            </div>
                            <div class="col-10">
                                @component('components.form.awesomeSelect', [
                                    'name' => 'source_position_id',
                                    'items' => $select['source_positions'],
                                    'selected' => $selected['source_position_id']
                                ])
                                @endcomponent
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Tujuan / Penerima</label>
                                </div>
                            </div>
                            <div class="col-10 p-b-5" id="mail_to_container">

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-10 text-center">
                                <button class="btn btn-primary m-b-10" onClick="return addMailTo()">
                                    <i class="fas fa-plus"></i>
                                    Add
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Pemutus / Signer</label>
                                </div>
                            </div>
                            <div class="col-10" id="checker_signer_container">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-10 text-center">
                                <button class="btn btn-primary m-b-10" onClick="return addCheckerSigner()"><i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>

                        @if ($mail_template->mail_code == 'SURAT_TUGAS')
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Dasar</label>
                                </div>
                            </div>
                            <div class="col-10" id="dasar_container">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-10 text-center">
                                <button class="btn btn-primary m-b-10" onClick="return addDasar()"><i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>
                                        Lampiran
                                    </label>
                                </div>
                            </div>
                            <div class="col-10">

                                <div class="form-group form-group-default">
                                    <input type="file" onchange="prepareUpload(this);" multiple>
                                    <div class="img-preview-lampiran" id="img-preview"><div style="clear: both;"></div></div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Sifat</label>
                                </div>
                            </div>
                            <div class="col-10">
                                @component('components.form.awesomeSelect', [
                                    'name' => 'privacy_type',
                                    'items' => [
                                        ['value' => '1', 'label' => 'Sangat Segera'],
                                        ['value' => '2', 'label' => 'Segera'],
                                        ['value' => '3', 'label' => 'Biasa'],
                                        ['value' => '4', 'label' => 'Penting'],
                                        ['value' => '5', 'label' => 'Rahasia']
                                    ],
                                    'selected' => !empty($selected['privacy_type']) ? $selected['privacy_type'] : ''
                                ])
                                @endcomponent
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Nomor Surat</label>
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="input-group row">
                                    <div class="col-md-4 input-group-prepend">
                                        <select name="mail_number_prefix" class="form-control"></select>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        /
                                    </div>
                                        <input name="mail_number_infix" class="col-md-2  form-control" type="text" disabled value="Terisi Otomatis">
                                    <div class="col-md-1 text-center">
                                        /
                                    </div>
                                    <div class="col-md-4 input-group-append">
                                        <input name="mail_number_suffix" value="" class="form-control" type="text" placeholder="Kode Satuan Kerja">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Tembusan</label>
                                </div>
                            </div>
                            <div class="col-10">
                                <div id="mail_copy_to_container" class="m-b-5">

                                </div>
                                <div class="m-b-10 text-center">
                                    <button class="btn btn-primary m-b-10" onClick="return addMailCopyTo()">
                                        Add
                                    </button>
                                </div>
                                <textarea class="form-control" name="tembusan" style="height:100px;" placeholder="Inputan ini untuk tembusan untuk yang diluar kemendagri, penulisan dipisahkan dengan tanda koma (,)"></textarea>
                            </div>
                        </div>

                        <div class="row m-t-10">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Hal</label>
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="form-group form-group-default required">
                                    <input name="about" value="-" class="form-control" type="text" placeholder="Perihal Surat Diisi Secara Manual">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Tanggal Surat</label>
                                </div>
                            </div>
                            <div class="col-10">
                                <div id="myDatepicker" class="input-group date">
                                    <label class="text-dark">
                                        {{ date('d M Y') }}
                                    </label>
                                    <input name="mail_date" type="hidden" value="{{ date('Y-m-d') }}" class="form-control" placeholder="Tanggal Surat" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Isi Surat</label>
                                </div>
                            </div>
                            <div class="col-10">
                                <div id="editor">{!! $mail_template->content !!}</div>
                                <br />
                            </div>
                        </div>
                        <div class="row hide">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>
                                        Ditandatangani di
                                    </label>
                                </div>
                            </div>
                            <div class="col-10">
                                <input name="sign_location" id="text" value="Jakarta" class="form-control" type="text" placeholder="Lokasi Penandatanganan">
                            </div>
                        </div>
                        <div class="row m-t-10">
                            <div class="col-2">
                            </div>
                            <div class="col-10" id="actions">
                                @if (!$id)
                                <button class="btn btn-primary saveAction" id="draft">
                                    Simpan Draft
                                </button>

                                <button class="btn btn-success saveAction" id="kirim">
                                    Simpan & Kirim
                                </button>

                                @endif
                                @if ($id)
                                <button class="btn btn-primary saveUpdateAction" id="draft">
                                    Simpan
                                </button>

                                @if ($eselon_id == 5)
                                <button class="btn btn-success saveUpdateAction" id="kirim">
                                    Simpan & Kirim
                                </button>
                                @endif
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="card card-white">
                <div class="card-header ">
                    <div class="card-title">
                        MOHON MAAF, UNTUK SAAT INI FUNGSI BUAT SURAT HANYA ADA DI LEVEL STAFF SAJA. TERIMAKASIH
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
    @include('app.surat_internal.surat_dinas.scripts.form')
@endsection
