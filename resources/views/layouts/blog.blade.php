@extends('layouts.app')

@section('content')

@yield('blogWelcome')

<div class="row">
  @yield('blogContent')
  
  <div class="col-md-3 sidebar-column">
    <!-- Categories -->
    <div class="category-list">
      <h3>Categories</h3>
      <ul>
        <li>Uncategorized</li>
        @if(count($generalBlogCategories))
          @foreach($generalBlogCategories as $category)
            <li><a href="#">{{ $category->name }}</a></li>
          @endforeach
        @endif
      </ul>
    </div>
    <!-- Tags -->
    <div class="tag-cloud">
      <h3>Tags</h3>
      <ul>
        @if(!count($generalBlogTags))
        <li>No tags available.</li>
        @else
          @foreach($generalBlogTags as $tag)
            <li><a href="#" class="tag-rank-{{ rand(1,10) }}">{{ $tag->name }}</a></li>
          @endforeach
        @endif
      </ul>
    </div>
  </div>
</div>

@endsection
