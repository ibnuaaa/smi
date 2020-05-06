<script>
$(document).ready(function() {
    const form = document.getElementById('editUserForm')
    const editUserForm = $('#editUserForm').formValidation({
        fields: {
            satker: {
                validators: {
                    notEmpty: {
                        message: 'Nama satker harus diisi'
                    }
                }
            },
            satker: {
                validators: {
                    notEmpty: {
                        message: 'Satker Harus Diisi'
                    }
                }
            },
            golongan: {
                validators: {
                    notEmpty: {
                        message: 'Golongan Harus Diisi'
                    }
                }
            },
            name: {
                validators: {
                    notEmpty: {
                        message: 'Nama Pejabat Harus Diisi'
                    }
                }
            },
            jabatan: {
                validators: {
                    notEmpty: {
                        message: 'Jabatan Harus Diisi'
                    }
                }
            },
            username: {
                validators: {
                    notEmpty: {
                        message: 'NIP Harus Diisi'
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
        editUserForm.validate().then(function(status) {
            if (status === 'Valid') {
                const satker = $('input[name="satker"]')
                const golongan = $('input[name="golongan"]')
                const jenis_user = $('.jenis_user_radio input[name="jenis_user"]:checked')
                const name = $('input[name="name"]')
                const username = $('input[name="username"]')
                const position_id = $('select[name="position_id"]')

                const data = {
                    satker: satker.val(),
                    golongan: golongan.val(),
                    jenis_user: jenis_user.val(),
                    name: name.val(),
                    position_id: position_id.val(),
                    username: username.val()
                }

                axios.put('/user/{{$data->id}}', data).then((response) => {
                    window.location.reload()
                }).catch((error) => {
                    if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                        Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                    }
                })
            }
        })
    })
})


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


            const data_storage = {
                object: 'profile',
                object_id: '{{$data->id}}',
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



            appendImage(preview, response.data)
        }
    });

}

function appendImage(preview, data) {
    preview.html("<img src='"+window.apiUrl+"/tmp/"+data.key+"."+data.extension+"' style='height:80px;'/>");
}
</script>
