<script>
$(document).ready(function() {
    const form = document.getElementById('changePasswordForm')
    const changePasswordForm = $('#changePasswordForm').formValidation({
        fields: {
            password: {
                validators: {
                    notEmpty: {
                        message: 'Password harus diisi'
                    }
                }
            },
            new_password: {
                validators: {
                    notEmpty: {
                        message: 'Password Baru Harus Diisi'
                    }
                }
            },
            new_password_confirmation: {
                validators: {
                    notEmpty: {
                        message: 'Konfirmasi Password Harus Diisi'
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

    $('#saveAction').click(function() {
        changePasswordForm.validate().then(function(status) {
            if (status === 'Valid') {
                const password = $('input[name="password"]')
                const new_password = $('input[name="new_password"]')
                const new_password_confirmation = $('input[name="new_password_confirmation"]')

                const data = {
                    password: password.val(),
                    new_password: new_password.val(),
                    new_password_confirmation: new_password_confirmation.val()
                }

                axios.put('/user/change_password', data).then((response) => {
                    // const { data } = response.data
                    window.location = '{{ url('/profile') }}'
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
