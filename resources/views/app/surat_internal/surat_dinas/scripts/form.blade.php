<script>
var action = null;
var position_id = '{{ MyAccount()->position_id }}';
var position_count = 0;
var source_eselon_id = 0

@if ($id)
    var isAvailableToAddCheckerSigner = false
@else
    var isAvailableToAddCheckerSigner = true
@endif

$(document).ready(function() {
    source_eselon_id = $('select[name=source_position_id]').find(':selected').attr('data-eselonid')

    $('select[name=mail_number_prefix]').select2({
        ajax: {
            url: window.apiUrl + '/mail_number_classification',
            headers: {
                'Authorization': window.axios.defaults.headers['Authorization']
            },
            dataType: 'json',
            delay: 50,
            cache: true,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data.records, function (item) {
                        return {
                            text: item.code + " (" + item.name + ")",
                            id: item.code
                        }
                    })
                };
            }
        },
        minimumInputLength: 1,
    });


    @if ($id)
        getEditData();
    @else
        getMailNumberSuffix()
    @endif

    $('select[name=source_position_id]').change(function(e){
        clearCheckerSigner()

        console.log('xxxxxxxxxxxxxxxxxx')
        console.log($('select[name=source_position_id]').val())
        console.log('yyyyyyyyyyy')


        @if (in_array($eselon_id, array(5,4)))
            if (isAvailableToAddCheckerSigner)
            {
                addCheckerSigner();
            }
        @else
            if (isAvailableToAddCheckerSigner)
            {

                if (position_id == $('select[name=source_position_id]').val()) {
                    addCheckerSignerMySelf();
                } else {
                    addCheckerSigner();
                }

            }
        @endif

        getMailNumberSuffix()
        source_eselon_id = e.target.options[e.target.selectedIndex].dataset.eselonid

        isAvailableToAddCheckerSigner = true;
    });

    const form = document.getElementById('editUserForm')
    const saveMailForm = $('#saveMailForm').formValidation({
        fields: {
            about: {
                validators: {
                    notEmpty: {
                        message: 'Hal harus diisi'
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap(),
            submitButton: new FormValidation.plugins.SubmitButton(),
            icon: new FormValidation.plugins.Icon({
                valid: 'fa fa-check',
                invalid: 'fa fa-times',
                validating: 'fa fa-refresh',
            })
        }
    }).data('formValidation')


    var total_saved_image = 0;
    $('#actions .saveAction').click(function(e) {

        getMailToArray()

        action =  e.target.id;

        saveMailForm.validate().then(function(status) {
            if (status === 'Valid') {

                const source_position_id = $('select[name="source_position_id"]')
                const mail_date = $('input[name="mail_date"]')
                const mail_number_prefix = $('select[name="mail_number_prefix"]')
                const mail_number_suffix = $('input[name="mail_number_suffix"]')
                const content = this.editor.getData();
                const privacy_type = $('select[name="privacy_type"]')
                const tembusan = $('textarea[name="tembusan"]')
                const about = $('input[name="about"]')

                let mail_data = []
                $("#saveMailForm #text").each ( function() {
                    var key = $(this).attr('name');
                    var val = $(this).val();

                    mail_data.push({
                        key: key,
                        value: val
                    })
                });

                var total_empty_mail_to = 0
                for (var i = 0; i < r_mail_to.length; i++)
                {
                    if (!r_mail_to[i].position_id || r_mail_to[i].position_id == '') total_empty_mail_to++;
                }

                if (total_empty_mail_to > 0 || r_mail_to.length == 0) {
                    // JIKA TUJUAN KOSONG
                    Swal.fire({ title: 'Opps!', text: 'Tujuan tidak boleh kosong', type: 'error', confirmButtonText: 'Ok' })
                }
                else {
                    const data = {
                        mail_to: JSON.stringify(r_mail_to),
                        mail_copy_to: JSON.stringify(r_mail_copy_to),
                        mail_date: mail_date.val(),
                        mail_number_prefix: mail_number_prefix.val(),
                        mail_number_suffix: mail_number_suffix.val(),
                        content: content,
                        privacy_type: privacy_type.val(),
                        tembusan: tembusan.val(),
                        about: about.val(),
                        approval: JSON.stringify(r_approval),
                        mail_principle: JSON.stringify(r_dasar),
                        action: action,
                        source_position_id: source_position_id.val(),
                        mail_template_id: '{{ $mail_template_id }}',
                        mail_detail: JSON.stringify(mail_data),
                        disposition_id: '{{ $disposition_id }}'
                    }

                    showLoading()
                    axios.post('/mail', data).then((response) => {
                        const { data } = response.data

                        for (var i = 0; i < files.length; i++) {
                            // START SAVE LAMPIRAN
                            const data_storage = {
                                object: 'lampiran',
                                object_id: data.id,
                                file: JSON.stringify(files[i])
                            };

                            axios.post('/storage/save', data_storage).then((response) => {
                                total_saved_image++;

                                if (total_saved_image >= files.length) {
                                    window.location = '{{ (url('/surat/preview/')) }}/' + data.id + '/surat_keluar';
                                }

                            }).catch((error) => {
                                if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                                    Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                                    hideLoading()
                                }
                            })
                            // END SAVE LAMPIRAN
                        }

                        if (files.length < 1) {
                            window.location = '{{ (url('/surat/preview/')) }}/' + data.id + '/surat_keluar';
                        }

                        hideLoading()
                    }).catch((error) => {
                        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                            Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                            hideLoading()
                        }
                    })
                }
            }
        })
    })


    $('#actions .saveUpdateAction').click(function(e) {

        action =  e.target.id;

        getApprovalArray();
        getMailToArray();
        getDasarArray();
        getMailCopyToArray();


        saveMailForm.validate().then(function(status) {
            if (status === 'Valid') {

                const source_position_id = $('select[name="source_position_id"]')
                const mail_date = $('input[name="mail_date"]')
                const mail_number = $('input[name="mail_number"]')
                const mail_number_prefix = $('select[name="mail_number_prefix"]')
                const mail_number_suffix = $('input[name="mail_number_suffix"]')
                const content = this.editor.getData();
                const privacy_type = $('select[name="privacy_type"]')
                const tembusan = $('textarea[name="tembusan"]')
                const about = $('input[name="about"]')

                @if ($eselon_id != 5)
                    //action = 'kirim';
                @endif

                const data = {
                    mail_to: JSON.stringify(r_mail_to),
                    mail_copy_to: JSON.stringify(r_mail_copy_to),
                    mail_date: mail_date.val(),
                    mail_number: mail_number.val(),
                    mail_number_prefix: mail_number_prefix.val(),
                    mail_number_suffix: mail_number_suffix.val(),
                    content: content,
                    privacy_type: privacy_type.val(),
                    tembusan: tembusan.val(),
                    about: about.val(),
                    approval: JSON.stringify(r_approval),
                    mail_principle: JSON.stringify(r_dasar),
                    action: action,
                    source_position_id: source_position_id.val()
                }

                showLoading()
                axios.put('/mail/{{$id}}', data).then((response) => {
                    const { data } = response.data

                    @if (!empty($mail))
                        @if ($mail->created_user_id == MyAccount()->id)
                            var url_destination = 'surat_keluar';
                        @else
                            var url_destination = 'approval';
                        @endif
                    @else
                        var url_destination = 'surat_keluar';
                    @endif

                    window.location = '{{ (url('/surat/preview/')) }}/' + data.id + '/' + url_destination;
                    hideLoading()
                }).catch((error) => {
                    if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                        Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                        hideLoading()
                    }
                })
            }
        })
    })


    $('.select2-ajax').each(function(){
        $(this).select2({
            ajax: {
                url: window.apiUrl + $(this).data('link'),
                headers: {
                    'Authorization': window.axios.defaults.headers['Authorization']
                },
                dataType: 'json',
                delay: 50,
                cache: true,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data.records, function (item) {
                            return {
                                text: item.name + " / NIP." + item.username + " / " + (item.position ? item.position.name : ''),
                                id: item.id
                            }
                        })
                    };
                }
            },
            minimumInputLength: 1,
        });
    });

    @if (!$id)

    @if (in_array($eselon_id, array(5,4)))
        addCheckerSigner();
    @else
        addCheckerSignerMySelf();
    @endif

    addMailTo();
    addMailCopyTo();
    addDasar();
    @endif

})


