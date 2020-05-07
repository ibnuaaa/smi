<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a bre
eze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/logout', 'CMS\Authentication\AuthenticationController@Logout');

$router->get('/', 'CMS\Home\HomeController@Home');

$router->get('/position', 'CMS\Position\PositionController@Home');
$router->get('/position/paging', 'CMS\Position\PositionController@HomeWithPaging');
$router->get('/position/new', 'CMS\Position\PositionController@New');
$router->get('/position/{id}', 'CMS\Position\PositionController@PositionEdit');

$router->get('/user', 'CMS\User\UserController@Home');
$router->get('/user/new', 'CMS\User\UserController@New');
$router->get('/user/edit/{id}', 'CMS\User\UserController@Edit');
$router->get('/user/{id}', 'CMS\User\UserController@Detail');

// kemendagri
$router->get('/surat_internal', 'CMS\SuratInternal\SuratInternalController@Index');
$router->get('/surat_internal/new_surat/{id}', 'CMS\SuratInternal\SuratInternalController@NewSurat');
$router->get('/surat_internal/surat/edit/{id}', 'CMS\SuratInternal\SuratInternalController@Edit');
$router->get('/surat_internal/surat_dinas/preview', 'CMS\SuratInternal\SuratInternalController@SuratDinasPreview');

$router->get('/surat_internal/new_surat/{id}/balasan_disposisi/{id2}', 'CMS\SuratInternal\SuratInternalController@NewSuratBalasanDisposisi');

$router->get('/upload_surat_masuk', 'CMS\UploadSuratMasuk\UploadSuratMasukController@Index');
$router->get('/upload_surat_masuk/edit/{id}', 'CMS\UploadSuratMasuk\UploadSuratMasukController@Edit');

$router->get('/surat/preview/{id}/{mail_type}', 'CMS\SuratMasuk\SuratMasukController@Preview');
$router->get('/surat/mail_import_detail/{id}', 'CMS\SuratMasuk\SuratMasukController@MailImportDetail');
$router->get('/surat/pdf/sample', 'CMS\SuratMasuk\SuratMasukController@DownloadPdfSample');
$router->get('/surat/pdf/{id}', 'CMS\SuratMasuk\SuratMasukController@DownloadPdf');
$router->get('/surat/pdf-debug/{id}', 'CMS\SuratMasuk\SuratMasukController@DebugPdf');

$router->get('/surat_keluar', 'CMS\SuratKeluar\SuratKeluarController@Home');
$router->get('/surat_masuk', 'CMS\SuratMasuk\SuratMasukController@Home');
$router->get('/approval', 'CMS\Approval\ApprovalController@Home');
$router->get('/approval_numbering', 'CMS\ApprovalNumbering\ApprovalNumberingController@Home');

$router->get('/disposisi', 'CMS\Disposisi\DisposisiController@Home');
$router->get('/disposisi/new/{id}', 'CMS\Disposisi\DisposisiController@New');
$router->get('/disposisi/detail/{id}', 'CMS\Disposisi\DisposisiController@Detail');
$router->get('/disposisi/pdf/{id}', 'CMS\Disposisi\DisposisiController@DownloadPdf');


$router->get('/profile', 'CMS\User\UserController@Profile');
$router->get('/change_password', 'CMS\User\UserController@ChangePassword');

$router->get('/notifikasi', 'CMS\Notifikasi\NotifikasiController@Home');

$router->get('/information', 'CMS\Information\InformationController@Home');
$router->get('/information/new', 'CMS\Information\InformationController@New');
$router->get('/information/edit/{id}', 'CMS\Information\InformationController@Edit');
$router->get('/information/{id}', 'CMS\Information\InformationController@Detail');

$router->get('/config_numbering', 'CMS\ConfigNumbering\ConfigNumberingController@Home');
$router->get('/config_numbering/edit/{id}', 'CMS\ConfigNumbering\ConfigNumberingController@Edit');

$router->get('/audit_trail', 'CMS\AuditTrail\AuditTrailController@Home');
$router->get('/audit_trail/log_data/{id}', 'CMS\AuditTrail\AuditTrailController@LogData');

$router->get('/audit_trail_x', 'CMS\AuditTrail\AuditTrailController@X');


$router->get('/mail_classification', 'CMS\MailClassification\MailClassificationController@Home');
$router->get('/mail_classification/new', 'CMS\MailClassification\MailClassificationController@New');
$router->get('/mail_classification/edit/{id}', 'CMS\MailClassification\MailClassificationController@Edit');
$router->get('/mail_classification/{id}', 'CMS\MailClassification\MailClassificationController@Detail');

$router->get('/config', 'CMS\Config\ConfigController@Home');
$router->get('/config/new', 'CMS\Config\ConfigController@New');
$router->get('/config/edit/{id}', 'CMS\Config\ConfigController@Edit');
$router->get('/config/{id}', 'CMS\Config\ConfigController@Detail');


$router->get('/formulir_pembiayaan_daerah', 'CMS\Sample\SampleController@FormulirPembiayaanDaerah');


