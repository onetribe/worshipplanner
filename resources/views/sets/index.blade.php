@extends('layouts.app')

@section('menu_items')
    <li>
        <a class="waves-effect waves-light tooltipped" 
           data-position="bottom" 
           data-delay="50" 
           data-tooltip="{{ __('sets.add') }}" 
           href="#add-edit-set-modal"><i class="material-icons">add</i></a>
    </li>
@endsection

@section('content')
<div class="container">
    <div class="section">
      <div class="row">
        <div class="col s12">
          <div class="collection with-header">
            <div class="collection-header deep-orange-text text-lighten-2"><h4>{{ __('sets.future') }}</h4></div>
            @foreach($futureSets as $set)
                @include('sets._set_link', ['set' => $set])
            @endforeach
          </div>

          <div class="collection with-header">
            <div class="collection-header deep-orange-text text-lighten-2"><h4>{{ __('sets.past') }}</h4></div>
            @foreach($pastSets as $set)
                @include('sets._set_link', ['set' => $set])
            @endforeach
          </div>
        </div>
      </div>
    </div>
</div>

@include('sets._add_edit_modal', ['route' => route('sets.store') ])
@endsection
