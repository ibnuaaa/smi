                                            <table class="disposition text-dark color-black font-surat font-size-surat line-height-surat" style="width:100%;" border="0">
                                                <tbody class="">
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td class="text-center p-b-10 b-b" colspan="4">
                                                            <img src="assets/img/garuda-emas.png" width="80px" /><br />
                                                            MENTERI DALAM NEGERI<br />
                                                            REPUBLIK INDONESIA
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6"><br/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <th valign="top">Surat Dari</th>
                                                        <td class=" "> :
                                                            {{ $master_mail->source_position ? $master_mail->source_position->shortname : $master_mail->source_external }}
                                                        </td>
                                                        <th class="">Diterima Tgl</th>
                                                        <td class=" "> : {{ dateIndo($mail->sent_at) }}</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <th class="">No Surat</th>
                                                        <td class=""> : {{ $master_mail->mail_number ? $master_mail->mail_number : $master_mail->mail_number_ext }}</td>
                                                        <th>Pukul</th>
                                                        <td class=""> : {{ timeIndo($mail->sent_at) }}</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <th class="">Tgl Surat</th>
                                                        <td class=""> : {{ dateIndo($master_mail->mail_date) }}</td>
                                                        <th>No Agenda</th>
                                                        <td class="">
                                                            :
                                                            @if (!empty($disposition->mail_to_me->agenda_number))
                                                                {{ $disposition->mail_to_me->agenda_number }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td class="">&nbsp;</td>
                                                        <td class="">&nbsp;</td>
                                                        <th valign="top">Sifat</th>
                                                        <td class="">
                                                            : {{ config('app.mail_privacy_type.' . $master_mail->privacy_type) }}
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td class=" b-b" colspan="4">&nbsp;</td>
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
                                                        <td colspan="4"> : {{ $master_mail->about }}</td>
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
                                                        @if (!empty($mail_detail['notes']))
                                                        {{ $mail_detail['notes'] }}
                                                        @endif

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

                                            @include('app.preview.style.style')