$router->get('/master_data_pemda', 'CMS\Sample\SampleController@MasterDataPemdaHome');
$router->get('/master_data_pemda/new', 'CMS\Sample\SampleController@MasterDataPemdaNew');
$router->get('/master_data_pemda/edit/{id}', 'CMS\Sample\SampleController@MasterDataPemdaEdit');
$router->get('/master_data_pemda/{id}', 'CMS\Sample\SampleController@MasterDataPemdaDetail');

$router->get('/province', 'CMS\Sample\SampleController@MasterDataProvinceHome');
$router->get('/province/new', 'CMS\Sample\SampleController@MasterDataProvinceNew');
$router->get('/province/edit/{id}', 'CMS\Sample\SampleController@MasterDataProvinceEdit');
$router->get('/province/{id}', 'CMS\Sample\SampleController@MasterDataProvinceDetail');

$router->get('/kabupaten', 'CMS\Sample\SampleController@MasterDataKabupatenHome');
$router->get('/kabupaten/new', 'CMS\Sample\SampleController@MasterDataKabupatenNew');
$router->get('/kabupaten/edit/{id}', 'CMS\Sample\SampleController@MasterDataKabupatenEdit');
$router->get('/kabupaten/{id}', 'CMS\Sample\SampleController@MasterDataKabupatenDetail');

$router->get('/kecamatan', 'CMS\Sample\SampleController@MasterDataKecamatanHome');
$router->get('/kecamatan/new', 'CMS\Sample\SampleController@MasterDataKecamatanNew');
$router->get('/kecamatan/edit/{id}', 'CMS\Sample\SampleController@MasterDataKecamatanEdit');
$router->get('/kecamatan/{id}', 'CMS\Sample\SampleController@MasterDataKecamatanDetail');

$router->get('/desa', 'CMS\Sample\SampleController@MasterDataDesaHome');
$router->get('/desa/new', 'CMS\Sample\SampleController@MasterDataDesaNew');
$router->get('/desa/edit/{id}', 'CMS\Sample\SampleController@MasterDataDesaEdit');
$router->get('/desa/{id}', 'CMS\Sample\SampleController@MasterDataDesaDetail');

$router->get('/request_user', 'CMS\Sample\SampleController@RequestUserHome');
$router->get('/request_user/new', 'CMS\Sample\SampleController@RequestUserNew');
$router->get('/request_user/edit/{id}', 'CMS\Sample\SampleController@RequestUserEdit');
$router->get('/request_user/{id}', 'CMS\Sample\SampleController@RequestUserDetail');


$router->get('/sektor', 'CMS\Sample\SampleController@SektorHome');
$router->get('/sektor/new', 'CMS\Sample\SampleController@SektorNew');
$router->get('/sektor/edit/{id}', 'CMS\Sample\SampleController@SektorEdit');
$router->get('/sektor/{id}', 'CMS\Sample\SampleController@SektorDetail');

$router->get('/tahapan_project', 'CMS\Sample\SampleController@TahapanProjectHome');
$router->get('/tahapan_project/new', 'CMS\Sample\SampleController@TahapanProjectNew');
$router->get('/tahapan_project/edit/{id}', 'CMS\Sample\SampleController@TahapanProjectEdit');
$router->get('/tahapan_project/{id}', 'CMS\Sample\SampleController@TahapanProjectDetail');

$router->get('/jenis_dokumen', 'CMS\Sample\SampleController@JenisDokumenHome');
$router->get('/jenis_dokumen/new', 'CMS\Sample\SampleController@JenisDokumenNew');
$router->get('/jenis_dokumen/edit/{id}', 'CMS\Sample\SampleController@JenisDokumenEdit');
$router->get('/jenis_dokumen/{id}', 'CMS\Sample\SampleController@JenisDokumenDetail');


$router->get('/pembiayaan_daerah/{id}', 'CMS\Sample\SampleController@FormulirPembiayaanDaerahDetail');

$router->get('/laporan_detail_debitur', 'CMS\Sample\SampleController@LaporanDetailDebitur');
$router->get('/laporan_rekap_progress_permohonan_pemda', 'CMS\Sample\SampleController@LaporanRekapProgressPermohonanPemda');
$router->get('/laporan_rekap_sla_hari_kerja_permohonan', 'CMS\Sample\SampleController@LaporanRekapSLAKariKerjaPermohonan');
$router->get('/laporan_posisi_pinjaman', 'CMS\Sample\SampleController@LaporanPosisiPinjaman');
$router->get('/laporan_data_histori_pencairan', 'CMS\Sample\SampleController@LaporanDataHistoriPencairan');
$router->get('/laporan_data_histori_pembayaran', 'CMS\Sample\SampleController@LaporanDataHistoriPembayaran');
$router->get('/laporan_amortisasi_pinjaman_per_debitur', 'CMS\Sample\SampleController@LaporanAmortisasiPinjamanPerDebitur');
$router->get('/laporan_maturity', 'CMS\Sample\SampleController@LaporanMaturity');
$router->get('/custom_report_a', 'CMS\Sample\SampleController@CustomReportA');
$router->get('/custom_report_b', 'CMS\Sample\SampleController@CustomReportB');
