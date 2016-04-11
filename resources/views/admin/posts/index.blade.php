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
        <table class="table table-striped table-bordered">
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
          @foreach($posts as $key => $post)
            <tr>
              <td>{{ $post->title }}</td>
              <td>{{ $post->author->name }}</td>
              <td>
                @if(!$post->categories->count())
                  Uncategorized
                @else
                  @foreach($post->categories as $category)
                    {{ $category->name }},
                  @endforeach
                @endif
              </td>
              <td>
                @if(!$post->tags->count())
                  --
                @else
                  @foreach($post->tags as $tag)
                    {{ $tag->name }},
                  @endforeach
                @endif
              </td>
              <td>{{ $post->comments->count() }}</td>
              <td>{{ $post->updated_at }}</td>
              <td>
                <div class="btn-group btn-group-xs" role="group" aria-label="Action buttons">
                  <a href="#" type="button" class="btn btn-warning">Edit</a>
                  <a href="#" type="button" class="btn btn-danger">Delete</a>
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>

        <!-- <div class="row">
          <div class="col-md-12">
            <ul class="pagination">
              <li class="disabled"><a>&lt; Previous</a></li>
              <li class="disabled"><a>1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li class="next"><a href="#" rel="next">Next &gt;</a></li>
            </ul>
          </div>
        </div> -->
      </div>
    </div>
  </div>
</div>
@endsection
