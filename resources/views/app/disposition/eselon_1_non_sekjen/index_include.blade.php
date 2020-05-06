                                <table class="disposition text-dark color-black font-surat font-size-surat line-height-surat tbl" border="0" style="width:100%;">
                                    <tbody class="">
                                        <tr>
                                            <td class="b-l b-b b-r text-center p-b-10" colspan="4">
                                                <div>
                                                    <span style="text-align: center">
                                                        <span style="font-size:16px !important;">KEMENTERIAN DALAM NEGERI</span><br />
                                                        <span style="font-size:16px !important;">REPUBLIK INDONESIA</span> <br />
                                                        <span style="font-size:16px !important;">IRJEN</span>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" style="width: 50%">
                                                <table style="width:100%;" class="noborder" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td valign="top">Surat Dari</td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td>
                                                            {{ $master_mail->source_position ? $master_mail->source_position->shortname : $master_mail->source_external }}
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
                                            <td colspan="2" style="width: 50%">
                                                <table style="width:100%;" class="noborder" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>Diterima Tgl</td>
                                                        <td>
                                                            :
                                                        </td>
                                                        <td>
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
                                            <td class="" colspan="2" style="vertical-align:top;">
                                                <strong>
                                                    Di Disposisikan kepada :
                                                </strong>
                                                <br />
                                                <ol>
                                                    @foreach ($mail->disposition_destination as $key => $val)
                                                        <li>
                                                            {{$val->position->shortname}}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td colspan="2" style="vertical-align:top;">
                                                <b>Dengan Hormat harap</b>
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
                                            </td>
                                        </tr>



                                    </tbody>
                                </table>
                                @include('app.preview.style.style')
