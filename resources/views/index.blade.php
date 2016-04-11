@extends('layouts.app')

@section('content')

@if($welcomeTitle or $welcomeMessage)
<div class="row row-blog-welcome">
  <div class="col-md-12" align="center">
    <h1>{{ $welcomeTitle }}</h1>
    <p>{{ $welcomeMessage }}</p>
  </div>
</div>
@endif
<div class="row">
  <div class="col-md-9 posts-column">
    <!-- Posts -->
    @if(!count($posts))
      <h2>No posts found.</h2>
      @if(!Auth::guest())
        <h4><a href="{{ action('Admin\PostsController@create') }}">Click here</a> to write your first post!</h4>
      @endif
    @else
      @foreach($posts as $post)
        <article id="post-{{ $post->id }}">
          <header class="entry-header">
            <h2 class="entry-title"><a href="#" title="{{ $post->title }}">{{ $post->title }}</a></h2>
            <div class="entry-meta">
              <span class="posted-on">Published on
                <span class="entry-date text-danger">{{ date('F d, Y', strtotime($post->updated_at)) }}</span>
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
            {!! $post->text !!}
          </div>
        </article>
      @endforeach
    @endif
  </div>
  <div class="col-md-3 sidebar-column">
    <!-- Categories -->
    <div class="category-list">
      <h3>Categories</h3>
      <ul>
        <li>Uncategorized</li>
        @if(count($categories))
          @foreach($categories as $category)
            <li><a href="#">{{ $category->name }}</a></li>
          @endforeach
        @endif
      </ul>
    </div>
    <!-- Tags -->
    <div class="tag-cloud">
      <h3>Tags</h3>
      <ul>
        @if(!count($tags))
        <li>No tags available.</li>
        @else
          @foreach($tags as $tag)
            <li><a href="#" class="tag-rank-{{ rand(1,10) }}">{{ $tag->name }}</a></li>
          @endforeach
        @endif
      </ul>
    </div>
  </div>
</div>

@endsection
