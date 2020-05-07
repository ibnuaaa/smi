<script>
function resetPassword() {
    $('#new_pass').html("");

    axios.post('/user/reset_password', {
        user_id: "{{$data['id']}}"
    }).then((response) => {
        const { data } = response.data;
        $('#new_pass').html(data.new_pass);

        $('#text_new_pass').show();
        $('#new_pass').show();

    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })
}

function inactiveUser(status) {

    axios.post('/user/change_status', {
        user_id: "{{$data['id']}}",
        status: status
    }).then((response) => {
        // console.log(response)
        location.reload()
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })
}

</script>
