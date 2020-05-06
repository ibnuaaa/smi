<div class="row">
    <div class="col-12 text-center">
        <button class="btn btn-danger" onClick="back_page()">
            Kembali
        </button>
            <a class="btn btn-primary" href="{{ url('/disposisi/pdf/' . $id) }}" target="_blank">
                PDF Disposisi
            </a>


        @if ($mail->source_position_id != MyAccount()->position_id && $eselon_id < 4)
            <a class="btn btn-primary" href="{{ url('/disposisi/new/'.$mail->id) }}">
                Disposisi
            </a>
        @endif

        @if ($disposition->disposition_position != MyAccount()->position_id)
        <input type="button" class="btn btn-primary" onClick="openModalReplyAdd()" value="Balas Disposisi" />
        <input type="button" class="btn btn-primary" onClick="openModalReplyAddMail()" value="Balas Disposisi Dengan Surat" />
        @endif
    </div>
</div>


<div class="modal fade slide-up disable-scroll" id="modalReplyMessage"  role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content-wrapper" style="vertical-align:top;">
            <div class="modal-content" style="top:50px;">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close fs-14"></i>
                    </button>
                    <h5>Balasan Disposisi</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="editor"></div>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-md-12 text-center">
                            <input type="button" onClick="saveReplyDisposition()" class="btn btn-primary" value="Simpan" />

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade slide-up disable-scroll" id="modalReplyMessageMail"  role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content-wrapper" style="vertical-align:top;">
            <div class="modal-content" style="top:50px;">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close fs-14"></i>
                    </button>
                    <h5>Pilih Surat</h5>
                </div>
                <div class="modal-body">

                    <ol>
                        <li>
                            <a href="/surat_internal/new_surat/1/balasan_disposisi/{{ $disposition_id }}">Undangan</a>
                        </li>
                        <li>
                            <a href="/surat_internal/new_surat/2/balasan_disposisi/{{ $disposition_id }}">Nota Dinas</a>
                        </li>
                        <li>
                            <a href="/surat_internal/new_surat/3/balasan_disposisi/{{ $disposition_id }}">Surat Tugas</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    @include('app.disposition.scripts.form')
@endsection
