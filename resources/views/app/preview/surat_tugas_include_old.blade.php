                        <table  class="color-black font-surat font-size-surat line-height-surat-head" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td class="text-center p-b-10" colspan="5">
                                        <div style="width:80px;float:left;">
                                            <img src="{{ url('/assets/img/logo-kemendagri-small.png') }}" width="80px" />
                                        </div>
                                        <div style="float:left; margin-left: 60px;">
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
                                    <td style="width:10%;"></td>
                                    <td style="width:2%;"></td>
                                    <td style="width:20%;"></td>
                                    <td style="width:20%;"></td>
                                    <td style="width:40%;"></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-center b-t ">
                                        <br />
                                        SURAT TUGAS
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-center  p-b-10">
                                        NOMOR
                                        @if ($data->status == '2')
                                            {{ $data->mail_number }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class=" "></td>
                                </tr>
                                <tr>
                                    <td class="p-l-10" valign="top">Dasar</td>
                                    <td valign="top">:</td>
                                    <td colspan="2" rowspan="2" valign="top" >
                                        <ol>
                                            @foreach ($data->principle as $val)
                                                <li>{{$val->principle}}</li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td class=""></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-center  p-t-10 p-b-10">
                                        MEMERINTAHKAN
                                    </td>
                                </tr>

                                <tr>
                                    <td class="p-l-10" valign="top">Kepada</td>
                                    <td valign="top">:</td>
                                    <td colspan="3" valign="top" class="">
                                        <table style="margin-left:-3px;">
                                            @foreach ($data->mail_destination as $key => $val)
                                                <tr style="">
                                                    <td>{{ $key + 1 }}. </td>
                                                    <td style="width:100pt;">Nama</td>
                                                    <td class="">: {{ $val->position->user_without_position->name }}</td>
                                                </tr>
                                                <tr style="">
                                                    <td>&nbsp;</td>
                                                    <td>Pangkat / Gol</td>
                                                    <td class="">: {{ $val->position->user_without_position->golongan }} </td>
                                                </tr>
                                                <tr style="">
                                                    <td>&nbsp;</td>
                                                    <td>NIP</td>
                                                    <td class="">: {{ $val->position->user_without_position->username }}</td>
                                                </tr>
                                                <tr style="">
                                                    <td>&nbsp;</td>
                                                    <td>Jabatan</td>
                                                    <td class="">: {{ $val->position->shortname }}</td>
                                                </tr>
                                            @endforeach


                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="p-l-10"  valign="top">Untuk</td>
                                    <td valign="top">
                                        :
                                    </td>
                                    <td colspan="3" valign="top" class=" text-justify p-r-20">
                                        {!! $data->content !!}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="p-l-10"  valign="top"></td>
                                    <td valign="top">
                                    </td>
                                    <td colspan="3" valign="top" class=" text-justify p-r-20">
                                        Demikian Surat Tugas ini dibuat untuk dilaksan dengan penuh tanggung jawab.
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                    <td class="">Ditetapkan di Jakarta</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                    <td>Pada tanggal {{ dateIndo($data->mail_date) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                    <td class="">&nbsp;</td>
                                </tr>

                                @if ($data->signer->position->id != $data->source_position->id)
                                <tr>
                                    <td colspan="4" valign="top" style="text-align:right;">a.n</td>
                                    <td >
                                        {!! $data->source_position->signing_template !!},
                                    </td>
                                </tr>
                                @endif

                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                    <td >
                                        {!! $data->signer->position->signing_template !!},
                                    </td>
                                </tr>
                                <tr >
                                    <td colspan="4"></td>
                                    <td>
                                        @if ($data->status == '2')
                                            <img src="{{ url('/assets/img/qrcode/' . $data->mail_hash_code) }}.png" width="80px" />
                                        @else
                                            <br><br><br><br>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                    <td  style="text-decoration:underline;">{{ $data->source_position->user_without_position->name }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                    <td >{{ $data->source_position->user_without_position->golongan }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                    <td >NIP.{{ $data->source_position->user_without_position->username }}</td>
                                </tr>


                            </tbody>
                        </table>

                        @include('app.preview.style.style')
