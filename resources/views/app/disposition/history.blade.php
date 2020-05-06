
Surat ini telah didisposisikan kepada :
<table class="table table-bordered table-condensed" border="1">
<tr>
    <th style="width: 40%">Didisposisikan Kepada</th>
    <th style="width: 40%">Didisposisikan Oleh</th>
    <th style="width: 20%">Tanggal Disposisi</th>
    <th style="width: 20%">Waktu Disposisi</th>
</tr>
@if (!empty($disposition->history))
    @foreach ($disposition->history as $val)
        @foreach ($val->mail_to as $val2)
        <tr>
            <td style="white-space: none;">
                {{ (!empty($val2->position_with_user_without_position->shortname)) ?  $val2->position_with_user_without_position->shortname : '' }}
            </td>
            <td style="white-space: none;">
                {{ (!empty($val->disposition_by->shortname)) ? $val->disposition_by->shortname : '' }}
            </td>
            <td>
                {{ dateIndo($val->created_at) }}
            </td>
            <td>
                {{ timeIndo($val->created_at) }}
            </td>
        </tr>
        @endforeach
    @endforeach
@endif
</table>

