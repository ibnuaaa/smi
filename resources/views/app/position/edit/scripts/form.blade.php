<script>
$(document).ready(function() {
    const form = document.getElementById('editUserForm')
    const editUserForm = $('#editUserForm').formValidation({
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Nama Jabatan harus diisi'
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


    $('select[name=parent_id]').select2({
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

    $('#saveAction').click(function() {
        editUserForm.validate().then(function(status) {
            if (status === 'Valid') {
                const name = $('input[name="name"]')
                const signing_template = $('input[name="signing_template"]')
                const shortname = $('input[name="shortname"]')
                const mail_number_suffix_code = $('input[name="mail_number_suffix_code"]')
                const parent_id = $('select[name="parent_id"]')
                const permission = $('input[name="permission"]:checked')

                const checkedPermission = []
                for (var i = 0; i < permission.length; i++) {
                  checkedPermission.push(parseInt($(permission[i]).val()))
                }

                const data = {
                    name: name.val(),
                    signing_template: signing_template.val(),
                    shortname: shortname.val(),
                    mail_number_suffix_code: mail_number_suffix_code.val(),
                    parent_id: parent_id.val(),
                    permissions: checkedPermission
                }

                // console.log(data);

                showLoading()
                axios.put('/position/{{$data->id}}', data).then((response) => {
                    hideLoading()
                    window.location = '/position/paging'
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

function changeStatusPosition(status) {

    axios.post('/position/change_status', {
        position_id: "{{$data['id']}}",
        status: status
    }).then((response) => {
        // console.log(response)
        // location.reload()
        location.href = "{{ url('/position/paging') }}"
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })
}
</script>
