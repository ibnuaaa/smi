<script>
$(document).ready(function() {
    // captchaImage('i-captcha')
    $('#btnRefreshCaptcha').on('click', function(e) {
        // captchaImage('i-captcha')
        return false
    })

    function captchaImage(id) {
        const captcha = $('#'+id)
        axiosCaptcha.get('/captchaInfo').then((response) => {
            global_captchaObj.captchaUrl = response.data.captchaUrl
            global_captchaObj.captchaUuid = response.data.captchaUuid
            captcha.html(`<img src="${global_captchaObj.captchaUrl}" captchaId="${global_captchaObj.captchaUuid}"></img>`)
        }).catch(() => {
        })
    }

    const loginForm = $('#loginForm').formValidation({
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: 'The username is required'
                    },
                    stringLength: {
                        min: 4,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long',
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The username can only consist of alphabetical, number and underscore',
                    },
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required'
                    },
                    stringLength: {
                        min: 5,
                        message: 'The password must have at least 8 characters',
                    },
                }
            },
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

    loginForm.on('core.form.valid', function() {
        const username = $('input[name="username"]')
        const password = $('input[name="password"]')
        showLoading();
        axios.post('/login', {
            username: username.val(),
            password: password.val()
        }).then((response) => {
            hideLoading();
            const { oauth } = response.data.data
            document.cookie = `TokenType=${oauth.token_type}`
            document.cookie = `AccessToken=${oauth.access_token}`
            window.location = `${window.appUrl}/`
        }).catch(() => {
            hideLoading();
        })
    })
})
</script>
