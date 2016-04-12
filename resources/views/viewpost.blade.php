@extends('layouts.blog')

@section('blogContent')
<div class="col-md-9 posts-column">
  @include('layouts.blogpost', [
    'post' => $post
  ])
</div>
@endsection
