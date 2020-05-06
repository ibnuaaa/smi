<script>

    function openModalReplyAdd() {
        $('#modalReplyMessage').modal('show');
    }

    function openModalReplyAddMail() {
        $('#modalReplyMessageMail').modal('show');
    }

    function MinHeightPlugin(editor) {
      this.editor = editor;
    }

    MinHeightPlugin.prototype.init = function() {
      this.editor.ui.view.editable.extendTemplate({
        attributes: {
          style: {
            minHeight: '100px'
          }
        }
      });
    };

    ClassicEditor.builtinPlugins.push(MinHeightPlugin);
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        } )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( err => {
            console.error( err.stack );
        } );


    function saveReplyDisposition() {
        const messages = this.editor.getData();
        var master_mail_id = '{{ $mail_id }}';
        var disposition_id = '{{ $disposition_id }}';

        axios.post('/mail_disposition_reply', {
            master_mail_id: master_mail_id,
            messages: messages,
            disposition_id: disposition_id
        }).then((response) => {
            Swal.fire({ title: 'Data Tersimpan', text: 'Success', type: 'success', confirmButtonText: 'Ok' }).then((result) => {
                window.location.reload()
            })
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            }
        })

        $('#modalReplyMessage').modal('hide');

    }

</script>