function MinHeightPlugin(editor) {
  this.editor = editor;
}

MinHeightPlugin.prototype.init = function() {
  this.editor.ui.view.editable.extendTemplate({
    attributes: {
      style: {
        minHeight: '300px'
      }
    }
  });
};

ClassicEditor.builtinPlugins.push(MinHeightPlugin);
ClassicEditor
    .create( document.querySelector( '#editor' ), {
    } )
    .then( editor => {
        window.editor = editor;
    } )
    .catch( err => {
        console.error( err.stack );
    } );


function addCheckerSignerMySelf() {

    var tipe_user_component = $('<select name="tipe_user" data-minimum-results-for-search="Infinity" class="full-width">'
                                + '<option value="checker">Checker</option>'
                                + '<option value="signer" selected>Signer</option>'
                                + '</select>');
    var checker_signer_component = $('<select class="full-width" data-id="" name="checker_signer"></select>');
    var remove_component = $('<button class="btn btn-danger" onClick="return remove_node(this)"><i class="fas fa-trash"></i></button>');


    var col_1 = $('<div class="form-group col-md-2 tipe_user"></div>');
    var col_2 = $('<div class="form-group col-md-9 checker_signer"></div>');
    var col_3 = $('<div class="form-group col-md-1"></div>');

    col_1.append(tipe_user_component)
    col_2.append(checker_signer_component)
    col_3.append(remove_component)


    var row = $('<div class="row list"></div>');
    row.append(col_1)
    row.append(col_2)
    row.append(col_3)

    $('#checker_signer_container').append(row);

    tipe_user_component.select2();


    checker_signer_component.select2(
    {
        ajax: {
            url: window.apiUrl + '/position/status/active',
            headers: {
                'Authorization': window.axios.defaults.headers['Authorization']
            },
            dataType: 'json',
            delay: 50,
            cache: true,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data.records, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            }
        },
        minimumInputLength: 1,
    });


    var last_position_id = position_id
    var last_eselon_id = 0


    if(r_approval.length > 0) {
        for (var i = 0; i < r_approval.length; i++) {
            if(r_approval[i] && r_approval[i].position_id) last_position_id = r_approval[i].position_id
            if(r_approval[i] && r_approval[i].eselon_id) last_eselon_id = r_approval[i].eselon_id
        }
    }

    axios.get('/position/set/first/id/' + last_position_id).then((response) => {

        var data = {
            id: response.data.data.records.id + '/' + response.data.data.records.eselon_id,
            text: response.data.data.records.user.name + ' / '
                + response.data.data.records.user.username + ' / '
                + response.data.data.records.user.position.name
        };

        var newOption = new Option(data.text, data.id, false, false);
        $(checker_signer_component).append(newOption).trigger('change');

        position_count++;

        addCheckerSigner();
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })


    $(checker_signer_component).change(function() {
        getApprovalArray();
    });

    $('#checker_signer_container').each(function(index, row) {
        $(row).find('.tipe_user').children('select').val('checker').trigger('change');
    });

    $('#checker_signer_container').children('div').last().find('.tipe_user').children('select').val('signer').trigger('change');

    getApprovalArray();


    return false;
}


