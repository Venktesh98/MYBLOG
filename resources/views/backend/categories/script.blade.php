@section('script')
    <script type = text/javascript>
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
    </script>
@endsection