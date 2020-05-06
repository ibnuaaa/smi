<script>
var action = '';

$(document).ready(function() {
    $('#Approve').click(function(){

        var data = {
            mail_id: '{{ $mail_id }}'
        };

        showLoading()
        axios.post('/mail/approve', data).then((response) => {
            console.log(response);
            location.reload();
            hideLoading()
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                hideLoading()
            }
        })
    });

    $('#RequestNomor').click(function(){

        var data = {
            mail_id: '{{ $mail_id }}'
        };

        showLoading()
        axios.post('/mail/request_mail_number', data).then((response) => {
            console.log(response);
            location.reload();
            hideLoading()
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                hideLoading()
            }
        })
    });


    $('#CancelRequestNomor').click(function(){

        var data = {
            mail_id: '{{ $mail_id }}'
        };

        showLoading()
        axios.post('/mail/cancel_request_mail_number', data).then((response) => {
            console.log(response);
            location.reload();
            hideLoading()
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                hideLoading()
            }
        })
    });





    $('#Passphrase').click(function(){
        action = 'approve';
        $('#modalPassPhrase').modal('show');
    });

    $('#BtnMailNumber').click(function(){
        action = 'approve';
        $('#modalMailNumber').modal('show');
    });

    $('#ReApprove').click(function(){
        action = 'resubmitesign';
        $('#modalPassPhrase').modal('show');
    });

    $('#ApproveUsingPassphrase').click(function() {

        const passphraseForm = $('#passphraseForm').formValidation({
            fields: {
                passphrase: {
                    validators: {
                        notEmpty: {
                            message: 'The Passphrase is required'
                        }
                    }
                },
                nik: {
                    validators: {
                        notEmpty: {
                            message: 'NIK is required'
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


        passphraseForm.validate().then(function(status) {
            if (status === 'Valid') {
                var passphrase = $('input[name=passphrase]').val()
                var nik = $('input[name=nik]').val()
                var data = {
                    mail_id: '{{ $mail_id }}',
                    passphrase: passphrase,
                    nik: nik,
                    action: action
                };

                showLoading()
                axios.post('/mail/approve', data).then((response) => {
                    console.log(response);
                    location.reload();
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

    $('#Reject').click(function(){

        var reject_reason = $('textarea[name=reject_reason]');

        var data = {
            mail_id: '{{ $mail_id }}',
            reject_reason: reject_reason.val()
        };


        if(reject_reason.parent().children('#error_message_container')) reject_reason.parent().children('#error_message_container').remove();

        if (!reject_reason.val()) {
            reject_reason.parent().append('<div id="error_message_container" style="color:#f00;">Reject Reason tidak boleh kosong</div>');
        } else  {
            showLoading();
            axios.post('/mail/reject', data).then((response) => {
                location.reload();
                hideLoading();
            }).catch((error) => {
                hideLoading();
                if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.
                    exception) && Boolean(error.response.data.exception.message)) {
                    Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' });
                }
            });
        }
    });

    $('#Disposisi').click(function(){
        alert("Disposisi Masih belum berfungsi");
    });

    $('#Kirim').click(function(){
        var data = {
            mail_id: '{{ $mail_id }}'
        };

        showLoading()
        axios.post('/mail/maker_send', data).then((response) => {
            hideLoading()
            console.log(response);
            location.reload();
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                showLoading()
            }
        })
    });

    $('#KirimUploadSuratMasuk').click(function(){
        var data = {
            mail_id: '{{ $mail_id }}',
            is_upload_surat_masuk: 'y'
        };

        showLoading()
        axios.post('/mail/maker_send', data).then((response) => {
            hideLoading()
            console.log(response);
            location.reload();
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                showLoading()
            }
        })
    });


    $('#SaveMailNumber').click(function(){
        var data = {
            mail_id: '{{ $mail_id }}',
            mail_number_infix: $('input[name=mail_number_from_tu]').val()
        };

        showLoading()
        axios.post('/mail/mail_number', data).then((response) => {
            hideLoading()
            console.log(response);
            location.reload();
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                showLoading()
            }
        })
    });
})

function back_page() {
    window.history.back();
}

function showLampiran() {
    $('#modalLampiran').modal('show');
    return false;
}

</script>
