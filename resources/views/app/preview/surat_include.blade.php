<div class="font-size-surat font-surat color-black">
    <div class="line-height-surat-head">
        <div style="border-bottom: solid 2px #000; padding: 10px;margin-bottom: 0.5cm;">
            <div style="width:80px;float:left;">
                <img src="{{ (!empty($is_preview) && $is_preview == 'y' ? url().'/' : '' ) . 'assets/img/logo-kemendagri-small.png' }}" width="80px" />
            </div>
            <div style="float:left; margin-left: 30px; text-align: center;width: 12.7cm;">
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
    <div class="line-height-surat-body">
        <div style="float: left; padding-top: 1.73cm; width: 8cm;">
            <table>
                <tr>
                    <td style="width:1.7cm;">Nomor</td>
                    <td>:
                        {{ $data->mail_number_prefix ? $data->mail_number_prefix : '_____' }}/{{ $data->mail_number_infix ? $data->mail_number_infix : '_____' }}/{{ $data->mail_number_suffix }}
                    </td>
                </tr>

                <tr >
                    <td>Sifat</td>
                    <td>
                        : {{ config('app.mail_privacy_type.' . $data->privacy_type) }}
                    </td>
                </tr>
                <tr>
                    <td valign="top">Lampiran</td>
                    <td> :
                        @if (count($data->lampiran) == 0)
                            -
                        @else
                            <a href="#" onClick="return showLampiran()">
                                {{ count($data->lampiran) }} Lembar
                            </a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Hal</td>
                    <td>:
                        {{ $data->about }}
                    </td>
                </tr>
            </table>
        </div>
        <div style="float: left; width: 7cm;">
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
        </div>
        <div style="clear:both;"></div>

        <div style="text-align: justify; padding-left: 2cm;" class="isi-surat">
            {!! $data->content !!}
        </div>

        <div style="text-align: center;">
            <br />
            <br />
            <table style="width:8cm; float: right; page-break-inside: avoid;">
                @if ($data->signer)
                @if ($data->signer->position->id != $data->source_position->id)
                <tr>
                    <td valign="top" style="text-align:right;">a.n</td>
                    <td colspan="2">
                        {!! $data->source_position->signing_template !!},
                    </td>
                </tr>
                @endif
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">
                        @if ($data->status == '2')
                        <span style="font-weight: bolder; font-size: 9pt !important;">Ditandatangani secara elektronik oleh :</span>
                        <br />
                        @endif
                        {!! $data->signer->position->signing_template !!},
                    </td>
                </tr>

                <tr >
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <br><br>
                    </td>
                </tr>
                <tr >
                    <td>&nbsp;</td>
                    <td colspan="2" style="text-decoration:underline;">
                        {{ $data->signer->position->user_without_position->name }}
                    </td>
                </tr>
                <tr >
                    <td>&nbsp;</td>
                    <td colspan="2">
                        {{ $data->signer->position->user_without_position->golongan }}
                    </td>
                </tr>
                <tr >
                    <td>&nbsp;</td>
                    <td colspan="2">NIP.
                        {{ $data->signer->position->user_without_position->username }}
                    </td>
                </tr>
                @endif
            </table>
            <div style="clear:both;"></div>
        </div>





        <br />
        <br />

        <?php $ttl_tembusan=0; ?>
        @foreach ($data->mail_copy_to as $key => $val)
        @if (!empty($val->position->shortname))
            <?php $ttl_tembusan ++ ?>
        @endif
        @endforeach

        @if ($ttl_tembusan > 0)
        Tembusan
        <ol class="ol-surat">
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
        @endif



        @if (count($data->mail_destination) > 4)
        <div class="line-height-surat-body" style="page-break-before: always;">
            <table style="width:300px;float:right; page-break-inside: avoid;">
                <tr>
                    <td colspan="2">Lampiran Surat Undangan</td>
                </tr>
                <tr>
                    <td>Nomor</td>
                    <td> :

                        {{ $data->mail_number_prefix ? $data->mail_number_prefix : '_____' }}/{{ $data->mail_number_infix ? $data->mail_number_infix : '_____' }}/{{ $data->mail_number_suffix }}

                    </td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td> : {{ dateIndo($data->mail_date) }}</td>
                </tr>
            </table>

            <div style="clear:both;"></div>

            <br />
            <br />

            <ol class="ol-surat">
                @foreach ($data->mail_destination as $key => $val)
                    <li>
                        {{ !empty($val->position->shortname) ? $val->position->shortname : '' }}
                    </li>
                @endforeach
            </ol>
        </div>
        @endif
    </div>
</div>

@include('app.preview.style.style')
