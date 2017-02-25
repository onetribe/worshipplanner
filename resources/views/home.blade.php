@extends('layouts.app')

@section('content')
<div class="container">
<div class="section">

  <div class="row">
    <div class="col s12 m10 offset-m1">
      <div class="row">
        <div class="card home-page-card col s6">
            <a class="card-content center-align" href="{{ route('sets.index') }}">
                <p>
                  <i class="large material-icons ">list</i>    
                </p>
                <p>
                  <span class="card-title">{{ __('common.sets') }}</span>    
                </p>
            </a>
        </div>
        <div class="card home-page-card col s6">
            <a class="card-content center-align" href="{{ route('songs.index') }}">
                <p>
                  <i class="large material-icons ">queue_music</i>    
                </p>
                <p>
                  <span class="card-title">{{ __('common.songs') }}</span>    
                </p>
            </a>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
