<div class="modal fade slide-up disable-scroll" id="modalRejectNote"  role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content-wrapper" style="vertical-align:top;">
            <div class="modal-content" style="top:50px;">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close fs-14"></i>
                    </button>
                    <h5>Reject Surat</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <textarea class="form-control" name="reject_reason" required></textarea>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-md-12 text-center">
                            <button id="Reject" class="btn btn-danger">
                                Reject
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade slide-up disable-scroll" id="modalLampiran"  role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper" style="vertical-align:top;">
            <div class="modal-content" style="top:50px;">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close fs-14"></i>
                    </button>
                    <h5>Lampiran</h5>
                </div>
                <div class="modal-body">
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
        </div>
    </div>
</div>

<div class="modal fade slide-up disable-scroll" id="modalPassPhrase"  role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper" style="vertical-align:top;">
            <div class="modal-content" style="top:50px;">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close fs-14"></i>
                    </button>
                    <h5>Otentikasi eSign</h5>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="passphraseForm">
                        @if (empty(MyAccount()->nik))
                        <div class="form-group form-group-default required ">
                            <label>NIK</label>
                            <input type="text" class="form-control" value="" name="nik" required/>
                        </div>
                        @endif
                        <div class="form-group form-group-default required ">
                            <label>Passphrase</label>
                            <input type="password" class="form-control" value="" name="passphrase" required/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="ApproveUsingPassphrase">
                        <i class="fas fa-"></i>
                        Approve
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade slide-up disable-scroll" id="modalMailNumber"  role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper" style="vertical-align:top;">
            <div class="modal-content" style="top:50px;">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close fs-14"></i>
                    </button>
                    <h5>Input Nomor Surat</h5>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="passphraseForm">
                        <div class="form-group form-group-default required ">
                            <label>Nomor</label>
                            <input type="text" class="form-control" value="{{ $last_mail_number }}" name="mail_number_from_tu" required/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="SaveMailNumber">
                        <i class="fas fa-"></i>
                        Simpan Nomor Surat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
