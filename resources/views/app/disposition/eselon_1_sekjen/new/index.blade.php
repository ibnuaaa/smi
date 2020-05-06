@extends('layout.app')

@section('title', 'Surat Masuk')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Disposisi Surat (ESELON 1 SEKJEN KE ESELON 2)</div><br>
            </div>
            <div class="card-body">
                <form id="NewDispositionForm">

                    <div class="row">
                        <div class="col-md-12">
                                <table class="tablea table-condenseda table-borderlessa text-dark" border="0" style="width:100%;">
                                    <tbody class="">
                                        <tr>
                                            <td width="5%"></td>
                                            <td width="10%"></td>
                                            <td width="30%"></td>
                                            <td width="20%"></td>
                                            <td width="20%"></td>
                                            <td width="5%"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <th class=" ">Surat Dari</th>
                                            <td class=" ">
                                                {{ $master_mail->source_position ? $master_mail->source_position->shortname : $master_mail->source_external }}
                                            </td>
                                            <th class="">Diterima Tgl</th>
                                            <td class=" ">
                                                <i>(Otomatis setelah disposisi)</i>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <th class="">No Surat</th>
                                            <td class="">
                                                {{ $master_mail->mail_number ? $master_mail->mail_number : $master_mail->mail_number_ext }}
                                            </td>
                                            <th>Pukul</th>
                                            <td class="">
                                                <i>(Otomatis setelah disposisi)</i>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <th class="">Tgl Surat</th>
                                            <td class="">{{ $master_mail->mail_mail_date }}</td>
                                            <th>No Agenda</th>
                                            <td class="">
                                                <i>(Otomatis setelah disposisi)</i>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td class="">&nbsp;</td>
                                            <td class="">&nbsp;</td>
                                            <th valign="top">Sifat</th>
                                            <td class="">
                                                @if (!empty($mail_detail['sangat_segera']))
                                                    Sangat Segera <br/>
                                                @endif
                                                @if (!empty($mail_detail['segera']))
                                                    Segera<br/>
                                                @endif
                                                @if (!empty($mail_detail['rahasia']))
                                                    Rahasia<br/>
                                                @endif
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td class=" b-b">&nbsp;</td>
                                            <td class=" b-b">&nbsp;</td>
                                            <td class=" b-b" colspan="2">
                                                {{ config('app.mail_privacy_type.' . $master_mail->privacy_type) }}
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td class="">
                                                <strong>
                                                    Hal
                                                </strong>
                                            </td>
                                            <td colspan="4">{{ $master_mail->about }}</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="" colspan="3" style="vertical-align:top;">
                                                <strong>
                                                    Di Disposisikan kepada :
                                                </strong>
                                                <br />
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @foreach ($child_positions as $key => $val)
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="chk{{$val->id}}" value="{{$val->id}}" name="disposition_position_id">
                                                                <label class="custom-control-label" for="chk{{$val->id}}">{{$val->shortname}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-md-6">
                                                        @foreach ($equal_positions as $key => $val)
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="chk{{$val->id}}" value="{{$val->id}}" name="disposition_position_id">
                                                                <label class="custom-control-label" for="chk{{$val->id}}">{{$val->shortname}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 p-b-5" id="mail_to_container">

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <button class="btn btn-primary m-b-10 btn-xs" onClick="return addMailTo()">
                                                            <i class="fas fa-plus"></i>
                                                            Tambah
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-l-50" colspan="1" style="vertical-align:top;">
                                                <b>Dengan Hormat harap</b>
                                                <br />
                                                <table style="width:100%;" id="tableFollowUp">
                                                @if (!empty($disposition_follow_up))
                                                    <tr>
                                                        <td style="width:5%;"></td>
                                                        <td></td>
                                                    </tr>
                                                    @foreach($disposition_follow_up as $key => $val)
                                                    <tr>
                                                        <td><input type="checkbox" name="chk" value="{{$val->code}}"></td>
                                                        <td>{{$val->name}}</td>
                                                    </tr>
                                                    @endforeach
                                                @endif


                                                </table>
                                                <div style="width:100%;text-align: center;">
                                                    <button class="btn btn-primary btn-xs" onClick="addFollowUp()">
                                                        Tambah
                                                    </button>
                                                </div>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="4">

                                                <strong>
                                                    Catatan
                                                </strong>
                                                <br/>
                                                <textarea class="form-control" id="text" name="notes"></textarea>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                    </tbody>
                                </table>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <button class="btn btn-danger" onClick="back_page()">
                                Kembali
                            </button>
                            <button class="btn btn-primary" id="saveAction">
                                Simpan dan Kirim
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.disposition.new.scripts.disposition_form')
@endsection
