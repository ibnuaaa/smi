<script>

var total_mail_to = 0;
var action = '';
var total_saved_image = 0;

$(document).ready(function() {

    $('body #myDatepicker').datepicker();

    const saveMailForm = $('#saveMailForm').formValidation({
        fields: {
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


    $('#actions .saveAction').click(function(e) {

        action =  e.target.id;

        saveMailForm.validate().then(function(status) {
            if (status === 'Valid') {

                const source_external = $('input[name="source_external"]')
                const mail_number_int = $('input[name="mail_number_int"]')
                const mail_number_ext = $('input[name="mail_number_ext"]')
                const about = $('input[name="about"]')
                const mail_date = $('input[name="mail_date"]')
                const receive_date = $('input[name="receive_date"]')
                const notes = $('textarea[name="notes"]')
                const privacy_type = $('select[name="privacy_type"]')

                const data = {
                    mail_number_int: mail_number_int.val(),
                    mail_number_ext: mail_number_ext.val(),
                    mail_date: mail_date.val(),
                    receive_date: receive_date.val(),
                    about: about.val(),
                    notes: notes.val(),
                    privacy_type: privacy_type.val(),
                    source_external: source_external.val(),
                    mail_to: JSON.stringify(r_mail_to),
                    action: action
                }

                showLoading()
                axios.post('/mail/upload_surat_masuk', data).then((response) => {
                    const { data } = response.data

                    for (var i = 0; i < files.length; i++) {
                        const data_storage = {
                            object: 'lampiran',
                            object_id: data.id,
                            file: JSON.stringify(files[i])
                        };

                        axios.post('/storage/save', data_storage).then((response) => {
                            console.log(response)
                            total_saved_image++;

                            console.log('-------------------')
                            console.log(total_saved_image)
                            console.log('-')
                            console.log(files.length)

                            if (total_saved_image >= files.length) {
                                window.location = '{{ (url('/surat/mail_import_detail/')) }}/' + data.id;
                            }

                        }).catch((error) => {
                            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                                hideLoading()
                            }
                        })
                    }

                    if (files.length < 1) {
                        window.location = '{{ (url('/surat/mail_import_detail/')) }}/' + data.id;
                    }


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


    $('#actions .saveUpdateAction').click(function(e) {

        action =  e.target.id;

        getMailToArray();

        saveMailForm.validate().then(function(status) {
            if (status === 'Valid') {

                const source_external = $('input[name="source_external"]')
                const mail_number_int = $('input[name="mail_number_int"]')
                const mail_number_ext = $('input[name="mail_number_ext"]')
                const about = $('input[name="about"]')
                const mail_date = $('input[name="mail_date"]')
                const receive_date = $('input[name="receive_date"]')
                const notes = $('textarea[name="notes"]')
                const privacy_type = $('select[name="privacy_type"]')

                const data = {
                    mail_number_int: mail_number_int.val(),
                    mail_number_ext: mail_number_ext.val(),
                    mail_date: mail_date.val(),
                    receive_date: receive_date.val(),
                    about: about.val(),
                    notes: notes.val(),
                    privacy_type: privacy_type.val(),
                    source_external: source_external.val(),
                    mail_to: JSON.stringify(r_mail_to),
                    action: action
                }

                showLoading()
                axios.put('/mail/{{$id}}', data).then((response) => {
                    const { data } = response.data

                    window.location = '{{ (url('/surat/mail_import_detail/' . $id)) }}';
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


    @if ($id)
        getEditData();
    @else
        addMailTo();
    @endif

})

function prepareUpload(el, element_id) {
  var files = $(el)[0].files;
  var preview = $('#' + element_id);
  for (i = 0; i < files.length; i++) {
    uploadFile(files[i], preview);
  }
}

function addMailTo() {
    var mail_to_component = $('<select class="full-width" data-id="" name="mail_to"></select>');
    var remove_component = $('<button class="btn btn-danger" onClick="return remove_node(this)"><i class="fas fa-trash"></i></button>');

    var col_2 = $('<div class="form-group col-md-10 mail_to"></div>');
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

    $(mail_to_component).change(function() {
        getMailToArray();
    });

    getMailToArray();

    total_mail_to++;

    return false;
}


var files = [];
function uploadFile(file, preview) {
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
            console.log(response.data);

            @if (!$id)
                files.push(response.data);

            @else
                const data_storage = {
                    object: 'lampiran',
                    object_id: '{{$id}}',
                    file: JSON.stringify(response.data)
                };

                axios.post('/storage/save', data_storage).then((response) => {
                    // hideLoading()
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

    console.log(files);
}

function appendImage(preview, data) {

    img = "";
    if(data.extension.toLowerCase() == 'jpg' || data.extension.toLowerCase() == 'png' || data.extension.toLowerCase() == 'bmp')
    img = "<img src='"+window.apiUrl+"/tmp/"+data.key+"."+data.extension+"' style='height:80px;'/>";
    else
    img = "<i class='fas fa-file' style='height:80px;font-size:80px;'></i>";

    preview.prepend("<div style='float:left;margin-right:20px;position:relative;margin:10px;'>"
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

    console.log(files)

    $(el).parent().remove();
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

function remove_node(d) {
    $(d).parent().parent().remove();

    $('#checker_signer_container').each(function(index, row) {
        $(row).find('.tipe_user').children('select').val('checker').trigger('change');
    });

    $('#checker_signer_container').children('div').last().find('.tipe_user').children('select').val('signer').trigger('change');

    getMailToArray();

    return false;
}

function removeFile(id, el) {
    showLoading()
    axios.delete('/storage/' + id).then((response) => {
        hideLoading()
        $(el).parent().parent().remove();
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}


function getEditData() {
    var id = '{{ $id }}';

    axios.get('/mail/id/' + id + '/set/first').then((response) => {

        var data = response.data.data.records;

        const source_external = $('input[name="source_external"]')
        const mail_date = $('input[name="mail_date"]')
        const receive_date = $('input[name="receive_date"]')
        const mail_number = $('input[name="mail_number"]')
        const mail_number_ext = $('input[name="mail_number_ext"]')
        const mail_number_int = $('input[name="mail_number_int"]')
        const notes = $('textarea[name="notes"]')

        const privacy_type = $('select[name="privacy_type"]')
        const about = $('input[name="about"]')

        source_external.val(data.source_external);
        mail_date.val(data.mail_date_date);
        receive_date.val(data.receive_date_date);
        mail_number.val(data.mail_number);
        mail_number_ext.val(data.mail_number_ext);
        mail_number_int.val(data.mail_number_int);
        notes.val(data.notes);
        privacy_type.val(data.privacy_type).trigger('change');
        about.val(data.about);


        for (var i = 0; i < data.mail_destination.length; i++) {
            var mail_destination = data.mail_destination[i];
            setEditMailTo(mail_destination);
        }

    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
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

</script>
