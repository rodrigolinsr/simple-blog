@extends('layouts.app')

@section('content')
@include('admin.posts.createeditheader', ['title' => 'Add new Post'])


@include('admin.posts.form', [
  'formTag' => Form::open([
    'action' => 'Admin\PostsController@store'
  ])
])

@endsection
