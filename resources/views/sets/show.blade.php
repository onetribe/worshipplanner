@extends('layouts.app')

<?php 
  $canManage = Auth::user()->can('update', $set) ? true : false; 
?>

@section('menu_items')

@if($canManage)
  <li>
      <a class="waves-effect waves-light tooltipped" 
         data-position="bottom" 
         data-delay="50" 
         data-tooltip="{{ __('common.edit') }}" 
         href="{{ route('sets.edit', ['set' => $set]) }}"><i class="material-icons">edit</i></a>
  </li>
@endif

@endsection

@section('content')
<div class="section" id="view-set" v-cloak>
<div class="row">
  <ul class="tabs">
    <li class="tab col s3"><a class="active" href="#view_set">{{ __('sets.view') }}</a></li>
    <li class="tab col s3"><a href="#view_details">{{ __('sets.view_details') }}</a></li>
  </ul>
</div>

<div id="view_set" class="col s12">
  <div class="row">
    <div class="col s12 m4">
      <div class="card">
        <div class="card-content">
          <h5>@{{ set.title }}</h5>
          <div class="row">
            <ul class="collection col s12 sets-edit-collection">
              <li class="collection-item cursorPointer avatar" v-for="(setSong, index) in set.set_songs" v-on:click="selectSong(index)" >
                  <i class="circle" v-if="setSong.either_key">@{{ setSong.either_key }}</i>
                  <span class="title">@{{ setSong.song.title }}</span><br/>
              </li>
            </ul>
          </div>

          <div class="row">
                <p>
                  <input type="checkbox" class="filled-in" id="show-chords-box" v-model="showingChords"/>
                  <label for="show-chords-box">{{ __('sets.show_chords') }}</label>
                </p>
                <p>
                  <input type="checkbox" class="filled-in" id="show-comments-box" v-model="showingComments"/>
                  <label for="show-comments-box">{{ __('sets.show_comments') }}</label>
                </p>
                <p>
                  <input type="checkbox" class="filled-in" id="show-sections-box" v-model="showingSections"/>
                  <label for="show-sections-box">{{ __('sets.show_sections') }}</label>
                </p>
                <p>
                  <input type="checkbox" class="filled-in" id="show-columns-box" v-model="showingColumns"/>
                  <label for="show-columns-box">{{ __('sets.show_columns') }}</label>
                </p>
          </div>
        </div>
      </div>
    </div>

    <div class="col s12 m8">
      <div class="card" v-show="selected != null">
        <div class="card-content">
          <div v-for="(setSong, index) in set.set_songs" v-show="selected == index">
            <h5>
              <div class="chip right tooltipped" v-show="setSong.either_tempo"
                  data-position="bottom" 
                  data-delay="50" 
                  data-tooltip="{{ __('songs.tempo') }}" >@{{ setSong.either_tempo }}</div>
              <div class="chip tooltipped right" v-if="setSong.song.default_time_signature"
                  data-position="bottom" 
                  data-delay="50" 
                  data-tooltip="{{ __('songs.time_signature') }}" >@{{ setSong.song.default_time_signature }}</div>
              <div class="chip tooltipped right" v-if="setSong.either_key"
                  data-position="bottom" 
                  data-delay="50" 
                  data-tooltip="{{ __('songs.key') }}" >@{{ setSong.either_key }}</div>  
              <a class="cursorPointer" v-bind:href="this.viewSongUrl.replace('songId', setSong.song.id)">@{{ setSong.song.full_title }}</a>
            </h5>
            <h6 class="grey-text " >@{{ setSong.song.author_list }}</h6>
            <div class="">
              <wpsong :song="setSong" 
                    :showing-chords="showingChords" 
                    :showing-sections="showingSections" 
                    :showing-comments="showingComments"
                    :showing-columns="showingColumns"
              ></wpsong>
            </div>
          </div>
          
        </div>
      </div>
    </div>

  </div>
</div>

<div id="view_details" class="">
  <div class="row">
    <div class="col s12 m6">
      @include('sets._description_card')
    </div>
    <div class="col s12 m6">
      @if($set->setSubscriptions->count() > 0)
      <ul class="collection card">
      @foreach($set->setSubscriptions as $subscription)
        <li class="collection-item">
          <span class="title">{{ $subscription->user->name }}</span>
          <p>
            @foreach($subscription->bandRoles as $role)
              <div class="chip">
                {{ $role->title }}
              </div>
            @endforeach
          </p>
        </li>
      @endforeach
      </ul>
      @endif
    </div>
  </div>
</div>

</div>

@include('sets._add_edit_modal', ['route' => route('sets.update', ['set' => $set]) ])

@endsection



@section('scripts')
<script type="text/javascript">
    var initialSet = {!! $set->toJson() !!};
    var viewSongUrl = "{{ route('songs.view', ['song' => 'songId']) }}";
    
    app = new Vue({ 
        el: '#view-set',
        data: {
            set: initialSet,
            selected: null,
            showingChords: true,
            showingSections: true,
            showingComments: true,
            showingColumns: false,
            viewSongUrl: viewSongUrl
        },
        components: {
          wpsong
        },
        computed: {
            currentSong: function () {
                return this.selected || this.set.set_songs[this.selected] ? this.set.set_songs[this.selected] : null;
            },
            currentSongLyrics: function () {
                if (!this.currentSong) {
                    return "";
                }

                return this.currentSong.song_lyrics ? this.currentSong.song_lyrics : this.currentSong.song.lyrics;
            }
        },
        methods: {
            selectSong: function (index) {
                this.selected = index;
                $("#song-lyrics").trigger('autoresize');
            }
        }
    });
</script>
@endsection