function addCheckerSigner() {

    var last_eselon_id = ''
    if(r_approval.length > 0) {
        for (var i = 0; i < r_approval.length; i++) {
            if(r_approval[i] && r_approval[i].eselon_id) last_eselon_id = r_approval[i].eselon_id
        }
    }

    if (source_eselon_id == '') source_eselon_id = 0


    if (last_eselon_id == '' ||  (last_eselon_id) > source_eselon_id) {

        var tipe_user_component = $('<select name="tipe_user" data-minimum-results-for-search="Infinity" class="full-width">'
                                    + '<option value="checker">Checker</option>'
                                    + '<option value="signer" selected>Signer</option>'
                                    + '</select>');
        var checker_signer_component = $('<select class="full-width" data-id="" name="checker_signer"></select>');
        var remove_component = $('<button class="btn btn-danger" onClick="return remove_node(this)"><i class="fas fa-trash"></i></button>');


        var col_1 = $('<div class="form-group col-md-2 tipe_user"></div>');
        var col_2 = $('<div class="form-group col-md-9 checker_signer"></div>');
        var col_3 = $('<div class="form-group col-md-1"></div>');

        col_1.append(tipe_user_component)
        col_2.append(checker_signer_component)
        if(position_count > 0)col_3.append(remove_component)


        var row = $('<div class="row list"></div>');
        row.append(col_1)
        row.append(col_2)
        row.append(col_3)

        $('#checker_signer_container').append(row);

        tipe_user_component.select2();


        checker_signer_component.select2(
        {
            ajax: {
                url: window.apiUrl + '/position/status/active',
                headers: {
                    'Authorization': window.axios.defaults.headers['Authorization']
                },
                dataType: 'json',
                delay: 50,
                cache: true,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data.records, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }
            },
            minimumInputLength: 1,
        });


        var last_position_id = position_id
        var last_eselon_id = 0


        if(r_approval.length > 0) {
            for (var i = 0; i < r_approval.length; i++) {
                if(r_approval[i] && r_approval[i].position_id) last_position_id = r_approval[i].position_id
                if(r_approval[i] && r_approval[i].eselon_id) last_eselon_id = r_approval[i].eselon_id
            }
        }

        axios.get('/position/set/first/id/' + last_position_id).then((response) => {
            var data = {
                id: response.data.data.records.parent.user.position_id + '/' + response.data.data.records.parent.eselon_id,
                text: response.data.data.records.parent.user.name + ' / '
                    + response.data.data.records.parent.user.username + ' / '
                    + response.data.data.records.parent.user.position.name
            };

            // position_id = response.data.data.records.parent.user.position_id

            var newOption = new Option(data.text, data.id, false, false);
            $(checker_signer_component).append(newOption).trigger('change');

            // SET DISABLE
            // $(checker_signer_component).prop("disabled", true);
            // $(tipe_user_component).prop("disabled", true);

            position_count++;


            // if(position_count < 2)
            addCheckerSigner();
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            }
        })


        $(checker_signer_component).change(function() {
            getApprovalArray();
        });

        $('#checker_signer_container').each(function(index, row) {
            $(row).find('.tipe_user').children('select').val('checker').trigger('change');
        });

        $('#checker_signer_container').children('div').last().find('.tipe_user').children('select').val('signer').trigger('change');

        getApprovalArray();
    }

    return false;
}


