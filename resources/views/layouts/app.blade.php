@include("_header")

<ul id="slide-out" class="side-nav">
  <li><a href="index.php"><h5 style="font-weight: 600;">WORSHIP SETS</h5></a></li>
  <li><a class="waves-effect" href="{{ route('sets.index') }}"><i class="material-icons">list</i>Sets</a></li>
  <li><a class="waves-effect" href="{{ route('songs.index') }}"><i class="material-icons">queue_music</i>Songs</a></li>
  <li><div class="divider"></div></li>
  <li class="no-padding">
    <ul class="collapsible collapsible-accordion">
      <li>
        <a class="collapsible-header">Settings<i class="material-icons">arrow_drop_down</i></a>
        <div class="collapsible-body">
          <ul>
            <li><a href="{{ route('me') }}">{{ __('common.profile') }}</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </li>
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