<script>

$(document).ready(function() {

    addFollowUp()
    addFollowUp()

    const form = document.getElementById('NewDispositionForm')
    const saveDispositionForm = $('#NewDispositionForm').formValidation({
        fields: {
            // catatan: {
            //     validators: {
            //         notEmpty: {
            //             message: 'Catatan harus diisi'
            //         }
            //     }
            // },
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

    $('#saveAction').click(function(e) {
        saveDispositionForm.validate().then(function(status) {
            if (status === 'Valid') {

                var mail_data = [];
                $("#NewDispositionForm input[name=chk]:checked").each ( function() {
                    var key = $(this).val()
                    mail_data.push({
                        key: key,
                        value: true
                    })
                });


                $("#NewDispositionForm #text").each ( function() {
                    var key = $(this).attr('name');
                    var val = $(this).val();

                    mail_data.push({
                        key: key,
                        value: val
                    })
                });

                var disposition_position_id = [];
                $("#NewDispositionForm input[name=disposition_position_id]:checked").each ( function() {
                    disposition_position_id.push($(this).val());
                });

                $('#mail_to_container .list').each(function(index, row) {
                    disposition_position_id.push($(row).find('.mail_to').children('select').val());
                });

                var diteruskan = [];
                $("#diteruskan input:checked").each ( function() {
                    diteruskan.push($(this).val());
                });

                const notes = $('textarea[name="notes"]').val()

                const data = {
                    disposition_position: JSON.stringify(disposition_position_id),
                    mail_id: '{{ $id }}',
                    notes: notes,
                    mail_detail: JSON.stringify(mail_data)
                }

                showLoading()
                axios.post('/mail/dispose', data).then((response) => {
                    hideLoading()
                    location.href = '/disposisi/detail/' + response.data.data.id;
                }).catch((error) => {
                    if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                        Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                        hideLoading()
                    }
                })
            }
        })
    })

})


function back_page() {
    window.history.back();
}

var follow_up = 1
function addFollowUp () {
    follow_up++;

    var tr = '';
    tr = '<tr>';
    tr += '<td valign="top">';
    tr += '<input type="checkbox" checked onClick="return false;">';
    tr += '</td>';
    tr += '<td>';
    tr += '<input type="text" name="follow_up_tambahan_' + follow_up + '" id="text" class="form-control input-sm">';
    tr += '</td>';
    tr += '<td style="width:20px;">';
    tr += '<button class="btn btn-danger" onClick="removeFollowUp(this)"><i class="fas fa-trash btn-xs"></i></button>';
    tr += '</td>';
    tr += '</tr>';

    $('#tableFollowUp').append(tr);
}


function removeFollowUp(e) {
    $(e).parent().parent().remove();
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

    return false;
}


function remove_node(d) {
    $(d).parent().parent().remove();

    return false;
}


</script>
