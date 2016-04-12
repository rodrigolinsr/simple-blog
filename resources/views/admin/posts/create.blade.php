@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-4">
    <h2>Add new Post</h2>
  </div>
  <div class="col-md-8">
    <a href="{{ action('Admin\PostsController@index') }}" class="btn btn-default pull-right h2">
      <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back to Posts
    </a>
  </div>
</div>


@include('admin.posts.form', [
  'formTag' => Form::open([
    'action' => 'Admin\PostsController@store'
  ])
])

@endsection
