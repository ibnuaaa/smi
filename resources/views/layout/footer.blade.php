    <!-- BEGIN VENDOR JS -->
    <script src="/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/modernizr.custom.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/popper/umd/popper.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-actual/jquery.actual.min.js"></script>
    <script src="/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="/assets/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/classie/classie.js" type="text/javascript"></script>
    <script src="/assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/nvd3/lib/d3.v3.js" type="text/javascript"></script>
    <script src="/assets/plugins/nvd3/nv.d3.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/nvd3/src/utils.js" type="text/javascript"></script>
    <script src="/assets/plugins/nvd3/src/tooltip.js" type="text/javascript"></script>
    <script src="/assets/plugins/nvd3/src/interactiveLayer.js" type="text/javascript"></script>
    <script src="/assets/plugins/nvd3/src/models/axis.js" type="text/javascript"></script>
    <script src="/assets/plugins/nvd3/src/models/line.js" type="text/javascript"></script>
    <script src="/assets/plugins/nvd3/src/models/lineWithFocusChart.js" type="text/javascript"></script>
    <script src="/assets/plugins/mapplic/js/hammer.min.js"></script>
    <script src="/assets/plugins/mapplic/js/jquery.mousewheel.js"></script>
    <script src="/assets/plugins/mapplic/js/mapplic.js"></script>
    <script src="/assets/plugins/rickshaw/rickshaw.min.js"></script>
    <script src="/assets/plugins/jquery-sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/skycons/skycons.js" type="text/javascript"></script>
    <script src="/assets/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>
    <script src="/assets/plugins/axios/dist/axios.min.js"></script>
    <script src="/assets/plugins/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="/assets/plugins/formvalidation/dist/js/plugins/J.min.js"></script>
    <script src="/assets/plugins/formvalidation/dist/js/plugins/Bootstrap.min.js"></script>
    <script src="/assets/plugins/formvalidation/dist/js/plugins/Tachyons.min.js"></script>
    <script src="/assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="/assets/js/ckeditor.js"></script>
    <script src="/assets/plugins/jquery-simple-tree-table/jquery-simple-tree-table.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qs/6.8.0/qs.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/loadingoverlay.min.js" type="text/javascript"></script>
    <!-- <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script> -->
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="/pages/js/pages.js"></script>
    {{-- <script src="/pages/js/pages.email.js"></script> --}}
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="/assets/js/scripts.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->

    <script src="http://172.104.175.180:3000/socket.io/socket.io.js"></script>

    <script>
        Dropzone.autoDiscover = false;
        window.getCookie = function(cname) {
            var name = cname + '='
            var decodedCookie = decodeURIComponent(document.cookie)
            var ca = decodedCookie.split(';')
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i]
                while (c.charAt(0) == ' ') {
                    c = c.substring(1)
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length)
                }
            }
            return ''
        }
        window.appUrl = `${window.location.protocol}//${window.location.host}`
        window.apiUrl = `${window.location.protocol}//satellite-${window.location.host}`

        // window.axiosCaptcha = axios.create({
        //     baseURL: window.appUrl,
        //     timeout: 36000,
        //     headers: {}
        // })

        window.axios = axios.create({
            baseURL: window.apiUrl,
            timeout: 600000,
            headers: {}
        })

        window.showLoading = function() {
            $.LoadingOverlay("show");
        }
        window.hideLoading = function() {
            $.LoadingOverlay("hide");
        }

        axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response && error.response.data) {
                    console.log(
                        'REQUEST API ERROR :',
                        error.response.data,
                        'ON -> ',
                        error.response.request._url,
                        error.config && error.config.data ? JSON.parse(error.config.data) : null
                    )
                    console.log(error.response)
                }
                if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                    Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                }
                if (error.response && error.response.data && error.response.data.errors) {
                    let errors = ''
                    for (let i = 0; i < Object.keys(error.response.data.errors).length; i++) {
                        const key = Object.keys(error.response.data.errors)[i]
                        for (let j = 0; j < error.response.data.errors[key].length; j++) {
                            const message = error.response.data.errors[key][j]
                            let prefix = ', '
                            if (i === 0 && j === 0) {
                                prefix = ''
                            }
                            errors += `${prefix}${message}`
                        }
                    }
                    if (error.response && error.response.status === 401) {
                    } else {
                        Swal.fire({ title: 'Opps...', text: errors, type: 'error', confirmButtonText: 'Ok' })
                    }
                }
                return Promise.reject(error)
            }
        )

        if (getCookie('TokenType') != "" && getCookie('AccessToken')) {
            window.axios.defaults.headers['Authorization'] = `${getCookie('TokenType')} ${getCookie('AccessToken')}`
        }
        $(document).ready(function() {
            $.fn.datepicker.defaults.format = 'yyyy-mm-dd'

            if (getCookie('TokenType') != "" && getCookie('AccessToken')) {
                getNotificationSidebar();
            }

            reloadNotification();

        })

        function getNotificationSidebar() {
            window.axios.get('/mail/with.total/true/for/approval/is_unapproved/y').then((response) => {
                if(response.data.data.total > 0) {
                    $("#unapproved_counter").html(response.data.data.total);
                    $("#unapproved_counter").removeClass().addClass("show-notification-unread");
                } else {
                    $("#unapproved_counter").html("");
                    $("#unapproved_counter").removeClass().addClass("hide-notification");
                }
            })

            window.axios.get('/mail/with.total/true/for/surat_masuk/is_unread/y').then((response) => {
                if(response.data.data.total > 0) {
                    $("#surat_masuk_counter").html(response.data.data.total);
                    $("#surat_masuk_counter").removeClass().addClass("show-notification-unread");
                } else {
                    $("#surat_masuk_counter").html("");
                    $("#surat_masuk_counter").removeClass().addClass("hide-notification");
                }
            })

            window.axios.get('/notification/with.total/true/status/0').then((response) => {
                if(response.data.data.total > 0) {
                    $("#notification_counter").html(response.data.data.total);
                    $("#notification_counter").removeClass().addClass("show-notification-unread");

                    $("#red-dot").removeClass().addClass('bubble');
                } else {
                    $("#notification_counter").html("");
                    $("#notification_counter").removeClass().addClass("hide-notification");

                    $("#red-dot").removeClass().addClass("hide");
                }
            })

            window.axios.get('/mail/with.total/true/for/approval_numbering/mail_number_status/receive_read').then((response) => {
                if(response.data.data.total > 0) {
                    $("#need_number_counter").html(response.data.data.total);
                    $("#need_number_counter").removeClass().addClass("show-notification-unread");
                } else {
                    $("#need_number_counter").html("");
                    $("#need_number_counter").removeClass().addClass("hide-notification");
                }
            })
        }


        function reloadNotification() {
            // if (getCookie('TokenType') != "" && getCookie('AccessToken')) {
            //     getNotificationSidebar();
            // }

            // setTimeout(function(){
            //     reloadNotification();
            // }, 10000);
        }


        function getListNotification() {
            window.axios.get('/notification/with.total/true').then((response) => {

                var records = response.data.data.records
                var html = '';

                for (var i = 0; i < records.length; i++) {
                    var record = records[i];

                    html += ''
                        + '<div class="heading open">'
                        + '   <a href="#" class="text-complete pull-left d-flex align-items-center">'
                        + '     <i class="pg-icon m-r-10">mail</i>'
                        + '     <span class="bold">'+record.notification_type+'</span>'
                        + '   </a>'
                        + '   <div class="pull-right">'
                        + '     <div class="thumbnail-wrapper d16 circular inline m-t-15 m-r-10 toggle-more-details">'
                        + '       <div>'
                        + '       </div>'
                        + '     </div>'
                        + '     <span class=" time">'+record.created_at+'</span>'
                        + '   </div>'
                        + '   <div class="more-details">'
                        + '     <div class="more-details-inner">'
                        + '         <p class="small hint-text">'
                        + '             '+record.notification_text+''
                        + '         </p>'
                        + '     </div>'
                        + '   </div>'
                        + ' </div>';
                }

                $('#list_notification').html(html)

            })
        }

        // var socket = io('http://172.104.175.180:3000');
        // socket.on('connect', function(){
        //     socket.on('message', function(data){
        //         console.log('broadcast1');
        //         getNotificationSidebar();
        //     });
        // });
    </script>
    @yield('script')
    @yield('formValidationScript')
    <!-- END PAGE LEVEL JS -->
</body>
</html>