function addDasar() {
    var dasar_component = $('<textarea class="form-control" name="dasar"></textarea>');
    var remove_component = $('<button class="btn btn-danger" onClick="return remove_node(this)"><i class="fas fa-trash"></i></button>');

    var col_1 = $('<div class="form-group col-md-11 dasar"></div>');
    var col_2 = $('<div class="form-group col-md-1"></div>');

    col_1.append(dasar_component);
    col_2.append(remove_component)

    var row = $('<div class="row list"></div>');
    row.append(col_1)
    row.append(col_2)

    $(dasar_component).change(function() {
        getDasarArray()
    });

    $('#dasar_container').append(row);

    return false;
}


function addMailTo() {
    var mail_to_component = $('<select class="full-width" data-id="" name="mail_to"></select>');
    var remove_component = $('<button class="btn btn-danger" onClick="return remove_node(this)"><i class="fas fa-trash"></i></button>');


    var col_2 = $('<div class="form-group col-md-11 mail_to"></div>');
    var col_3 = $('<div class="form-group col-md-1"></div>');

    col_2.append(mail_to_component)
    col_3.append(remove_component)


    var row = $('<div class="row list"></div>');
    row.append(col_2)
    row.append(col_3)

    $('#mail_to_container').append(row);

    mail_to_component.select2({
        ajax: {
            url: window.apiUrl + '/position/status/active/criteria/{{ strtolower($mail_template->mail_code) }}',
            headers: {
                'Authorization': window.axios.defaults.headers['Authorization']
            },
            dataType: 'json',
            delay: 50,
            cache: true,
            data: function (params) {
                return {
                    q: params.term,
                    source_position_id: $('select[name=source_position_id]').val(),
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data.records, function (item) {
                        return {
                            text: item.name + " (Pejabat : " + (item.user ? item.user.name : '') + "  / NIP." + (item.user ? item.user.username : '') + ") ",
                            id: item.id
                        }
                    })
                };
            }
        },
        minimumInputLength: 1,
    });

    $(mail_to_component).change(function() {
        getMailToArray();
    });

    getMailToArray();

    return false;
}

