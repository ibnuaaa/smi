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
            <li class="m-t-30 ">
                <a href="{!! url('/'); !!}" class="detailed">
                    <span class="title">Dashboard</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
            </li>

            @if (getPermissions('menu_tulis_surat')['checked'])
            <li class="open active">
                <a href="javascript:;">
                    <span class="title">Tulis Surat</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-chevron-right"></i></span>
                <ul class="sub-menu">
                    @if (getPermissions('menu_surat_internal')['checked'])
                    <li>
                        <a href="{!! url('/surat_internal'); !!}">Surat Internal</a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('menu_upload_surat_masuk')['checked'])
                    <li>
                        <a href="{!! url('/upload_surat_masuk'); !!}">Upload Surat Masuk</a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (getPermissions('menu_kotak_masuk')['checked'])
            <li class="open active">
                <a href="javascript:;">
                    <span class="title">Kotak Masuk</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-chevron-right"></i></span>
                <ul class="sub-menu">
                    @if (getPermissions('menu_surat_masuk')['checked'])
                    <li>
                        <a href="{!! url('/surat_masuk'); !!}">
                            Surat Masuk
                            <span class="{{ (getMenuCounter('surat_masuk_count') > 0) ? 'show-notification-unread' : 'hide-notification' }}" id="surat_masuk_counter">
                                {{getMenuCounter('surat_masuk_count')}}
                            </span>
                        </a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('menu_disposisi')['checked'])
                    <li>
                        <a href="{!! url('/disposisi'); !!}">
                            Disposisi
                        </a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (getPermissions('menu_kotak_keluar')['checked'])
            <li class="open active">
                <a href="javascript:;">
                    <span class="title">Kotak Keluar</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-chevron-right"></i></span>
                <ul class="sub-menu">
                    @if (getPermissions('menu_approval')['checked'])
                    <li>
                        <a href="{!! url('/surat_keluar'); !!}">
                            Surat Keluar
                        </a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i>
                    </li>
                    @endif
                    @if (getPermissions('menu_approval')['checked'])
                    <li>
                        <a href="{!! url('/approval'); !!}">
                            Approval

                            <span class="{{ (getMenuCounter('unapproved_count') > 0) ? 'show-notification-unapproved' : 'hide-notification' }}" id="unapproved_counter">
                                {{getMenuCounter('unapproved_count')}}
                            </span>
                        </a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('menu_mail_number_approval')['checked'])
                    <li>
                        <a href="{!! url('/approval_numbering'); !!}">
                            Approval No Surat
                            <span id="need_number_counter">
                            </span>
                        </a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (getPermissions('menu_user')['checked'])
            <li class="open active">
                <a href="javascript:;">
                    <span class="title">User</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-chevron-right"></i></span>
                <ul class="sub-menu">
                    @if (getPermissions('menu_profil_user')['checked'])
                    <li>
                        <a href="{!! url('/profile'); !!}">Profil User</a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('menu_jabatan')['checked'])
                    <li>
                        <a href="{!! url('/position/paging'); !!}">Jabatan</a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('menu_notifikasi')['checked'])
                    <li>
                        <a href="{!! url('/notifikasi'); !!}">
                            Notifikasi
                            <span class="show-notification-unread" id="notification_counter">
                                0
                            </span>
                        </a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('menu_ganti_password')['checked'])
                    <li>
                        <a href="{!! url('/change_password'); !!}">Ganti Password</a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('menu_semua_user')['checked'])
                    <li>
                        <a href="{!! url('/user'); !!}">Semua User</a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('menu_audit_trail')['checked'])
                    <li>
                        <a href="{!! url('/audit_trail'); !!}">Audit Trail</a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('menu_informasi')['checked'])
                    <li>
                        <a href="{!! url('/information'); !!}">Informasi</a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('menu_config_numbering')['checked'])
                    <li>
                        <a href="{!! url('/config_numbering'); !!}">Setting Numbering</a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('menu_mail_classification')['checked'])
                    <li>
                        <a href="{!! url('/mail_classification'); !!}">Klasifikasi Surat</a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('menu_disposition_follow_up')['checked'])
                    <li>
                        <a href="{!! url('/disposition_follow_up'); !!}">Tindak Lanjut Disposisi</a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                    @endif
                    <li>
                        <a href="{!! url('/config'); !!}">Setting</a>
                        <span class="icon-thumbnail"><i class="fas fa-bezier-curve"></i></span>
                    </li>
                </ul>
            </li>
            @endif
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
