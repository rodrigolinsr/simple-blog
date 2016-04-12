tinymce.init({
  selector:'textarea',
  plugins : ["advlist hr autolink textcolor lists link image charmap print preview anchor", "searchreplace visualblocks code", "insertdatetime media table contextmenu paste"],
  toolbar : [ "bold italic strikethrough bullist numlist blockquote hr alignleft aligncenter alignright alignjustify link unlink image",
              "styleselect fontsizeselect underline forecolor pastetext removeformat charmap outdent indent undo redo code",
            ]
});