function addMailCopyTo() {
    var mail_copy_to_component = $('<select class="full-width" data-id="" name="mail_copy_to"></select>');
    var remove_component = $('<button class="btn btn-danger" onClick="return remove_node(this)"><i class="fas fa-trash"></i></button>');


    var col_2 = $('<div class="form-group col-md-11 mail_copy_to"></div>');
    var col_3 = $('<div class="form-group col-md-1"></div>');

    col_2.append(mail_copy_to_component)
    col_3.append(remove_component)


    var row = $('<div class="row list"></div>');
    row.append(col_2)
    row.append(col_3)

    $('#mail_copy_to_container').append(row);

    mail_copy_to_component.select2({
        ajax: {
            url: window.apiUrl + '/position/status/active',
            headers: {
                'Authorization': window.axios.defaults.headers['Authorization']
            },
            dataType: 'json',
            delay: 50,
            cache: true,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data.records, function (item) {
                        return {
                            text: item.name + " (Pejabat : " + (item.user ? item.user.name : '') + "  / NIP." + (item.user ? item.user.username : '') + ") ",
                            id: item.id
                        }
                    })
                };
            }
        },
        minimumInputLength: 1,
    });

    $(mail_copy_to_component).change(function() {
        getMailCopyToArray();
    });

    getMailCopyToArray();

    return false;
}

function remove_node(d) {
    $(d).parent().parent().remove();

    $('#checker_signer_container').each(function(index, row) {
        $(row).find('.tipe_user').children('select').val('checker').trigger('change');
    });

    $('#checker_signer_container').children('div').last().find('.tipe_user').children('select').val('signer').trigger('change');

    getApprovalArray();
    getMailToArray();
    getMailCopyToArray();
    getDasarArray();


    return false;
}

var r_approval = [];
function getApprovalArray() {
    r_approval = [];
    $('#checker_signer_container .list').each(function(index, row) {
        var type = $(row).find('.tipe_user').children('select').val() == 'checker' ? '1' : '2';

        var e = $(row).find('.checker_signer').children('select')

        var position_id_eselon_id = $(row).find('.checker_signer').children('select').val()
        if(position_id_eselon_id) {
            var position_id_eselon_id_arr = position_id_eselon_id.split("/")
            var position_id = position_id_eselon_id_arr[0]
            var eselon_id = position_id_eselon_id_arr[1]

            r_approval.push({
                id: $(row).find('.checker_signer').children('select').attr('data-id'),
                type: type,
                position_id: position_id,
                eselon_id: eselon_id
            });
        }
    });
}

var r_mail_to = [];
function getMailToArray() {
    r_mail_to = [];
    $('#mail_to_container .list').each(function(index, row) {
        r_mail_to.push({
            id: $(row).find('.mail_to').children('select').attr('data-id'),
            position_id: $(row).find('.mail_to').children('select').val()
        });
    });
}

var r_mail_copy_to = [];
function getMailCopyToArray() {
    r_mail_copy_to = [];
    $('#mail_copy_to_container .list').each(function(index, row) {
        r_mail_copy_to.push({
            id: $(row).find('.mail_copy_to').children('select').attr('data-id'),
            position_id: $(row).find('.mail_copy_to').children('select').val()
        });
    });
}

var r_dasar = [];
function getDasarArray() {
    r_dasar = [];
    $('#dasar_container .list').each(function(index, row) {
        r_dasar.push({
            id: $(row).find('.dasar').children('select').attr('data-id'),
            principle: $(row).find('.dasar').children('textarea').val()
        });
    });
}

