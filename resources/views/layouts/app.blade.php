@include("_header")

<ul id="slide-out" class="side-nav">
  <li><a href="index.php"><h5 style="font-weight: 600;">WORSHIP SETS</h5></a></li>
  <li><a class="waves-effect" href="{{ route('sets.index') }}"><i class="material-icons">list</i>Sets</a></li>
  <li><a class="waves-effect" href="{{ route('songs.index') }}"><i class="material-icons">queue_music</i>Songs</a></li>
  <li><div class="divider"></div></li>
  <li><a class=" waves-effect" href="{{ url('/logout') }}"
        onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
        Sign out
    </a>

    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
  </li>
</ul>

<nav>
  <div class="nav-wrapper">
    <ul class="left">
      <li><a href="#" data-activates="slide-out" class="menu-slide-out-button button-collapse left"><i class="material-icons">menu</i></a></li>
    </ul>
    
    <ul class="right">
      @yield('menu_items')
    </ul>
  </div>
</nav>

@if(Session::has('alert-success'))
    <div class="alert-box card-panel light-green lighten-4">
        {{ Session::get('alert-success') }}
    </div>
@endif
@if(Session::has('alert-failure'))
    <div class="alert-box card-panel red lighten-2">
        {{ Session::get('alert-failure') }}
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert-box card-panel red lighten-2">
        {{ __('common.input_error') }}<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

 @yield('content')

@include("_footer")

{{--
<body>
    <div id="app">
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
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->first_name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>

--}}
