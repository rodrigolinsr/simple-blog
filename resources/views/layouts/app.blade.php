<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $generalBlogTitle }} | {{ $generalBlogDescription }}</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/blog.css" rel="stylesheet">
    @if(Request::segment(1) === "admin")
      <link href="{{ url('css/admin.css') }}" rel="stylesheet">
    @endif

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ $generalBlogTitle }}
                </a>
                @if(Request::segment(1) !== "admin")
                  <sub class="text-muted sub-title">{{ $generalBlogDescription }}</sub>
                @endif

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
              @if(Request::segment(1) === "admin")
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ action('Admin\DashboardController@index') }}">Dashboard</a></li>
                    <li><a href="{{ action('Admin\PostsController@index') }}">Posts</a></li>
                    <li><a href="#">Comments</a></li>
                    <li><a href="#">Categories</a></li>
                    <li><a href="#">Tags</a></li>
                    <li><a href="{{ action('Admin\UsersController@index') }}">Users</a></li>
                </ul>
              @endif

              <!-- Right Side Of Navbar -->
              <ul class="nav navbar-nav navbar-right">
                <!-- Link to the Admin panel -->
                @if (Auth::guest())
                  <li><a href="{{ url('/admin') }}"><i class="fa fa-btn fa-tachometer"></i>Admin Panel</a></li>
                @else
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                      {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                      @if(Request::segment(1) === "admin")
                        <li><a href="{{ url('/') }}"><i class="fa fa-btn fa-file-text-o"></i>Blog page</a></li>
                        <li><a href="{{ url('/admin/profile') }}"><i class="fa fa-btn fa-user"></i>Profile</a></li>
                      @else
                        <li><a href="{{ url('/admin') }}"><i class="fa fa-btn fa-tachometer"></i>Admin Panel</a></li>
                      @endif
                      <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                    </ul>
                  </li>
                @endif
              </ul>
            </div>
        </div>
    </nav>

    <div class="container">
      <!-- Flash Messages -->
      @if(session('flashMessages'))
        <div class="row">
          <div class="col-md-12">
            @foreach(session('flashMessages') as $message)
            <div class="alert alert-{{ $message['type'] }} alert-dismissible">
              <button type="button" class="close" data-dismiss="alert"
              aria-hidden="true" style="font-size: 12px; margin-top: 7px;">&#10005;</button>
              {!! $message['text'] !!}
            </div>
            @endforeach
          </div>
        </div>
      @endif

      @yield('content')
    </div>

    <footer class="footer">
      <div class="container">
        <span class="text-muted">Copyright &copy; 2016 <a href="rodrigolinsr@gmail.com">Rodrigo Lins</a> |
        Developed specially for <a href="http://figured.com/" target="_blank">Figured</a>.</span>
      </div>
    </footer>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    @yield('bottomScripts')
</body>
</html>
