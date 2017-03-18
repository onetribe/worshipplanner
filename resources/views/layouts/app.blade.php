@include("_header")

<ul id="slide-out" class="side-nav">
  <li class="logo-container" style=""><img src="/images/muso_logo_white.png"/></li>
  <li><a class="waves-effect" href="{{ route('sets.index') }}"><i class="material-icons">list</i>{{ __('common.sets') }}</a></li>
  <li><a class="waves-effect" href="{{ route('songs.index') }}"><i class="material-icons">queue_music</i>{{ __('common.songs') }}</a></li>
  <li><div class="divider"></div></li>
  @if(Auth::user()->teams->count() > 1)
    @foreach(Auth::user()->teams as $aTeam)
    <li class="@if(app(\App\Services\ActiveTeam::class)->get()->id == $aTeam->id) grey lighten-2 @endif"><a class="waves-effect" href="{{ route('teams.activate', ['team' => $aTeam]) }}"
        >{{ substr($aTeam->title, 0, 27) }}@if(strlen($aTeam->title) > 27)...@endif</a>
    </li>
    @endforeach
  <li><div class="divider"></div></li>
  @endif
  <li class="no-padding">
    <ul class="collapsible collapsible-accordion">
      <li>
        <a class="collapsible-header">Settings<i class="material-icons">arrow_drop_down</i></a>
        <div class="collapsible-body">
          <ul>
            <li><a href="{{ route('me') }}"><i class="material-icons">perm_identity</i> {{ __('common.profile') }}</a></li>
            @can('update', app(\App\Services\ActiveTeam::class)->get())
            <li><a href="{{ route('settings.team') }}"><i class="material-icons">settings</i> {{ __('common.team_settings') }}</a></li>
            @endcan
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

<div class="muso-loader">
</div>
<nav>
  <div class="nav-wrapper">
    <ul class="left">
      <li><a href="#" data-activates="slide-out" class="menu-slide-out-button button-collapse left"><i class="material-icons">menu</i></a></li>
      <li class="hide-on-small-only">{{ app(App\Services\ActiveTeam::class)->get()->title }}</li>
    </ul>
    
    <ul class="right">
      @yield('menu_items')
    </ul>
  </div>
</nav>

@include('layouts._flash_messages')

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