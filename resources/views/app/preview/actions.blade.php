                    <div class="col-md-12 p-t-20 text-center">

                        @if (!empty(env('ESIGN_USE')) && env('ESIGN_USE') == 'Y' && !empty($data->signed_pdf_path))
                        <a class="btn btn-primary" href="{{ $config['esign_url'] . $data->signed_pdf_path }}" target="_blank">
                            PDF
                        </a>
                        @else
                        <a class="btn btn-primary" href="{{ url('/surat/pdf/' . $mail_id) }}" target="_blank">
                            PDF
                        </a>
                        @endif

                        @if ($is_approval)
                            @if ($is_show_approval_button)
                                @if (!empty(env('ESIGN_USE')) && env('ESIGN_USE') == 'Y')

                                    @if (!empty($data->signer->position_id)  && $data->signer->position_id == MyAccount()->position_id)

                                        @if (!empty($data->mail_number_status) && $data->mail_number_status == '3')
                                            <button type="button" class="btn btn-primary" id="Passphrase">
                                                <i class="fas fa-check"></i>
                                                e-Sign
                                            </button>
                                        @elseif (!$data->mail_number_status)
                                            <button type="button" class="btn btn-primary" id="RequestNomor">
                                                <i class="fas fa-check"></i>
                                                Approve & Request Nomor
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger" id="CancelRequestNomor">
                                                <i class="fas fa-check"></i>
                                                Cancel Request Nomor
                                            </button>
                                        @endif
                                    @else
                                        <button type="button" class="btn btn-primary" id="Approve">
                                            <i class="fas fa-check"></i>
                                            Approve
                                        </button>
                                    @endif

                                @else
                                    @if (!empty($data->mail_number_status) && $data->mail_number_status == '3')
                                        <button type="button" class="btn btn-primary" id="Approve">
                                            <i class="fas fa-check"></i>
                                            e-Sign
                                        </button>
                                    @elseif (empty($data->mail_number_status) && $data->mail_number_status == '0')
                                        <button type="button" class="btn btn-primary" id="RequestNomor">
                                            <i class="fas fa-check"></i>
                                            Approve & Request Nomor
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger" id="CancelRequestNomor">
                                            <i class="fas fa-check"></i>
                                            Cancel Request Nomor
                                        </button>
                                    @endif
                                @endif

                                @if ($data->mail_number_status === 0)
                                    <a href="#modalRejectNote" data-toggle="modal" data-record-id="{{$data->id}}" data-record-name="{{$data->id}}" class="btn btn-danger">
                                        Reject
                                    </a>
                                @endif

                                <a class="btn btn-primary" href="{{ url('/surat_internal/surat/edit/' . $data->id) }}">
                                    Edit
                                </a>
                            @else
                                @if (!empty(env('ESIGN_USE')) && env('ESIGN_USE') == 'Y')
                                    @if (!empty($data->signer->position_id)  && $data->signer->position_id == MyAccount()->position_id)
                                        @if (empty($data->signed_pdf_path))
                                        <button type="button" class="btn btn-primary" id="ReApprove">
                                            <i class="fas fa-check"></i>
                                            Approve Ulang
                                        </button>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        @endif


                        @if ($is_surat_masuk)
                            @if (!$data->disposition)
                                @if ($eselon_id < 4)
                                <a class="btn btn-primary" href="{{ url('/disposisi/new/' . $mail_id) }}">
                                    Disposisi
                                </a>
                                @endif
                                <button class="btn btn-danger" onClick="back_page()">
                                    Kembali
                                </button>
                            @endif
                        @endif

                        @if ($is_approval_numbering)
                            @if (!empty($data->mail_number_status) && $data->mail_number_status != '3')
                                <button type="button" class="btn btn-primary" id="BtnMailNumber">
                                    <i class="fas fa-check"></i>
                                    Input Nomor Surat
                                </button>
                            @endif
                        @endif


                        <div class="col-md-12 text-center m-t-20">
                            @if ($data->status != '0')
                                @foreach ($data->approval as $val)
                                    @if (in_array($val->status, [6,1,2]) && !empty($val->reject_reason))
                                        <div class="col-md-12 text-center text-danger">
                                            Surat ini ditolak oleh
                                            {{ $val->position->name }},
                                            Alasan Ditolak :
                                            {{ $val->reject_reason }}
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>


                        @if ($is_surat_keluar && $maker_user_id = $data->created_user_id && in_array($data->status, [0,6]))
                            <button type="button" class="btn btn-primary" id="Kirim">
                                Kirim
                            </button>
                            <a class="btn btn-primary" href="{{ url('/surat_internal/surat/edit/'.$data->id) }}">
                                Edit
                            </a>
                        @endif

                        <div class="row m-t-50">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="m-t-5 p-t-10 p-b-10 border bg-secondary text-light row">
                                    <div class="col-md-7 text-right">
                                        Maker -
                                        (
                                        {{ $data->user_created_user_id_name }}
                                        /
                                        NIP.{{ $data->user_created_user_id_username }}
                                        )
                                    </div>
                                    <div class="col-md-2 text-left">
                                        {{ config('app.mail_maker_status.' . $data->status) }}
                                    </div>
                                    <div class="col-md-3 text-left">
                                        ({{ $data->creator_request_approval_at }})
                                    </div>
                                </div>

                                @if ($data->status != '0')
                                    @foreach ($data->approval as $val)
                                    <div class="m-t-5 p-t-10 p-b-10 border bg-secondary text-light row">
                                        <div class="col-md-7 text-right">
                                            {{ config('app.mail_approval_type.' . $val->type) }}
                                            (
                                            {{$val->position->user_without_position->name}} /
                                            NIP.{{ $val->position->user_without_position->username }}
                                            )
                                        </div>
                                        <div class="col-md-2 text-left">
                                            {{ config('app.mail_approval_status.' . $val->status) }}
                                        </div>
                                        <div class="col-md-3 text-left">
                                            @if ($val->status == 6)
                                                ({{ $val->rejected_at }})
                                            @else
                                                ({{ $val->approved_at }})
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
