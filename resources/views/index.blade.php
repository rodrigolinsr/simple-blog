@extends('layouts.blog')

@section('blogWelcome')
@if($welcomeTitle or $welcomeMessage)
<div class="row row-blog-welcome">
  <div class="col-md-12" align="center">
    <h1>{{ $welcomeTitle }}</h1>
    <p>{{ $welcomeMessage }}</p>
  </div>
</div>
@endif
@endsection

@section('blogContent')
<div class="col-md-9 posts-column">
  <!-- Posts -->
  @if(!count($posts))
    <h2>No posts found.</h2>
    @if(!Auth::guest())
      <h4><a href="{{ action('Admin\PostsController@create') }}">Click here</a> to write your first post!</h4>
    @endif
  @else
    @foreach($posts as $post)
      @include('layouts.blogpost', [
        'post' => $post
      ])
    @endforeach
    {!! $posts->links() !!}
  @endif
</div>
@endsection
