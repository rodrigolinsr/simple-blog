<article id="post-{{ $post->id }}">
  <header class="entry-header">
    <h2 class="entry-title"><a href="{{ action('IndexController@viewPost', ['id' => $post->_id]) }}" title="{{ $post->title }}">{{ $post->title }}</a></h2>
    <div class="entry-meta">
      <span class="posted-on">Published on
        <span class="entry-date text-danger">{{ date('F d, Y \a\t H:i', strtotime($post->published_at)) }}</span>
      </span>
      <span class="by-line"> by
        <span class="author"><a href="#">{{ $post->user->name }}</a></span>
      </span>
      <span class="category-name"><strong>Categories</strong>:
        <span>
          @if(!count($post->categories))
          <a href="#" rel="category">Uncategorized</a>
          @else
            <?php $categoriesLinks = [] ?>
            @foreach($post->categories as $category)
              <?php $categoriesLinks[] = "<a href='#' rel='category'>$category->name</a>" ?>
            @endforeach
            {!! implode(', ', $categoriesLinks) !!}
          @endif
        </span>
      </span>
      @if(count($post->tags))
      <br />
      <span class="tag-name" style="display: inline-block; float: right;"><strong>Tags</strong>:
        <span>
          <?php $tagsLinks = [] ?>
          @foreach($post->tags as $tag)
            <?php $tagsLinks[] = "<a href='#' rel='tag'>$tag->name</a>" ?>
          @endforeach
          {!! implode(', ', $tagsLinks) !!}
        </span>
      </span>
      @endif
      <br style="break: all;" />
    </div>
  </header>
  <div class="entry-content">
    @if(Request::segment(1) !== "post")
      {!! $post->truncatedText !!}
      @if(strlen($post->truncatedText) < strlen($post->text))
      <div>
        <a href="{{ action('IndexController@viewPost', ['id' => $post->_id]) }}">Read more >></a>
      </div>
      @endif
    @else
      {!! $post->text !!}
    @endif
  </div>
</article>
@if(Request::segment(1) === "post")
  <div id="post-comments" class="panel panel-primary">
    <div class="panel-heading">
      <i class="fa fa-comments fa-btn"></i>
      {{ $post->comments()->where('pending', false)->count() }} Comments
    </div>
    <div class="panel-body">
      <form method="post" action="{{ action('IndexController@postComment', ['id' => $post->_id]) }}">
        {!! csrf_field() !!}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <input type="text" class="form-control" name="name" id="name"
                placeholder="Your name" value="{{ old('name') }}">
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <input type="text" class="form-control" name="email" id="email"
                placeholder="Your e-mail" value="{{ old('email') }}">
              @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
              <textarea class="form-control" rows="4" name="comment" id="comment" placeholder="Join the discussion...">{{ old('comment') }}</textarea>
              @if ($errors->has('comment'))
                <span class="help-block">
                  <strong>{{ $errors->first('comment') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" align="right">
            <button class="btn btn-primary">
              <i class="fa fa-comment fa-btn"></i>
              Send Comment</button>
          </div>
        </div>
      </form>
      @foreach($post->comments()->where('pending', false)->get() as $comment)
      <div class="row">
        <div class="col-md-12">
          <header>
            <span><a href="{{ $comment->email ? "mailto:$comment->email" : "#" }}">{{ $comment->name }}</a></span>
            <span class="post-meta">
              <span class="bullet">•</span>
              <span class="comment-date text-danger">{{ date('F d, Y \a\t H:i', strtotime($comment->created_at)) }}</span>
            </span>
          </header>
          <p>{{ $comment->comment }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <div class="back-all-posts">
    <a href="{{ action('IndexController@index') }}">
      << Back to all posts</a>
  </div>
@endif

@section('bottomScripts')
  @if ($errors->has('name') or $errors->has('email') or $errors->has('comment'))
    <script>
    $(document).ready(function() {
      var top = document.getElementById("post-comments").offsetTop;
      window.scrollTo(0, top);
    });
    </script>
  @endif
@endsection
