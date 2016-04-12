<article id="post-{{ $post->id }}">
  <header class="entry-header">
    <h2 class="entry-title"><a href="{{ action('IndexController@viewPost', ['id' => $post->_id]) }}" title="{{ $post->title }}">{{ $post->title }}</a></h2>
    <div class="entry-meta">
      <span class="posted-on">Published on
        <span class="entry-date text-danger">{{ date('F d, Y \a\t H:i', strtotime($post->published_at)) }}</span>
      </span>
      <span class="by-line"> by
        <span class="author"><a href="#">{{ $post->author->name }}</a></span>
      </span>
      <br />
      <span class="category-name">Categories:
        <span class="">
          @if(!count($post->categories))
          <a href="#" rel="category">Uncategorized</a>
          @else
            @foreach($post->categories as $category)
              <a href="#" rel="category">{{ $category->name }}</a>,
            @endforeach
          @endif
        </span>
      </span>
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
      <div class="back-all-posts">
        <a href="{{ action('IndexController@index') }}">
          << Back to all posts</a>
      </div>
    @endif
  </div>
</article>
