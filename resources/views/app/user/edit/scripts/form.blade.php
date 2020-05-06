<script>
$(document).ready(function() {

    $('select[name=position_id]').select2({
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

    const form = document.getElementById('editUserForm')
    const editUserForm = $('#editUserForm').formValidation({
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: 'The username is required'
                    },
                    stringLength: {
                        min: 3,
                        max: 191,
                        message: 'The username must be more than 3 and less than 131 characters long',
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The username can only consist of alphabetical, number and underscore',
                    }
                }
            },
            password: {
                validators: {
                    stringLength: {
                        min: 6,
                        message: 'The password must have at least 6 characters',
                    }
                }
            },
            confirmPassword: {
                validators: {
                    identical: {
                        compare: function() {
                            return form.querySelector('input[name="password"]').value
                        },
                        message: 'The password and its confirm are not the same'
                    }
                }
            },
            position: {
                validators: {
                    notEmpty: {
                        message: 'The position name is required'
                    }
                }
            },
            gender: {
                validators: {
                    notEmpty: {
                        message: 'The gender name is required'
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

    form.querySelector('input[name="password"]').addEventListener('input', function() {
        editUserForm.revalidateField('confirmPassword')
    })

    $('#saveAction').click(function() {
        editUserForm.validate().then(function(status) {
            if (status === 'Valid') {
                const name = $('input[name="name"]')
                const username = $('input[name="username"]')
                const nik = $('input[name="nik"]')
                const password = $('input[name="password"]')
                const position_id = $('select[name="position_id"]')
                const gender = $('select[name="gender"]')
                const status = $('select[name="status"]')
                const satker = $('input[name="satker"]')
                const golongan = $('input[name="golongan"]')
                const jenis_user = $('.jenis_user_radio input[name="jenis_user"]:checked')

                const data = {
                    name: name.val(),
                    username: username.val(),
                    nik: nik.val(),
                    position_id: position_id.val(),
                    gender: gender.val(),
                    status: status.val(),
                    satker: satker.val(),
                    golongan: golongan.val(),
                    jenis_user: jenis_user.val()
                }
                if (password.val()) {
                    data.password = password.val()
                }
                axios.put('/user/{{$data['id']}}', data).then((response) => {
                    // const { data } = response.data;
                    // cosole.log(response);
                    window.location = '{{ url('/user') }}';
                    // location.reload();
                }).catch((error) => {
                    if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                        Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                    }
                })
            }
        })
    })

})
</script>
