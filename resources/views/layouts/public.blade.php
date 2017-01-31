@include("_header")

<nav>
  <div class="nav-wrapper">
    <ul class="right">
      <li><a href="{{ url("/login") }}" class="white-text">{{ trans('auth.login') }}</a></li>
      <li><a href="{{ url("/register") }}" class="white-text">{{ trans('auth.register') }}</a></li>
    </ul>
  </div>
</nav>


 @yield('content')

@include("_footer")
