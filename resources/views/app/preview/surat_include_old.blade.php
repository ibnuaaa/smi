                        <table  class="color-black font-surat font-size-surat line-height-surat-head" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td width="15%"></td>
                                    <td width="35%"></td>
                                    <td width="10%"></td>
                                    <td width="30%"></td>
                                </tr>
                                <tr>
                                    <td class="b-l b-b b-r text-center p-b-10" colspan="4">
                                        <div style="width:80px;float:left;">
                                            <img src="{{ (!empty($is_preview) && $is_preview == 'y' ? url().'/' : '' ) . 'assets/img/logo-kemendagri-small.png' }}" width="80px" />
                                        </div>
                                        <div style="float:left; margin-left: 30px;">
                                            <span style="">
                                                <span style="font-size:16pt !important;">KEMENTERIAN DALAM NEGERI</span><br />
                                                <span style="font-size:16pt !important;">REPUBLIK INDONESIA</span> <br />
                                                <span style="font-size:18pt !important;font-weight: bolder;">SEKRETARIAT JENDERAL</span>
                                            </span>
                                            <br />
                                            <span style="font-size:10pt !important;">
                                            {{ $config['address'] }}
                                            <br />
                                            {{ $config['phone_number'] }}
                                            <br/>
                                            Website:
                                            <u style="font-size:10pt !important;">{{ $config['website'] }}</u>
                                            eMail: {{ $config['email'] }}
                                            </span>
                                        </div>
                                        <div style="clear:both;"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table  class="color-black font-surat font-size-surat line-height-surat-body" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td width="15%"></td>
                                    <td width="55%"></td>
                                    <td width="10%"></td>
                                    <td width="40%"></td>
                                </tr>
                                <tr>
                                    <td class="b-l b-r" colspan="4">
                                        <br />
                                    </td>
                                </tr>

                                <tr>
                                    <td class="b-l" colspan="2" valign="top" style="padding-top:33.5pt;">
                                        <table>
                                            <tr>
                                                <td class="p-l-20 p-r-10" style="width:1.7cm;">Nomor</td>
                                                <td>:
                                                    @if ($data->status == '2')
                                                        {{ $data->mail_number }}
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr >
                                                <td class="p-l-20 p-r-10">Sifat</td>
                                                <td>
                                                    : {{ config('app.mail_privacy_type.' . $data->privacy_type) }}
                                                </td>
                                            </tr>
                                            <tr >
                                                <td class="p-l-20 p-r-10" valign="top">Lampiran</td>
                                                <td>
                                                    :
                                                    @if (count($data->lampiran) == 0)
                                                        -
                                                    @else
                                                        <a href="#" onClick="return showLampiran()">
                                                            {{ count($data->lampiran) }} Lembar
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr >
                                                <td class="p-l-20 p-r-10">Hal</td>
                                                <td>: {{ $data->about }}</td>
                                            </tr>
                                        </table>

                                    </td>
                                    <td colspan="2" class="b-r" valign="top">

                                        <table>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    Jakarta,  {{ $data->mail_date ? dateIndo($data->mail_date) : dateIndo(date('Y-m-d H:i:s')) }}
                                                    <br/><br/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    Kepada
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top">Yth.</td>
                                                <td valign="top">
                                                    @if (count($data->mail_destination) <= 4)
                                                        @foreach ($data->mail_destination as $key => $val)
                                                            {!! $val->position->signing_template !!}
                                                        @endforeach
                                                    @else
                                                        Daftar Undangan Terlampir
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td valign="top">
                                                    di - <br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    Tempat
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <table  class="color-black font-surat font-size-surat line-height-surat-body" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td width="15%"></td>
                                    <td width="80%"></td>
                                    <td width="10%"></td>
                                </tr>

                                <tr>
                                    <td class="b-l"></td>
                                    <td class="b-r text-left table-surat-content" colspan="2" style="padding:0px !important;">
                                        {!! $data->content !!}
                                    </td>
                                    <td class="b-l"></td>
                                </tr>
                            </tbody>
                        </table>

                        <table  class="color-black font-surat font-size-surat line-height-surat-body" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td width="15%"></td>
                                    <td width="55%"></td>
                                    <td width="10%"></td>
                                    <td width="40%"></td>
                                </tr>

                                @if ($data->signer)
                                @if ($data->signer->position->id != $data->source_position->id)
                                <tr>
                                    <td class="b-l">&nbsp;</td>
                                    <td valign="top" style="text-align:right;">a.n</td>
                                    <td class="b-r" colspan="2">
                                        {!! $data->source_position->signing_template !!},
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="b-l">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="b-r" colspan="2">
                                        {!! $data->signer->position->signing_template !!},
                                    </td>
                                </tr>

                                <tr >
                                    <td class="b-l">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="b-r" colspan="2">
                                        @if ($data->status == '2')
                                            @if (false)
                                            <img src="{{ url('/assets/img/qrcode/' . $data->mail_hash_code) }}.png" width="80px" />
                                            @endif
                                            Ditandatangani secara elektronik oleh :
                                            <br>
                                        @else
                                            <br>
                                        @endif

                                    </td>
                                </tr>
                                <tr >
                                    <td class="b-l">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="b-r" colspan="2" style="text-decoration:underline;">
                                        {{ $data->signer->position->user_without_position->name }}
                                    </td>
                                </tr>
                                <tr >
                                    <td class="b-l">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="b-r" colspan="2">
                                        {{ $data->signer->position->user_without_position->golongan }}
                                    </td>
                                </tr>
                                <tr >
                                    <td class="b-l">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="b-r" colspan="2">NIP.
                                        {{ $data->signer->position->user_without_position->username }}
                                    </td>
                                </tr>
                                @endif

                                <?php $ttl_tembusan=0; ?>
                                @foreach ($data->mail_copy_to as $key => $val)
                                @if (!empty($val->position->shortname))
                                    <?php $ttl_tembusan ++ ?>
                                @endif
                                @endforeach
                                @if ($data->tembusan)
                                    <?php foreach (explode(',', $data->tembusan) as $key => $value): ?>
                                        @if ($value)
                                        <?php $ttl_tembusan++; ?>
                                        @endif
                                    <?php endforeach ?>
                                @endif

                                @if ($ttl_tembusan > 0)
                                <tr>
                                    <td colspan="3" class="b-l p-l-10">
                                        <span class="bold">Tembusan : </span><br/>
                                        <ol style="">
                                            @foreach ($data->mail_copy_to as $key => $val)
                                            @if (!empty($val->position->shortname))
                                            <li>{{ $val->position ? $val->position->shortname : '' }}</li>
                                            @endif
                                            @endforeach
                                            @if ($data->tembusan)
                                                <?php foreach (explode(',', $data->tembusan) as $key => $value): ?>
                                                    @if ($value)
                                                    <li>{{$value}}</li>
                                                    @endif
                                                <?php endforeach ?>
                                            @endif
                                        </ol>
                                        <br />
                                    </td>
                                    <td class="b-r">
                                    </td>
                                </tr>
                                @endif

                                <tr >
                                    <td colspan="12" class="b-l b-r p-l-10">

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @if (count($data->mail_destination) > 4)
                        <table  class="color-black font-surat font-size-surat line-height-surat">
                            <tr>
                                <td valign="top" style="padding:30px 10px 50px 10px;">
                                    <table style="width:300px;float:right;">
                                        <tr>
                                            <td colspan="2">Lampiran Surat Undangan</td>
                                        </tr>
                                        <tr>
                                            <td>Nomor</td>
                                            <td> : {{ $data->mail_number }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal</td>
                                            <td> : {{ dateIndo($data->mail_date) }}</td>
                                        </tr>
                                    </table>

                                    <div style="clear:both;"></div>

                                    <br />
                                    <br />

                                    <ol>
                                        @foreach ($data->mail_destination as $key => $val)
                                            <li>
                                                {{ !empty($val->position->name) ? $val->position->name : '' }}
                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                            </tr>
                        </table>
                        @endif


                        @include('app.preview.style.style')
