@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-body">
                <form id="saveMailForm">

                    <div class="row">
                        <div class="col-6">

                            <div class="row m-b-10">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="pull-right">Pengirim</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <input name="source_external" value="" class="form-control" type="text" placeholder="">
                                </div>
                            </div>

                            <div class="row m-b-10">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="pull-right">Kepada</label>
                                    </div>
                                </div>
                                <div class="col-8" id="mail_to_container">
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



                            <div class="row m-b-10">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="pull-right">Sifat</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    @component('components.form.awesomeSelect', [
                                        'name' => 'privacy_type',
                                        'items' => [
                                            ['value' => '1', 'label' => 'Sangat Segera'],
                                            ['value' => '2', 'label' => 'Segera'],
                                            ['value' => '3', 'label' => 'Biasa'],
                                            ['value' => '4', 'label' => 'Penting'],
                                            ['value' => '5', 'label' => 'Rahasia']
                                        ],
                                        'selected' => ''
                                    ])
                                    @endcomponent
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="pull-right">Pilih File</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <input type="file" onchange="prepareUpload(this, 'img-preview');" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="row hide">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="pull-right">No Surat Int</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <input name="mail_number_int" id="text" value="" class="form-control" type="text" placeholder="No Surat Int">
                                </div>
                            </div>


                            <div class="row m-b-10">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="pull-right">No Surat Ext</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <input name="mail_number_ext" id="text" value="" class="form-control" type="text" placeholder="No Surat Ext">
                                </div>
                            </div>

                            <div class="row m-b-10">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="pull-right">Tanggal Surat</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <input name="mail_date" id="myDatepicker" type="text" value="{{ date('Y-m-d') }}" class="form-control" placeholder="Tanggal Surat">
                                </div>
                            </div>

                            <div class="row m-b-10">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="pull-right">Tanggal Diterima</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <input name="receive_date" id="myDatepicker" type="text" value="{{ date('Y-m-d') }}" class="form-control" placeholder="Tanggal Surat Diterima">
                                </div>
                            </div>

                            <div class="row m-b-10">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="pull-right">Hal</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <input name="about" type="text" value="" class="form-control" placeholder="Hal">
                                </div>
                            </div>

                            <div class="row m-t-10">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="pull-right">Notes</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <textarea name="notes" class="form-control" type="text"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="img-preview-lampiran" id="img-preview"><div style="clear: both;"></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @if ($id)
                        <div class="col-12 row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Files</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 row">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width:10%">
                                            Preview
                                        </th>
                                        <th style="width:30%">
                                            Filename
                                        </th>
                                        <th style="width:5%">
                                            Filesize
                                        </th>
                                        <th style="width:25%">
                                            Waktu
                                        </th>
                                        <th style="width:25%">
                                            Aksi
                                        </th>
                                    </tr>
                                    @foreach($data->lampiran as $key => $val)
                                        <tr>
                                            <td>
                                                @if (in_array($val->storage->extension, array('jpg','png','bmp')))
                                                    <a href="http://satellite-<?php echo env('APP_DOMAIN'); ?>/storage/{{ $val->storage->key }}">
                                                        <img src="http://satellite-<?php echo env('APP_DOMAIN'); ?>/storage/{{ $val->storage->key }}" style="max-width: 100px" />
                                                    </a>
                                                @else
                                                    <a href="http://satellite-<?php echo env('APP_DOMAIN'); ?>/storage/{{ $val->storage->key }}">
                                                        <i class='fas fa-file' style='height:80px;margin-left:0px;font-size:80px;'></i>
                                                    </a>
                                                @endif

                                            </td>
                                            <td>
                                                <a href="http://satellite-<?php echo env('APP_DOMAIN'); ?>/storage/{{ $val->storage->key }}">
                                                    {{ $val->storage->name }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ convertToReadableSize($val->storage->size) }}
                                            </td>
                                            <td>
                                                {{ $val->storage->created_at }}
                                            </td>
                                            <td>
                                                <input type="button" value="Hapus" class="btn btn-danger btn-xs" onClick="removeFile('{{$val->id}}', this)" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        @endif

                        <div class="col-12">


                            <div class="row m-t-10">
                                <div class="col-12 text-center" id="actions">

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

                                    <button class="btn btn-success saveUpdateAction" id="kirim">
                                        Simpan & Kirim
                                    </button>
                                    @endif

                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>




        @if (empty($id))
            <div class="card card-white">
                <div class="card-header ">
                    <div class="card-title">Data Upload Surat Masuk</div><br>
                </div>
                <div class="card-body">
                    @component('components.table', ['data' => $data, 'props' => []])
                        @scopedslot('head', ($item))
                            @if($item->name === 'ID')
                                <th style="width: 3%">{{ $item->name }}</th>
                            @elseif ($item->name === 'ACTION')
                                <th style="width: 112px">{{ $item->name }}</th>
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
                                <td class="v-align-top ">
                                    <p>{{ $item->mail_mail_date }}</p>
                                </td>
                                <td class="v-align-top ">
                                    <p>{{ $item->mail_number_int }}</p>
                                </td>
                                <td class="v-align-top ">
                                    @if ($item->mail_destination)
                                        <ol style="padding-left: 0px;">
                                            <?php foreach ($item->mail_destination as $key => $value) : ?>
                                                <li>
                                                    {{ !empty($value->position->name) ? $value->position->name : '' }} /
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
                                    <label class="btn btn-{{ config('app.mail_out_status_color.' . $item->status) }} btn-xs">
                                        {{ config('app.mail_out_status.' . $item->status) }}
                                    </label>
                                </td>

                                <td class="v-align-top">
                                    <div class="btn-group">
                                        <a href="{{ url('surat/mail_import_detail/' . $item->id) }}" class="btn btn-xs btn-success btn-table-action">Preview</a>
                                    </div>
                                </td>
                            </tr>
                        @endscopedslot
                    @endcomponent
                </div>
            </div>
        @endif


    </div>
@endsection

@section('script')
    @include('app.upload_surat_masuk.home.scripts.form')
@endsection
