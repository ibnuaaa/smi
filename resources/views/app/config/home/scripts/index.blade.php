<script>

$('#modalDelete').on('show.bs.modal', function(e) {
    const { recordId, recordName } = $(e.relatedTarget).data()
    $('#deleteAction').click(function() {
        axios.delete('/config/'+recordId).then((response) => {
            const { data } = response.data
            $('#modalDelete').modal('hide')
            window.location.reload()
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            }
        })
    })
})

// filter
$('#filterAction').click(function() {
    const filter_search = $('input[name="filter_search"]').val()
    const query = {}
    if (filter_search) {
        query.filter_search = filter_search
    }
    const href = '{{ url('/user') }}'
    const queryString = Qs.stringify(query)
    if (queryString) {
        window.location = href + '?' + queryString
    } else {
        window.location = href
    }
    console.log(queryString);
})

function sortBy(column, current_sort_type) {
    const filter_search = $('input[name="filter_search"]').val()
    const query = {}
    if (filter_search) {
        query.filter_search = filter_search
    }

    query.sort = column


    if(current_sort_type == '') query.sort_type = 'asc'
    else if(current_sort_type == 'asc') query.sort_type = 'desc'
    else if(current_sort_type == 'desc') query.sort_type = ''

    if (column != '{{ !empty($_GET['sort']) ? $_GET['sort'] : '' }}') query.sort_type = 'asc'

    const href = '{{ url('/user') }}'
    const queryString = Qs.stringify(query)
    if (queryString) {
        window.location = href + '?' + queryString
    } else {
        window.location = href
    }
}

function clearTransaction() {
    showLoading()
    axios.get('/clear_mail_transaction').then((response) => {
        hideLoading()
    }).catch((error) => {
        console.log(error)
    })

    return false;
}

</script>
