{{ $formTag }}
  <div class="row">
    <div class="col-md-8">
      <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <input type="text" class="form-control" name="title" id="title"
          value="{{ old('title', $post->title ?? "") }}">
          @if ($errors->has('title'))
            <span class="help-block">
              <strong>{{ $errors->first('title') }}</strong>
            </span>
          @endif
      </div>
      <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
        <textarea class="form-control" rows="15" name="text" id="text">{!! old('text', $post->text ?? "") !!}</textarea>
        @if ($errors->has('text'))
          <span class="help-block">
            <strong>{{ $errors->first('text') }}</strong>
          </span>
        @endif
      </div>
    </div>
    <div class="col-md-4">
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-primary">
            <div class="panel-heading">Publish</div>
            <div class="panel-body no-padding">
              <table class="table table-striped no-margin">
                <tr>
                  <td><strong>Status</strong></td>
                  <td>
                    @if(isset($post))
                      {!! $post->draft ? '<i class="fa fa-eye-slash"></i> Draft' : '<i class="fa fa-check-square-o"></i> Published' !!}
                    @else
                      <i class="fa fa-ban"></i> Unpublished
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><strong>Created</strong></td>
                  <td>{{ $post->created_at ?? "-" }}</td>
                </tr>
                <tr>
                  <td><strong>Last Modified</strong></td>
                  <td>{{ $post->updated_at ?? "-" }}</td>
                </tr>
                <tr class="{{ $errors->has('published_at') ? ' has-error' : '' }}">
                  <td><strong>Published</strong></td>
                  <td>
                    <input type="datetime-local" class="form-control"
                      name="published_at"
                      value="{{ old('published_at',
                                    $post->published_at ? date('Y-m-d\TH:i', strtotime($post->published_at))
                                    : "") }}" />
                      @if ($errors->has('published_at'))
                        <span class="help-block">
                          <strong>{{ $errors->first('published_at') }}</strong>
                        </span>
                      @endif
                  </td>
                </tr>
              </table>
            </div>
            <div class="panel-footer">
              <button class="btn btn-default" type="submit" name="btn_draft" value="1">
                Save as draft</button>
              <button class="btn btn-primary pull-right" type="submit" name="btn_publish" value="1">
                {{ (!isset($post) || $post->draft) ? "Publish" : "Update" }}
              </button>
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
                @foreach($categories as $category)
                <li><div class="checkbox">
                    <label>
                      <input type="checkbox" {{ isset($post->category_ids) && in_array($category->_id, $post->category_ids) ? 'checked="checked"' : "" }}
                       name="categories[]" value="{{ $category->_id }}">
                      {{ $category->name }}
                    </label>
                  </div></li>
                @endforeach
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
                @foreach($tags as $tag)
                <li><div class="checkbox">
                    <label>
                      <input type="checkbox" {{ isset($post->tag_ids) && in_array($tag->_id, $post->tag_ids) ? 'checked="checked"' : "" }}
                      name="tags[]" value="{{ $tag->_id }}">
                      {{ $tag->name }}
                    </label>
                  </div></li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</form>

@section('bottomScripts')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="{{ url('js/tinymce-config.js') }}"></script>
@endsection
