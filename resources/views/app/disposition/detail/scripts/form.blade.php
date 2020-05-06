<script>

$(document).ready(function() {
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

                var disposition_position_id = [];
                $("#disposition_position input[name=disposition_position_id]:checked").each ( function() {
                    disposition_position_id.push($(this).val());
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
                }

                showLoading()
                axios.post('/mail/dispose', data).then((response) => {
                    // const { data } = response.data
                    hideLoading()
                    location.reload();

                    // if (action == 'kirim') window.location = '{{ (url('/surat_keluar')) }}';
                    // else window.location = '{{ (url('/surat/preview/')) }}/' + data.id + '/surat_keluar';

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

</script>