function getEditData() {
    var id = '{{ $id }}';

    axios.get('/mail/id/' + id + '/set/first').then((response) => {

        var data = response.data.data.records;

        const source_position_id = $('select[name="source_position_id"]')
        const mail_date = $('input[name="mail_date"]')
        const mail_number = $('input[name="mail_number"]')

        const privacy_type = $('select[name="privacy_type"]')
        const tembusan = $('textarea[name="tembusan"]')
        const about = $('input[name="about"]')
        const mail_number_prefix = $('select[name="mail_number_prefix"]')
        const mail_number_suffix = $('input[name="mail_number_suffix"]')

        source_position_id.val(data.source_position_id).trigger('change');
        mail_date.val(data.mail_date);
        mail_number.val(data.mail_number);
        privacy_type.val(data.privacy_type).trigger('change');
        tembusan.val(data.tembusan);
        about.val(data.about);
        this.editor.setData(data.content);

        var newOption = new Option('{{ !empty($selected['mail_classification']->code) ? "[".$selected['mail_classification']->code."] ".$selected['mail_classification']->name : '' }}', data.mail_number_prefix, false, false);
        mail_number_prefix.append(newOption).trigger('change');


        // mail_number_prefix.val(data.mail_number_prefix).trigger('change');
        mail_number_suffix.val(data.mail_number_suffix);

        for (var i = 0; i < data.approval.length; i++) {
            var approval = data.approval[i];
            setEditApproval(approval, i);
        }

        for (var i = 0; i < data.mail_destination.length; i++) {
            var mail_destination = data.mail_destination[i];
            setEditMailTo(mail_destination);
        }

        for (var i = 0; i < data.mail_copy_to.length; i++) {
            var mail_copy = data.mail_copy_to[i];
            // setEditMailCopyTo(mail_copy);
        }

        for (var i = 0; i < data.principle.length; i++) {
            var principle = data.principle[i];
            setEditMailPrinciple(principle);
        }

        for (var i = 0; i < data.lampiran.length; i++) {
            var lampiran = data.lampiran[i];
            var preview = $(".img-preview-lampiran");

            var ext = lampiran.storage.extension.toLowerCase();
            if (ext == 'png' || ext == 'jpg' || ext == 'bmp') {
                preview.prepend("<div style='float:left;position:relative;margin-bottom:10px;'>"
                    + "<button class='btn btn-danger btn-xs' onClick='removeFile("+lampiran.id+", this)' style='position:absolute;left:3px;border:solid 1px;' data-key='"+data.key+"'>"
                    + "<i class='fa fa-trash'></i></button>"
                    + "<img src='"+window.apiUrl+"/storage/"+lampiran.storage.key+"' style='height:80px;margin-left:5px;'/></div>");
            } else {
                preview.prepend("<div style='float:left;position:relative;margin-bottom:10px;'>"
                    + "<button class='btn btn-danger btn-xs' onClick='removeFile("+lampiran.id+", this)' style='position:absolute;left:3px;border:solid 1px;' data-key='"+data.key+"'>"
                    + "<i class='fa fa-trash'></i></button>"
                    + "<i class='fas fa-file' style='height:80px;margin-left:0px;font-size:75px;'></i></div>");
            }
        }

    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}

function setEditApproval(approval, i) {

    var tipe_user_component = $('<select name="tipe_user" data-minimum-results-for-search="Infinity" class="full-width">'
                                + '<option value="checker" '+ (approval.type == '1' ? 'selected': '') + '>Checker</option>'
                                + '<option value="signer" '+ (approval.type == '2' ? 'selected': '') + '>Signer</option>'
                                + '</select>');
    var checker_signer_component = $('<select data-id="'+approval.id+'" class="full-width" name="checker_signer"></select>');
    var remove_component = $('<button class="btn btn-danger" onClick="return remove_node(this)"><i class="fas fa-trash"></i></button>');


    var col_1 = $('<div class="form-group col-md-2 tipe_user"></div>');
    var col_2 = $('<div class="form-group col-md-9 checker_signer"></div>');
    var col_3 = $('<div class="form-group col-md-1"></div>');

    col_1.append(tipe_user_component)
    col_2.append(checker_signer_component)

    if (i > 0) col_3.append(remove_component)


    var row = $('<div class="row list"></div>');
    row.append(col_1)
    row.append(col_2)
    row.append(col_3)

    $('#checker_signer_container').append(row);

    tipe_user_component.select2();


    checker_signer_component.select2(
    {
        ajax: {
            url: window.apiUrl + '/position/status/active',
            headers: {
                'Authorization': window.axios.defaults.headers['Authorization']
            },
            dataType: 'json',
            delay: 50,
            cache: true,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data.records, function (item) {
                        return {
                            text: item.name + " (Pejabat : " + (item.user ? item.user.name : '') + "  / NIP." + (item.user ? item.user.username : '') + ") ",
                            id: item.id
                        }
                    })
                };
            }
        },
        minimumInputLength: 1,
    });

    var data = {
        id: approval.position_id+'/'+approval.position.eselon_id,
        text: approval.position.user_without_position.name + ' / '
            + approval.position.user_without_position.username + ' / '
            + approval.position.name
    };

    var newOption = new Option(data.text, data.id, false, false);
    $(checker_signer_component).append(newOption).trigger('change');

    getApprovalArray();

    // SET DISABLE
    // $(checker_signer_component).prop("disabled", true);
    // $(tipe_user_component).prop("disabled", true);
}

