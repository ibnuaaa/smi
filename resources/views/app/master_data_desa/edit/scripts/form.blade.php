<script>
$(document).ready(function() {
    const form = document.getElementById('editUserForm')
    const editUserForm = $('#editUserForm').formValidation({
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: 'The Title is required'
                    }
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

    $('#saveAction').click(function() {
        editUserForm.validate().then(function(status) {
            if (status === 'Valid') {
                const title = $('input[name="title"]')
                const content = this.editor.getData()

                const data = {
                    title: title.val(),
                    content: content
                }

                axios.put('/information/{{$data['id']}}', data).then((response) => {
                    window.location = '{{ url('/information') }}';
                }).catch((error) => {
                    if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                        Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                    }
                })
            }
        })
    })

})



function MinHeightPlugin(editor) {
  this.editor = editor;
}

MinHeightPlugin.prototype.init = function() {
  this.editor.ui.view.editable.extendTemplate({
    attributes: {
      style: {
        minHeight: '300px'
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

</script>
