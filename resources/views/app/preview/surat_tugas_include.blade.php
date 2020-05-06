
<div class="font-size-surat font-surat color-black">
    <div class="line-height-surat-head">
        <div style="border-bottom: solid 2px #000; padding: 10px;">
            <div style="width:80px;float:left;">
                <img src="{{ (!empty($is_preview) && $is_preview == 'y' ? url().'/' : '' ) . 'assets/img/logo-kemendagri-small.png' }}" width="80px" />
            </div>
            <div style="float:left; margin-left: 30px; text-align: center;width: 12.7cm;margin-bottom: 0.5cm;">
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
        </div>
    </div>

    <div class="text-center">
        SURAT TUGAS
    </div>

    <div class="text-center">
        NOMOR
        {{ $data->mail_number_prefix ? $data->mail_number_prefix : '_____' }}/{{ $data->mail_number_infix ? $data->mail_number_infix : '_____' }}/{{ $data->mail_number_suffix }}
    </div>

    <div>
        <div style="width: 3cm; float: left;">
            Dasar
        </div>
        <div style="width: 0.2cm; float: left;">
            :
        </div>
        <div style="width: 12.5cm; float: left;text-align: justify;">
            <ol class="ol-surat">
                @foreach ($data->principle as $val)
                    <li>{{$val->principle}}</li>
                @endforeach
            </ol>
        </div>
        <div style="clear:both;"></div>
    </div>

    <div>
        @foreach ($data->mail_destination as $key => $val)
        <div>
            <div style="width: 3cm; float: left;">
                @if ($key == 0)
                    Memerintahkan
                @else
                    <table style="page-break-inside: avoid;">
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                @endif
            </div>
            <div style="width: 0.2cm; float: left;">
                @if ($key == 0)
                    :
                @endif
            </div>
            <div style="width: 12.5cm; float: left;text-align: justify;">
                <table style="page-break-inside: avoid;">
                    <tr>
                        <td style="width:0.3cm">{{ $key + 1 }}. </td>
                        <td style="width:3cm;">Nama</td>
                        <td style="width:15cm">: {{ $val->position->user_without_position->name }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Pangkat / Gol</td>
                        <td class="">: {{ $val->position->user_without_position->golongan }} </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>NIP</td>
                        <td class="">: {{ $val->position->user_without_position->username }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Jabatan</td>
                        <td class="">: {{ $val->position->shortname }}</td>
                    </tr>
                </table>
            </div>
            <div style="clear:both;"></div>
        </div>
        @endforeach
    </div>

    <div>
        <div style="width: 3cm; float: left;">
            Untuk
        </div>
        <div style="width: 0.2cm; float: left;">
            :
        </div>
        <div style="clear:both;"></div>
    </div>

    <div style="width: 12.5cm; text-align: justify;padding-left: 3.4cm;padding-top: -0.5cm;">
        {!! $data->content !!}
        <br /><br />
        Demikian Surat Tugas ini dibuat untuk dilaksan dengan penuh tanggung jawab.
    </div>

    <div>
        <table style="float:right; page-break-inside: avoid;">
            <tbody>
                <tr>
                    <td style="width: 1cm;" colspan="4">&nbsp;</td>
                    <td style="width: 7cm;" class="">Ditetapkan di Jakarta</td>
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
                    <td>
                        @if ($data->status == '2')
                        <span style="font-weight: bolder; font-size: 9pt !important;">Ditandatangani secara elektronik oleh :</span>
                        <br />
                        @endif
                        {!! $data->signer->position->signing_template !!},
                    </td>
                </tr>
                <tr >
                    <td colspan="4"></td>
                    <td>
                        <br><br>
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
        <div style="clear:both;"></div>
    </div>

    @include('app.preview.style.style')
