@section('script')
    <script type = text/javascript>
        $('ul.pagination').addClass('no-margin pagination-sm');

      // Javascript code for adding the slug automatically based on the Title
        $('#title').on('blur', function() {
            var theTitle = this.value.toLowerCase().trim(),
                slugInput = $('#slug'),
                theSlug = theTitle.replace(/&/g, '-and-')           // if contains & replace the slug with and
                                  .replace(/[^a-z0-9-]+/g, '-')    // if contains alphanumeric characters replace slug with -
                                  .replace(/\-\-+/g, '-')         // eliminate double -- with single -
                                  .replace(/^-+|-+$/g, '');       // if contains left and right side +,- replace with null in slug

            slugInput.val(theSlug);
        });

        var simplemde1 = new SimpleMDE({ element: $("#excerpt")[0] });  // invokes the simplemde excerpt css file
        var simplemde2 = new SimpleMDE({ element: $("#body")[0] });     // invokes the simplemde body css file

        $('#datetimepicker1').datetimepicker({
            format:'YYYY-MM-DD HH:mm:ss',
            showClear:true
        });

        // Event Handler for the Save Draft.
        $('#draft-btn').click(function(e){
            e.preventDefault();
            $('#published_at').val(""); 
            $('#post-form').submit();    // invokes the Form here
        });
    </script>
@endsection