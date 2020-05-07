<!-- BEGIN SIDEBPANEL-->
<nav class="page-sidebar" data-pages="sidebar">
    <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
    <div class="sidebar-overlay-slide from-top" id="appMenu">
        <div class="row">
            <div class="col-xs-6 no-padding">
                <a href="#" class="p-l-40"><img src="/assets/img/demo/social_app.svg" alt="socail"></a>
            </div>
            <div class="col-xs-6 no-padding">
                <a href="#" class="p-l-10"><img src="/assets/img/demo/email_app.svg" alt="socail"></a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 m-t-20 no-padding">
                <a href="#" class="p-l-40"><img src="/assets/img/demo/calendar_app.svg" alt="socail"></a>
            </div>
            <div class="col-xs-6 m-t-20 no-padding">
                <a href="#" class="p-l-10"><img src="/assets/img/demo/add_more.svg" alt="socail"></a>
            </div>
        </div>
    </div>
    <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
    <!-- BEGIN SIDEBAR MENU HEADER-->
    <div class="sidebar-header">
        <img src="/assets/img/logo_white.png" alt="logo" class="brand" data-src="/assets/img/logo_white.png" data-src-retina="/assets/img/logo_white_2x.png" width="78" height="22">
        <div class="sidebar-header-controls">
            <button type="button" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20" data-pages-toggle="#appMenu"><i class="fa fa-angle-down fs-16"></i>
            </button>
            <button type="button" class="btn btn-link d-lg-inline-block d-xlg-inline-block d-md-inline-block d-sm-none d-none" data-toggle-pin="sidebar"><i class="fa fs-12"></i>
            </button>
        </div>
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->
    <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
            <li class="m-t-0 ">
                <a href="{!! url('/'); !!}" class="detailed">
                    <span class="title">Home</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-home"></i></span>
            </li>

            <li class="m-t-0 ">
                <a href="{!! url('/formulir_pembiayaan_daerah'); !!}" class="detailed">
                    <span class="title">Formulir Pembiayaan <br>Daerah</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-file"></i></span>
            </li>

            <li class="m-t-0 ">
                <a href="{!! url('/master_data_pemda'); !!}" class="detailed">
                    <span class="title">Master Data Pemda</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-address-card"></i></span>
            </li>

            <li class="open active">
                <a href="javascript:;">
                    <span class="title">Master Data Lokasi</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-chevron-right"></i></span>
                <ul class="sub-menu">
                    <li>
                        <a href="{!! url('/province'); !!}">Provinsi</a>
                        <span class="icon-thumbnail"><i class="fas fa-air-freshener"></i></span>
                    </li>
                    <li>
                        <a href="{!! url('/kabupaten'); !!}">Kabupaten / Kota</a>
                        <span class="icon-thumbnail"><i class="fas fa-air-freshener"></i></span>
                    </li>
                    <li>
                        <a href="{!! url('/kecamatan'); !!}">Kecamatan</a>
                        <span class="icon-thumbnail"><i class="fas fa-air-freshener"></i></span>
                    </li>
                    <li>
                        <a href="{!! url('/desa'); !!}">Desa</a>
                        <span class="icon-thumbnail"><i class="fas fa-air-freshener"></i></span>
                    </li>
                </ul>
            </li>
            <li class="open active">
                <a href="javascript:;">
                    <span class="title">LAPORAN</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-chevron-right"></i></span>
                <ul class="sub-menu">
                    <li>
                        <a href="{!! url('/laporan_detail_debitur'); !!}">Detail Debitur</a>
                        <span class="icon-thumbnail"><i class="fas fa-book"></i></span>
                    </li>
                    <li>
                        <a href="{!! url('/laporan_rekap_progress_permohonan_pemda'); !!}">Rekap Progress Permohonan PEMDA</a>
                        <span class="icon-thumbnail"><i class="fas fa-book"></i></span>
                    </li>
                    <li>
                        <a href="{!! url('/laporan_rekap_sla_hari_kerja_permohonan'); !!}">Rekap SLA hari kerja permohonan</a>
                        <span class="icon-thumbnail"><i class="fas fa-book"></i></span>
                    </li>
                    <li>
                        <a href="{!! url('/laporan_posisi_pinjaman'); !!}">Posisi Pinjaman</a>
                        <span class="icon-thumbnail"><i class="fas fa-book"></i></span>
                    </li>
                    <li>
                        <a href="{!! url('/laporan_data_histori_pencairan'); !!}">Data Histori Pencairan</a>
                        <span class="icon-thumbnail"><i class="fas fa-book"></i></span>
                    </li>
                    <li>
                        <a href="{!! url('/laporan_data_histori_pembayaran'); !!}">Data Histori Pembayaran</a>
                        <span class="icon-thumbnail"><i class="fas fa-book"></i></span>
                    </li>
                    <li>
                        <a href="{!! url('/laporan_amortisasi_pinjaman_per_debitur'); !!}">Amortisasi  Pinjaman per Debitur</a>
                        <span class="icon-thumbnail"><i class="fas fa-book"></i></span>
                    </li>
                    <li>
                        <a href="{!! url('/laporan_maturity'); !!}">Maturity Profile</a>
                        <span class="icon-thumbnail"><i class="fas fa-book"></i></span>
                    </li>
                    <li>
                        <a href="{!! url('/custom_report_a'); !!}">Custom Report A</a>
                        <span class="icon-thumbnail"><i class="fas fa-book"></i></span>
                    </li>
                    <li>
                        <a href="{!! url('/custom_report_b'); !!}">Custom Report B</a>
                        <span class="icon-thumbnail"><i class="fas fa-book"></i></span>
                    </li>
                </ul>
            </li>
            <li class="open active">
                <a href="{!! url('/logout'); !!}" class="detailed">
                    <span class="title">Logout</span>
                    <span class="details">Exit from the app</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-sign-out-alt"></i></span>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
</nav>
<!-- END SIDEBAR -->
