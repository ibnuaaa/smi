
                        <div class="row">
                            <div class="col-6">

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group pull-right">
                                            <label>Pengirim</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->source_external }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group pull-right">
                                            <label>Tujuan</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <ol style="margin-left:-29px;">
                                            @if (!empty($data->mail_destination))
                                                @foreach ($data->mail_destination as $key => $val)
                                                    @if ($val->position)
                                                        <li>{!! $val->position->name !!}</li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ol>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group pull-right">
                                            <label>Sifat</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        {{ config('app.mail_privacy_type.' . $data->privacy_type) }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group pull-right">
                                            <label>No Surat Ext</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->mail_number_ext }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group pull-right">
                                            <label>Tanggal Surat</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        {{ dateIndo($data->mail_date) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group pull-right">
                                            <label>Tanggal Diterima</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        {{ dateIndo($data->receive_date) }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group pull-right">
                                            <label>Hal</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->about }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group pull-right">
                                            <div class="img-preview-lampiran" id="img-preview"><div style="clear: both;"></div></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row hide">
                                    <div class="col-4">
                                        <div class="form-group pull-right">
                                            <label>No Surat Int</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->mail_number_int }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group pull-right">
                                            <label>Notes</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->notes }}
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Files</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width:10%">
                                            Image
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
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
