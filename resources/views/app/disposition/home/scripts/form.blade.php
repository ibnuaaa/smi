<script>

function remove(d) {
    var id = d.dataset.id
    showLoading()
    if (confirm("Apakah Anda yakin menghapus data ?")) {
        axios.delete('/position/' + id).then((response) => {
            window.location = '/position'
            hideLoading()
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                hideLoading()
            }
        })
    }
}


$(document).ready(function(){
    $('#basic').simpleTreeTable({
        expander: $('#expander'),
        collapser: $('#collapser'),
        store: 'session',
        storeKey: 'simple-tree-table-basic'
    });
});



</script>
