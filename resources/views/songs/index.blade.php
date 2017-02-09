@extends('layouts.app')

@if (Auth::user()->can('update', $songs->first()))
  <?php $canManage = true; ?>
@else
  <?php $canManage = false; ?>
@endif

@section('menu_items')
    <li>
        <a class="waves-effect waves-light tooltipped" 
           data-position="bottom" 
           data-delay="50" 
           data-tooltip="{{ __('songs.add') }}" 
           href="#add-song-modal"><i class="material-icons">add</i></a>
    </li>
@endsection

@section('content')
<div class="section">
  <div class="row">
    <div class="col s12">
      <table class="striped">
        <thead>
          <tr>
              <th data-field="search"><input type="search" name="search_song" placeholder="search" /></th>
              <th data-field="author">{{ __('authors.authors') }}</th>
              <th data-field="key">{{ __('songs.key') }}</th>
              @if($canManage)
              <th data-field="manage">{{ __('common.manage') }}</th>
              @endif
          </tr>
        </thead>
        <tbody>
          @foreach($songs as $song)
            <tr>
              <td>{{ $song->full_title }}</td>
              <td>
                @foreach($song->authors as $author)
                  <div class="chip">{{ $author->name }}</div>
                @endforeach
              </td>
              <td>{{ $song->default_key }}</td>
              @if($canManage)
              <td>
                  <a href="{{ route('songs.edit', ['song' => $song]) }}"
                     class="tooltipped"
                     data-position="bottom" 
                     data-delay="50" 
                     data-tooltip="{{ __('common.edit') }}" ><i class='material-icons'>edit</i></a>
                  &nbsp;
                  <a href="{{ route('songs.delete', ['song' => $song]) }}"
                     class="tooltipped"
                     data-position="bottom" 
                     data-delay="50" 
                     data-tooltip="{{ __('common.delete') }}" ><i class='material-icons'>delete</i></a>
              </td>
              @endif
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@include('songs._add_modal')
@endsection
