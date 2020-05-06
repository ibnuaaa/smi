<script>

function sortBy(column, current_sort_type) {

    // alert('asdasd');

    const filter_search = $('input[name="user-table-filter_search"]').val()
    const query = {}
    if (filter_search) {
        query.filter_search = filter_search
    }


    query.sort = column


    if(current_sort_type == '') query.sort_type = 'asc'
    else if(current_sort_type == 'asc') query.sort_type = 'desc'
    else if(current_sort_type == 'desc') query.sort_type = ''

    if (column != '{{ !empty($_GET['sort']) ? $_GET['sort'] : '' }}') query.sort_type = 'asc'

    const href = '{{ url('/surat_keluar') }}'
    const queryString = Qs.stringify(query)
    if (queryString) {
        window.location = href + '?' + queryString
    } else {
        window.location = href
    }
}


</script>
