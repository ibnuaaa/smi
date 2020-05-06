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


    <div class="text-center bold" style="padding-bottom: 0.5cm;">
        NOTA DINAS
    </div>

    <div>
        <div style="width: 3cm; float: left;">
            Kepada
        </div>
        <div style="width: 0.2cm; float: left;">
            :
        </div>
        <div style="width: 12.5cm; float: left;text-align: justify;">
            @foreach ($data->mail_destination as $key => $val)
            Yth. {{ !empty($val->position->shortname) ? $val->position->shortname : '' }} <br />
            @endforeach
        </div>
        <div style="clear:both;"></div>
    </div>

    <div>
        <div style="width: 3cm; float: left;">
            Dari
        </div>
        <div style="width: 0.2cm; float: left;">
            :
        </div>
        <div style="width: 12.5cm; float: left;text-align: justify;">
            {{ $data->source_position->shortname }}
        </div>
        <div style="clear:both;"></div>
    </div>

    <div>
        <div style="width: 3cm; float: left;">
            Tembusan
        </div>
        <div style="width: 0.2cm; float: left;">
            :
        </div>
        <div style="width: 12.5cm; float: left;text-align: justify;">
            @foreach ($data->mail_copy_to as $key => $val)
                @if (!empty($val->position->shortname))
                    <li> Yth. {{ $val->position ? $val->position->shortname : '' }}</li>
                @endif
            @endforeach
            @if ($data->tembusan)
                <?php foreach (explode(',', $data->tembusan) as $key => $value): ?>
                    @if ($value)
                    <li>{{$value}}</li>
                    @endif
                <?php endforeach ?>
            @endif
        </div>
        <div style="clear:both;"></div>
    </div>

    <div>
        <div style="width: 3cm; float: left;">
            Tanggal
        </div>
        <div style="width: 0.2cm; float: left;">
            :
        </div>
        <div style="width: 12.5cm; float: left;text-align: justify;">
            {{ dateIndo($data->mail_date) }}
        </div>
        <div style="clear:both;"></div>
    </div>

    <div>
        <div style="width: 3cm; float: left;">
            Nomor
        </div>
        <div style="width: 0.2cm; float: left;">
            :
        </div>
        <div style="width: 12.5cm; float: left;text-align: justify;">
            {{ $data->mail_number_prefix ? $data->mail_number_prefix : '_____' }}/{{ $data->mail_number_infix ? $data->mail_number_infix : '_____' }}/{{ $data->mail_number_suffix }}
        </div>
        <div style="clear:both;"></div>
    </div>

    <div>
        <div style="width: 3cm; float: left;">
            Sifat
        </div>
        <div style="width: 0.2cm; float: left;">
            :
        </div>
        <div style="width: 12.5cm; float: left;text-align: justify;">
            {{ config('app.mail_privacy_type.' . $data->privacy_type) }}
        </div>
        <div style="clear:both;"></div>
    </div>

    <div>
        <div style="width: 3cm; float: left;">
            Lampiran
        </div>
        <div style="width: 0.2cm; float: left;">
            :
        </div>
        <div style="width: 12.5cm; float: left;text-align: justify;">
            @if (count($data->lampiran) > 0)
                {{ count($data->lampiran) }} lembar
            @else
                -
            @endif
        </div>
        <div style="clear:both;"></div>
    </div>

    <div>
        <div style="width: 3cm; float: left;">
            Hal
        </div>
        <div style="width: 0.2cm; float: left;">
            :
        </div>
        <div style="width: 12.5cm; float: left;text-align: justify;">
            {{ $data->about }}
        </div>
        <div style="clear:both;"></div>
    </div>

    <div style="padding-top: 0.5cm; border-top: solid 2px;margin-top:0.5cm; text-align: justify;">
        {!! $data->content !!}
    </div>


    <div style="padding-top: 0.5cm">
        <table style="float:right; page-break-inside: avoid; width: 8cm;">
            <tbody>
                @if ($data->signer->position->id != $data->source_position->id)
                <tr>
                    <td valign="top" style="text-align:right;">a.n</td>
                    <td >
                        {!! $data->source_position->signing_template !!},
                    </td>
                </tr>
                @endif

                <tr>
                    <td >&nbsp;</td>
                    <td>
                        @if ($data->status == '2')
                        <span style="font-weight: bolder; font-size: 9pt !important;">Ditandatangani secara elektronik oleh :</span>
                        <br />
                        @endif
                        {!! $data->signer->position->signing_template !!},
                    </td>
                </tr>
                <tr >
                    <td ></td>
                    <td>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td  style="text-decoration:underline;">{{ $data->source_position->user_without_position->name }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td >{{ $data->source_position->user_without_position->golongan }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td >NIP.{{ $data->source_position->user_without_position->username }}</td>
                </tr>


            </tbody>
        </table>
        <div style="clear:both;"></div>
    </div>

    @include('app.preview.style.style')

