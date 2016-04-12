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
      <div class="back-all-posts">
        <a href="{{ action('IndexController@index') }}">
          << Back to all posts</a>
      </div>
    @endif
  </div>
</article>