function setEditMailTo(mail_destination) {
    var mail_to_component = $('<select class="full-width" data-id="'+mail_destination.id+'" name="mail_to"></select>');
    var remove_component = $('<button class="btn btn-danger" onClick="return remove_node(this)"><i class="fas fa-trash"></i></button>');


    var col_2 = $('<div class="form-group col-md-11 mail_to"></div>');
    var col_3 = $('<div class="form-group col-md-1"></div>');

    col_2.append(mail_to_component)
    col_3.append(remove_component)


    var row = $('<div class="row list"></div>');
    row.append(col_2)
    row.append(col_3)

    $('#mail_to_container').append(row);

    mail_to_component.select2({
        ajax: {
            url: window.apiUrl + '/position/status/active',
            headers: {
                'Authorization': window.axios.defaults.headers['Authorization']
            },
            dataType: 'json',
            delay: 50,
            cache: true,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data.records, function (item) {
                        return {
                            text: item.name + " (Pejabat : " + (item.user ? item.user.name : '') + "  / NIP." + (item.user ? item.user.username : '') + ") ",
                            id: item.id
                        }
                    })
                };
            }
        },
        minimumInputLength: 1,
    });

    if(mail_destination && mail_destination.position && mail_destination.position.user_without_position && mail_destination.position) {
        var data = {
            id: mail_destination.position.id,
            text: mail_destination.position.user_without_position.name + ' / '
                + mail_destination.position.user_without_position.username + ' / '
                + mail_destination.position.name
        };
        var newOption = new Option(data.text, data.id, false, false);
    }
    $(mail_to_component).append(newOption).trigger('change');
}


function setEditMailPrinciple(mail_principle) {
    var dasar_component = $('<textarea class="form-control" name="dasar"></textarea>');
    var remove_component = $('<button class="btn btn-danger" onClick="return remove_node(this)"><i class="fas fa-trash"></i></button>');

    var col_1 = $('<div class="form-group col-md-11 dasar"></div>');
    var col_2 = $('<div class="form-group col-md-1"></div>');

    col_1.append(dasar_component);
    col_2.append(remove_component)

    var row = $('<div class="row list"></div>');
    row.append(col_1)
    row.append(col_2)

    $(dasar_component).change(function() {
        getDasarArray()
    });

    $('#dasar_container').append(row);

    dasar_component.val(mail_principle.principle);

    return false;
}

