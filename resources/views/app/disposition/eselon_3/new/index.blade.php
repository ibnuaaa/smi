@extends('layout.app')

@section('title', 'Surat Masuk')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-header ">
                <div class="card-title">Disposisi Eselon 3</div><br>
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
                                        <td width="40%"></td>
                                        <td width="15%"></td>
                                        <td width="15%"></td>
                                        <td width="5%"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <th class=" ">Surat Dari</th>
                                        <td class=" ">
                                            {{ $master_mail->source_position ? $master_mail->source_position->shortname : $master_mail->source_external }}
                                        </td>
                                        <th class="">Diterima Tgl</th>
                                        <td class="">
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
                                            {{ config('app.mail_privacy_type.' . $master_mail->privacy_type) }}
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class=" b-b">&nbsp;</td>
                                        <td class=" b-b">&nbsp;</td>
                                        <td class=" b-b" colspan="2">

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
                                        <td>
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
                                        <td>&nbsp;</td>
                                        <td class="" colspan="4" style="vertical-align:top;">

                                            <table style="width:100%;">
                                                <tr>
                                                    @foreach ($child_positions as $key => $val)
                                                        <td valign="top" style="width:{{ 100/(count($staff)+1)  }}%;">
                                                            <table style="float:left;width:100%;margin-top: 10px" class="tbl">
                                                                <tr>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="chk-{{$key}}" value="{{$val->id}}" name="disposition_position_id">
                                                                            <label class="custom-control-label bold" for="chk-{{$key}}">{{$val->shortname}}</label>
                                                                        </div>

                                                                    </td>
                                                                </tr>

                                                                @if (!empty($staff[$val->id]))
                                                                @foreach ($staff[$val->id] as $key2 => $val2)
                                                                <tr>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="chk-{{$key}}-{{$key2}}" value="{{$val2->id}}" name="disposition_position_id" />
                                                                            <label class="custom-control-label" for="chk-{{$key}}-{{$key2}}">

                                                                                {{ !empty($val2->user->name) ? $val2->user->name : '' }}

                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                                @endif
                                                            </table>
                                                        </td>
                                                    @endforeach
                                                        <td valign="top" style="width:{{ 100/(count($staff)+1)  }}%;">
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
                                                </tr>
                                            </table>

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
