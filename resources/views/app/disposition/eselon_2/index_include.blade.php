                                <table class="disposition text-dark color-black font-surat font-size-surat line-height-surat tbl" style="width:100%;" border="0">
                                    <tbody class="">
                                        <tr>
                                            <td class="b-l b-b b-r text-center p-b-10" colspan="4">
                                                <div>
                                                    <span style="text-align: center">
                                                        <span style="font-size:16px !important;">KEMENTERIAN DALAM NEGERI</span><br />
                                                        <span style="font-size:16px !important;">REPUBLIK INDONESIA</span> <br />
                                                        <span style="font-size:16px !important;">{{ $eselon_1_header_name }}</span><br />
                                                        <span style="font-size:16px !important;">{{ $eselon_2_header_name }}</span>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td style="width:50%;" colspan="2">
                                                <table style="width:100%;" class="noborder" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td valign="top" style="width: 25%">Surat Dari</td>
                                                        <td style="width: 1%">
                                                            :
                                                        </td>
                                                        <td style="width: 74%">
                                                            {{ !empty($master_mail->source_position) ? $master_mail->source_position->shortname : $master_mail->source_external }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No Surat</td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td>
                                                            {{ $master_mail->mail_number ? $master_mail->mail_number : $master_mail->mail_number_ext }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tgl Surat</td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td>
                                                            {{ dateIndo($master_mail->mail_date) }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="width:50%;" colspan="2">
                                                <table style="width:100%;" class="noborder" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="width: 25%">Diterima Tgl</td>
                                                        <td style="width: 1%">
                                                            :
                                                        </td>
                                                        <td style="width: 74%">
                                                            {{ dateIndo($mail->sent_at) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pukul</td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td>
                                                            {{ timeIndo($mail->sent_at) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No Agenda</td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td>
                                                            @if (!empty($disposition->mail_to_me->agenda_number))
                                                                {{ $disposition->mail_to_me->agenda_number }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top">Sifat</td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td>
                                                            {{ config('app.mail_privacy_type.' . $master_mail->privacy_type) }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>






                                        <tr>
                                            <td colspan="4"">
                                                <strong>
                                                    Hal
                                                </strong>
                                                <br/>
                                                {{ $master_mail->about }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="" colspan="2" style="vertical-align:top;width:50%;">
                                                <strong>
                                                    Diteruskan kepada Yth Sdr :
                                                </strong>
                                                <br />
                                                <table style="width: 100%;" cellpadding="0" cellspacing="0" class="noborder">
                                                    @foreach ($mail->disposition_destination as $key => $val)
                                                        <tr>
                                                            <td style="width: 10%"><input type="checkbox" checked></td>
                                                            <td style="width: 90%">
                                                                {{ !empty($val->position->shortname) ? $val->position->shortname : '-' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td colspan="2" style="vertical-align:top;width:50%">
                                                <b>Disposisi</b>
                                                <br />
                                                <table style="width: 100%;" cellpadding="0" cellspacing="0" class="noborder">
                                                @if (!empty($disposition_follow_up))
                                                    @foreach($disposition_follow_up as $key => $val)
                                                        @if (!empty($mail_detail[$val->code]))
                                                            <tr>
                                                                <td style="width: 10%;"><input type="checkbox" checked /></td>
                                                                <td style="width: 90%;">{{$val->name}}</td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td style="width: 10%;"><input type="checkbox" /></td>
                                                                <td style="width: 90%;">{{$val->name}}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif

                                                @if (!empty($follow_up_tambahan))
                                                    @foreach($follow_up_tambahan as $key => $val)
                                                        @if (!empty($val))
                                                            <tr style="width: 10%;"><td><input type="checkbox" checked /></td></tr>
                                                            <tr style="width: 90%;"><td>{{$val}}</td></tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">

                                                <strong>
                                                    Catatan
                                                </strong>
                                                <br/>
                                                @if (!empty($mail_detail['notes']))
                                                    {{ $mail_detail['notes'] }}
                                                @endif
                                                <br />
                                                <br />
                                                <br />
                                                <br />



                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                @include('app.preview.style.style')