function setEditMailCopyTo(mail_copy) {
    var mail_copy_to_component = $('<select class="full-width" data-id="'+mail_copy.id+'" name="mail_copy_to"></select>');
    var remove_component = $('<button class="btn btn-danger" onClick="return remove_node(this)"><i class="fas fa-trash"></i></button>');

    var col_2 = $('<div class="form-group col-md-11 mail_copy_to"></div>');
    var col_3 = $('<div class="form-group col-md-1"></div>');

    col_2.append(mail_copy_to_component)
    col_3.append(remove_component)


    var row = $('<div class="row list"></div>');
    row.append(col_2)
    row.append(col_3)

    $('#mail_copy_to_container').append(row);

    mail_copy_to_component.select2({
        ajax: {
            url: window.apiUrl + '/position/status/active',
            headers: {
                'Authorization': window.axios.defaults.headers['Authorization']
            },
            dataType: 'json',
            delay: 50,
            cache: true,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data.records, function (item) {
                        return {
                            text: item.name + " (Pejabat : " + (item.user ? item.user.name : '') + "  / NIP." + (item.user ? item.user.username : '') + ") ",
                            id: item.id
                        }
                    })
                };
            }
        },
        minimumInputLength: 1,
    });

    var data = {
        id: mail_copy.position.id,
        text: mail_copy.position.user_without_position.name + ' / '
            + mail_copy.position.user_without_position.username + ' / '
            + mail_copy.position.name
    };

    var newOption = new Option(data.text, data.id, false, false);
    $(mail_copy_to_component).append(newOption).trigger('change');
}


    function prepareUpload(el) {
      var files = $(el)[0].files;
      var preview = $(el).siblings("#img-preview");
      for (i = 0; i < files.length; i++) {
        uploadFile(files[i], preview);
      }
    }


    var files = [];
    function uploadFile(file, preview) {
      showLoading()
      var formData = new FormData();
      formData.append('file', file);

        $.ajax({
            url: window.apiUrl + '/upload',
                type: 'post',
                data: formData,
                beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', window.axios.defaults.headers['Authorization'])
            },
            contentType: false,
            processData: false,
            success: function(response) {

                @if (!$id)
                    files.push(response.data);
                    hideLoading()
                @else

                    const data_storage = {
                        object: 'lampiran',
                        object_id: '{{$id}}',
                        file: JSON.stringify(response.data)
                    };

                    axios.post('/storage/save', data_storage).then((response) => {
                            hideLoading()
                        }).catch((error) => {
                            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                                hideLoading()
                            }
                        })

                @endif

                appendImage(preview, response.data)
            }
        });

    }

    function appendImage(preview, data) {

        img = "";
        if(data.extension.toLowerCase() == 'jpg' || data.extension.toLowerCase() == 'png' || data.extension.toLowerCase() == 'bmp')
        img = "<img src='"+window.apiUrl+"/tmp/"+data.key+"."+data.extension+"' style='height:80px;'/>";
        else
        img = "<i class='fas fa-file' style='height:80px;font-size:80px;'></i>";

        preview.prepend("<div style='float:left;position:relative;'>"
            + "<button class='btn btn-danger btn-xs' onClick='removeNode(this)' style='position:absolute;left:3px;border:solid 1px;' data-key='"+data.key+"'>"
            + "<i class='fa fa-trash'></i></button>"
            + img
            + "</div>");
    }

    function removeNode(el) {

        var key = $(el).data('key');
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (file.key == key) {
                files.splice(i,1);
            }
        }

        $(el).parent().remove();
    }

    function removeFile(id, el) {
        showLoading()
        axios.delete('/storage/' + id).then((response) => {
            hideLoading()
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                hideLoading()
            }
        })

        $(el).parent().remove();
    }

    function getMailNumberSuffix()
    {
        showLoading()
        var position_id =  $('select[name=source_position_id]').val();
        axios.get('/position/set/first/id/' + position_id).then((response) => {
            $('input[name=mail_number_suffix]').val(response.data.data.records.mail_number_suffix_code);
            hideLoading()
        })
    }

    function clearCheckerSigner() {
        $('#checker_signer_container').html("");
        r_approval = [];
        position_id = '{{ MyAccount()->position_id }}';
        position_count = 0;
        source_eselon_id = 0
    }

</script>
