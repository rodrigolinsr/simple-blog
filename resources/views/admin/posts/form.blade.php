<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
tinymce.init({
  selector:'textarea',
  plugins : ["advlist hr autolink textcolor lists link image charmap print preview anchor", "searchreplace visualblocks code", "insertdatetime media table contextmenu paste"],
  toolbar : [ "bold italic strikethrough bullist numlist blockquote hr alignleft aligncenter alignright alignjustify link unlink image",
              "styleselect fontsizeselect underline forecolor pastetext removeformat charmap outdent indent undo redo code",
            ]
});
</script>
<form role="form" method="{{ $formMethod }}" action="{{ $formAction }}">
  {!! csrf_field() !!}

  <div class="row">
    <div class="col-md-9">
      <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <input type="text" class="form-control" name="title" id="title"
          value="{{ old('title') }}">
          @if ($errors->has('title'))
            <span class="help-block">
              <strong>{{ $errors->first('title') }}</strong>
            </span>
          @endif
      </div>
      <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
        <textarea class="form-control" rows="15" name="text" id="text">{!! old('text') !!}</textarea>
        @if ($errors->has('text'))
          <span class="help-block">
            <strong>{{ $errors->first('text') }}</strong>
          </span>
        @endif
      </div>
    </div>
    <div class="col-md-3">
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-primary">
            <div class="panel-heading">Publish</div>
            <div class="panel-body no-padding">
              <table class="table table-striped no-margin">
                <tr>
                  <td><strong>Status</strong></td>
                  <td>Draft</td>
                </tr>
                <tr>
                  <td><strong>Published</strong></td>
                  <td>{{date('Y-m-d H:i:s')}}</td>
                </tr>
                <tr>
                  <td><strong>Last Modified</strong></td>
                  <td>{{date('Y-m-d H:i:s')}}</td>
                </tr>
              </table>
            </div>
            <div class="panel-footer">
              <button class="btn btn-default">Save as draft</button>
              <button class="btn btn-primary pull-right">Publish</button>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default panel-categories">
            <div class="panel-heading">Categories</div>
            <div class="panel-body no-padding">
              <ul>
                @for($i = 1; $i <= 7; $i++)
                <li><div class="checkbox">
                    <label>
                      <input type="checkbox" name="categories[]" value="{{ $i }}">
                      Category {{ $i }}
                    </label>
                  </div></li>
                @endfor
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default panel-categories">
            <div class="panel-heading">Tags</div>
            <div class="panel-body no-padding">
              <ul>
                @for($i = 1; $i <= 7; $i++)
                <li><div class="checkbox">
                    <label>
                      <input type="checkbox" name="tags[]" value="{{ $i }}">
                      Tag {{ $i }}
                    </label>
                  </div></li>
                @endfor
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</form>
