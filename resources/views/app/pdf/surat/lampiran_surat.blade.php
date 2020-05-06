<table style="width:300px;float:right;">
    <tr>
        <td colspan="2">Lampiran Surat Undangan</td>
    </tr>
    <tr>
        <td>Nomor</td>
        <td> : {{ $mail->mail_number }}</td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td> : {{ dateIndo($mail->mail_date) }}</td>
    </tr>
</table>

<div style="clear:both;"></div>

<br />
<br />

<ol>
    @foreach ($mail_destination as $key => $val)
        <li>
            {{ !empty($val->position->name) ? $val->position->name : '' }}
        </li>
    @endforeach
</ol>
