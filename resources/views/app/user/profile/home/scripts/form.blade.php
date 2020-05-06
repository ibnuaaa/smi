<script>
$(document).ready(function() {
    const form = document.getElementById('editUserForm')
    const editUserForm = $('#editUserForm').formValidation({
        fields: {
            nama_satker: {
                validators: {
                    notEmpty: {
                        message: 'nama Satker Harus Diisi'
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

    		alert('asdasd');

        editUserForm.validate().then(function(status) {
            if (status === 'Valid') {
                const nama_satker = $('input[name="nama_satker"]')

                const data = {
                    nama_satker: nama_satker.val()
                }

                dd(nama_satker.val())
                dd(data)

                dd(status)


                axios.put('/user/{{$data['id']}}', data).then((response) => {
                		dd(response)
                    // const { data } = response.data
                    // window.location = '{{ UrlPrevious(url('/user')) }}'
                }).catch((error) => {
                    // if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                    //     Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                    // }
                })
            }
        })
    })

})
</script>
