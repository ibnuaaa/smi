<?php setlocale (LC_TIME, "id-ID"); ?>

<div class="monitoring">
    <table class="table" cellspacing="0" cellpadding="0" style="text-align: left;">
        <tbody>
            <tr>
                <td style="text-align: left;">
                    <img src="{{ URL::asset('assets/img/acc_logo.png') }}" alt="" style="height: 75px; width: auto;">
                </td>
                <td style="text-align: center;">
                    <br />
                    <h1 style="font-size:15px; font-weight: bolder; color: #0a56ad;">SIMULASI PERHITUNGAN KREDIT</h1>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <th>Nama</th>
                <td>:</td>
                <th>Dealer</th>
                <td>:</td>
            </tr>
            <tr>
                <th>Handphone</th>
                <td>:</td>
                <th>Nama Sales Dealer</th>
                <td>:</td>
            </tr>

            <tr>
                <th>&nbsp;</th>
                <td>&nbsp;</td>
                <th>Cabang ACC</th>
                <td>:</td>
                <th>&nbsp;</th>
                <td style="visibility: hidden;">&nbsp;aaaaaaaaaaaaaa</td>
            </tr>

            <tr>
                <th colspan="8"><hr/></th>
                <td></td>
            </tr>

            <tr>
                <th>Brand</th>
                <td>:</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>:</td>
            </tr>

            <tr>
                <th>Model</th>
                <td>:</td>
            </tr>
            <tr>
                <th>Tahun Kendaraan</th>
                <td>:</td>
            </tr>

            <tr>
                <th colspan="8"><hr/></th>
                <td></td>
            </tr>

            <tr>
                <th>OTR</th>
                <td>:</td>
            </tr>
            <tr>
                <th>DP</th>
                <td>:</td>
            </tr>

            <tr>
                <th>Tenor</th>
                <td>:</td>
            </tr>

            <tr>
                <th colspan="8"><hr/></th>
                <td></td>
            </tr>
            <tr>
                <th>Asuransi</th>
            </tr>

            <tr>
                <th>Tahun 1</th>
                <td>:</td>
            </tr>
            <tr>
                <th>Tahun 2</th>
                <td>:</td>
            </tr>
            <tr>
                <th>Tahun 3</th>
                <td>:</td>
            </tr>
            <tr>
                <th>Tahun 4</th>
                <td>:</td>
            </tr>
            <tr>
                <th>Tahun 5</th>
                <td>:</td>
            </tr>

            <tr>
                <th colspan="8"><hr/></th>
                <td></td>
            </tr>
            <tr>
                <th>Pembayaran Asuransi</th>
                <td>:</td>
            </tr>
            <tr>
                <th>ACP</th>
                <td>:</td>
            </tr>

            <tr>
                <th colspan="8"><hr/></th>
                <td></td>
            </tr>
            <tr>
                <th>Total Biaya Pertama</th>
                <td>:</td>
            </tr>
            <tr>
                <th>Angsuran Perbulan</th>
                <td>:</td>
            </tr>
        </tbody>
    </table>

    <ul class="footer-a">
        <li>Perhitungan bersifat estimasi</li>
        <li>Total Down Payment sudah termasuk pembayaran angsuran pertama dan biaya administrasi fidusia</li>
        <li>ACP (ACC Credit Protection)</li>
    </ul>
</div>
<!-- <div style="padding-top: 100px;">
    <table class="table " width="100%">
        <tbody>


            <?php #foreach ($data as $key => $absensi):  ?>
            <tr>
                <td><?php #echo $key + 1; ?></td>
                <td><?php #if ($absensi->user && $absensi->user->name) echo $absensi->user->name; ?></td>
                <td><?php #echo $absensi->start; ?></td>
                <td><?php #echo $absensi->end; ?></td>
                <td><?php #echo $absensi->keterangan; ?></td>
                <td><?php #echo $absensi->notes; ?></td>
                <td>
                    <?php #if(count($absensi->images)) : ?>
                        <?php #foreach ($absensi->images->toArray() as $key2 => $value2) : ?>
                            <div style="float:left;margin-right:5px;">
                                <img src="<?php #echo url('/') . '/storage/thumb/' .$value2['thumbName']; ?>" style="width: 80px;">
                            </div>
                            <?php #if(($key2 + 1) % 3 == 0): ?>
                                <div style="clear:both;"></div>
                            <?php #endif; ?>
                        <?php #endforeach; ?>
                    <?php #endif; ?>
                </td>
            </tr>
        <?php #endforeach; ?>
        </tbody>
    </table>
</div> -->

<style>
    .footer-a {
        position: fixed;
        bottom: 100;
        left: -20;
        right: 0;
    }
    ul .footer-a li {
        color: '#fc0303'
    }
</style>
