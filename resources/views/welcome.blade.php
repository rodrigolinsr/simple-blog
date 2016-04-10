@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-blog-welcome">
      <div class="col-md-12" align="center">
        <h1>Welcome to my simple blog!</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed quam ligula. Etiam porttitor et augue a tristique. Fusce aliquet molestie tempus. Fusce varius, libero et cursus aliquet, velit ipsum semper magna, eget placerat lacus libero ut ligula. Proin aliquet in diam ut fermentum. Praesent iaculis metus sapien, non varius lacus volutpat sed. Donec ultrices.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-9 posts-column">
        <article id="post-19" class="post type-post status-publish format-standard">
          <header class="entry-header">
            <h2 class="entry-title"><a href="#" title="My first post">My first post</a></h2>
            <div class="entry-meta">
              <span class="posted-on">Published on
                <span class="entry-date text-danger">April 10, 2016</span>
              </span>
              <span class="by-line"> by
                <span class="author"><a href="mailto:rodrigolinsr@gmail.com">Rodrigo Lins</a></span>
              </span>
              <br />
              <span class="category-name">Category:
                <span class="">&nbsp;<a href="#" rel="category">Uncategorized</a></span>
              </span>
            </div>
          </header>
          <div class="entry-content">
            {!! file_get_contents('http://loripsum.net/api/10/short/headers') !!}
          </div>
        </article>
      </div>
      <div class="col-md-3 sidebar-column">
        <div class="category-list">
          <h3>Categories</h3>
          <ul>
            <li>Uncategorized</li>
            @for ($i = 1; $i <= 5; $i++)
              <li><a href="#">Category {{ $i }}</a></li>
            @endfor
          </ul>
        </div>
        <div class="tag-cloud">
          <h3>Tags</h3>
          <ul>
            @for ($i = 1; $i <= 20; $i++)
              <li><a href="#" class="tag-rank-{{ rand(1,10) }}">Tag{{ $i }}</a></li>
            @endfor
          </ul>
        </div>
      </div>
    </div>
</div>
@endsection
