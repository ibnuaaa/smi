

                                <table class="text-dark color-black font-surat font-size-surat line-height-surat tbl" border="0">
                                    <tbody class="">
                                        <tr>
                                            <td class="b-l b-b b-r text-center p-b-10" colspan="4">
                                                <div style="">
                                                    <span style="text-align: center">
                                                        <span style="font-size:16px !important;">KEMENTERIAN DALAM NEGERI</span><br />
                                                        <span style="font-size:16px !important;">{{ $eselon_2_header_name }}</span><br />
                                                        <span style="font-size:16px !important;">{{ $eselon_3_header_name }}</span>
                                                    </span>
                                                </div>
                                                <div style="clear:both;"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:25%;" valign="top">Surat Dari</td>
                                            <td style="width:25%;" valign="top">
                                                {{ $master_mail->source_position ? $master_mail->source_position->shortname : $master_mail->source_external }}
                                            </td>
                                            <td style="width:25%;" class="">Diterima Tgl</td>
                                            <td style="width:25%;" class=" ">{{ dateIndo($mail->sent_at) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="">No Surat</td>
                                            <td class="">
                                                {{ $master_mail->mail_number ? $master_mail->mail_number : $master_mail->mail_number_ext }}
                                            </td>
                                            <td>Pukul</td>
                                            <td class="">{{ timeIndo($mail->sent_at) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="">Tgl Surat</td>
                                            <td class="">{{ dateIndo($master_mail->mail_date) }}</td>
                                            <td>No Agenda</td>
                                            <td class="">
                                                @if (!empty($disposition->mail_to_me->agenda_number))
                                                    {{ $disposition->mail_to_me->agenda_number }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">&nbsp;</td>
                                            <td class="">&nbsp;</td>
                                            <td valign="top">Sifat</td>
                                            <td class="">
                                                {{ config('app.mail_privacy_type.' . $master_mail->privacy_type) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class=" b-b" colspan="4">
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <strong>
                                                    Hal
                                                </strong>

                                                {{ $master_mail->about }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="vertical-align:top;padding:0px;">
                                                <table style="width:100%;margin:0px;">
                                                    <tr>
                                                        @foreach ($child_positions as $key => $val)
                                                            <td valign="top" style="width:{{ 100/(count($staff)+1)  }}%;">
                                                                <table style="width:100%;" class="noborder">
                                                                    <tr>
                                                                        <td style="width:20px; vertical-align: top;">
                                                                            @if (!empty($val->id) &&  in_array($val->id, $selected_position_id))
                                                                            <input type="checkbox" checked />
                                                                            @else
                                                                            <input type="checkbox" />
                                                                            @endif

                                                                        </td>
                                                                        <td>
                                                                            <label style="font-weight: bolder;">{{$val->shortname}}</label>
                                                                        </td>
                                                                    </tr>

                                                                    @if (!empty($val->id) && !empty($staff[$val->id]))
                                                                    @foreach ($staff[$val->id] as $key2 => $val2)
                                                                    <tr>
                                                                        <td style="vertical-align: top;">
                                                                            @if (!empty($val2->id) &&  in_array($val2->id, $selected_position_id))
                                                                            <input type="checkbox" checked />
                                                                            @else
                                                                            <input type="checkbox" />
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <label>{{ !empty($val2->user->name) ? $val2->user->name : '' }}</label>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                    @endif
                                                                </table>
                                                            </td>
                                                        @endforeach
                                                            <td valign="top" style="width:{{ 100/(count($staff)+1)  }}%;">

                                                                <table style="width: 100%;" cellpadding="0" cellspacing="0" class="noborder">
                                                                @foreach ($mail->disposition_destination as $key => $val)
                                                                    @if (!empty($val->position->id) && !in_array($val->position->id, $in_position_ids))
                                                                    <tr>
                                                                        <td style="width: 10%; vertical-align: top;"><input type="checkbox" checked></td>
                                                                        <td style="width: 90%">{{ (!empty($val->position->shortname)) ? $val->position->shortname : ''}} </td>
                                                                    </tr>
                                                                    @endif
                                                                @endforeach ?>
                                                                </table>
                                                            </td>
                                                    </tr>
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
                                                <br/>
                                                <br/>
                                                <br/>

                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                @include('app.preview.style.style')
