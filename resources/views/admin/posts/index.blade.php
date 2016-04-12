@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-3">
        <h2>Posts</h2>
      </div>
      <div class="col-md-6">
        <!-- <div class="input-group h2">
          <input name="data[search]" class="form-control" id="search" type="text" placeholder="Search items">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit">
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div> -->
      </div>
      <div class="col-md-3">
        <a href="{{ action('Admin\PostsController@create') }}" class="btn btn-primary pull-right h2">Add new Post</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped table-bordered no-margin">
          <thead>
            <tr>
              <th width="350">Title</th>
              <th>Author</th>
              <th>Categories</th>
              <th>Tags</th>
              <th>Comments</th>
              <th width="160">Date</th>
              <th width="100">Actions</th>
            </tr>
          </thead>
          <tbody>
          @if(!$posts->count())
            <tr>
              <td colspan="100" align="center">No records to display.</td>
            </tr>
          @else
            @foreach($posts as $key => $post)
              <tr>
                <td><a href="{{ action('Admin\PostsController@edit', ['id' => $post->_id]) }}">{{ $post->title }}</a></td>
                <td>{{ $post->author->name }}</td>
                <td>
                  @if(!$post->categories->count())
                    Uncategorized
                  @else
                    {{ $post->categories->implode('name', ', ') }}
                  @endif
                </td>
                <td>
                  @if(!$post->tags->count())
                    --
                  @else
                    {{ $post->tags->implode('name', ', ') }}
                  @endif
                </td>
                <td>{{ $post->comments->count() }}</td>
                <td>{{ $post->updated_at }}</td>
                <td>
                  <div class="btn-group btn-group-xs" role="group" aria-label="Action buttons">
                    <a href="{{ action('Admin\PostsController@edit', ['id' => $post->_id]) }}" class="btn btn-warning">Edit</a>
                    <a href="javascript:;" class="btn btn-danger delete-record">Delete</a>
                  </div>
                  {!! @Form::open([
                    'action' => ['Admin\PostsController@destroy', $post->_id],
                    'method' => 'delete'
                  ]) !!}
                  {!! Form::close() !!}
                </td>
              </tr>
            @endforeach
          @endif
          </tbody>
        </table>
        {!! $posts->links() !!}
      </div>
    </div>
  </div>
</div>
@include('admin.common.confirmmodal')
@endsection

@section('bottomScripts')
  <script src="{{ url('js/delete-record-confirm.js') }}"></script>
@endsection
