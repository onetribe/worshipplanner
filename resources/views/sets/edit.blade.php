@extends('layouts.app')

@section('menu_items')
  <li>
      <a class="waves-effect waves-light tooltipped" 
         data-position="bottom" 
         data-delay="50" 
         data-tooltip="{{ __('sets.view') }}" 
         href="{{ route('sets.view', ['set' => $set]) }}"><i class="material-icons">skip_previous</i></a>
  </li>
  <li>
      <a class="waves-effect waves-light tooltipped" 
         data-position="bottom" 
         data-delay="50" 
         data-tooltip="{{ __('sets.edit_details') }}" 
         href="#add-edit-set-modal"><i class="material-icons">edit</i></a>
  </li>
  <li>
      <a class="waves-effect waves-light tooltipped" 
         data-position="bottom" 
         data-delay="50" 
         data-tooltip="{{ __('sets.edit_members') }}" 
         href="{{ route('sets.members', ['set' => $set]) }}"><i class="material-icons">assignment_ind</i></a>
  </li>
  <li>
      <a class="waves-effect waves-light tooltipped" 
         data-position="bottom" 
         data-delay="50" 
         data-tooltip="{{ __('sets.delete') }}" 
         href="{{ route('sets.delete', ['set' => $set]) }}"><i class="material-icons">delete</i></a>
  </li>
@endsection

@section('content')
<div class="section lime lighten-5" id="manage-set" v-cloak>


<div class="row">
<div class="col s12 m4">
  <div class="card">
    <div class="card-content">
      <h5>@{{ set.title }}</h5>
      <div class="row">
        <ul class="collection col s12 sets-edit-collection">
            <draggable 
                :list="set.set_songs" 
                :options="{group:'songs'}" 
                element="li" 
                @end="onEnd"
            >
                <li class="collection-item cursorPointer avatar" v-for="(setSong, index) in set.set_songs" v-on:click="selectSong(index)" >
                    <i class="circle">@{{ setSong.either_key }}</i>
                    <span class="secondary-content " ><i 
                      class="material-icons grey-text text-lighten-2 tooltipped" 
                      v-on:click="removeSong(setSong)"
                      data-position="bottom" 
                      data-delay="50" 
                      data-tooltip="{{ __('sets.remove_song') }}" 
                      >delete</i></span>
                    <span class="title" >@{{ setSong.song.title }}</span><br/>
                </li>
            </draggable>
        </ul>
      </div>

      <div class="row">
        <div class="input-field col s12 tooltipped" 
              data-position="bottom" 
              data-delay="50" 
              data-tooltip="{{ __('sets.add_song') }}" 
          >
          <select id="songSelect" class="browser-default" v-on:change="addSong">
            @include('songs._select_options')
          </select>
        </div>
      </div>
    </div>
  </div>

@include('sets._description_card')

</div>

<div class="col s12 m8">
  <div class="card " v-show="selected != null">
    <div class="card-content">
      <a class='btn-floating dropdown-button right waves-effect waves-light tooltipped' data-position="bottom"  data-tooltip="{{ __('songs.transpose') }}" href='#' data-activates='transposeDropdown'><i class="material-icons">trending_up</i></a>
      <ul id='transposeDropdown' class='dropdown-content'>
        @foreach (app('App\\Services\\ScaleService')->getDefaultKeys() as $key)
          <li><a href="#!" v-on:click="transposeSongLyrics('{{ $key }}')">{{ $key }}</a></li>
        @endforeach
      </ul>
      
      <div v-for="(setSong, index) in set.set_songs" v-show="selected == index">
        <h5>
          <div class="chip tooltipped" v-show="setSong.either_tempo"
              data-position="bottom" 
              data-delay="50" 
              data-tooltip="{{ __('songs.tempo') }}" >@{{ setSong.either_tempo }}</div>
          <div class="chip tooltipped" v-if="setSong.song.default_time_signature"
              data-position="bottom" 
              data-delay="50" 
              data-tooltip="{{ __('songs.time_signature') }}" >@{{ setSong.song.default_time_signature }}</div>
          <div class="chip tooltipped" v-if="setSong.either_key"
              data-position="bottom" 
              data-delay="50" 
              data-tooltip="{{ __('songs.key') }}" >@{{ setSong.either_key }}</div> 
          @{{ setSong.song.full_title }}</h5>
        <h6 class="grey-text" >@{{ setSong.song.author_list }}</h6>
        <textarea 
            :id="'song-lyrics-'+setSong.id" 
            class="materialize-textarea song-lyrics-textarea" 
            v-model="setSong.song_lyrics ? setSong.song_lyrics : setSong.song.lyrics"
            v-on:change="updateSongLyrics"
        ></textarea>
        <a class='btn-floating left waves-effect waves-light tooltipped' data-position="top"  data-tooltip="{{ __('songs.edit_original') }}"  :href="this.editSongUrl.replace('songId', setSong.song.id)" data-activates='transposeDropdown'><i class="material-icons">queue_music</i></a>
      </div>

      <div class="grey-text right" v-show="usingOriginal">{{ __('songs.using_original') }}</div>
      <div class="grey-text right" v-show="usingEdited">{{ __('songs.using_edited') }}</div>

      
      <div class="clearfix"></div>
      
    </div>
  </div>
</div>

</div>
</div>

@include('sets._add_edit_modal', ['route' => route('sets.update', ['set' => $set]) ])

@endsection



@section('scripts')
<script type="text/javascript">
    var initialSet = {!! $set->toJson() !!};
    var fetchSetUrl = "{{ route('sets.view', ['set' => $set]) }}";
    var orderSongsUrl = "{{ route('set_songs.order', ['set' => $set]) }}";
    var addSongUrl = "{{ route('set_songs.store') }}";
    var editSongUrl = "{{ route('songs.edit', ['song' => 'songId']) }}";
    var removeSongUrl = "{{ route('set_songs.delete', ['setSong' => new \App\SetSong]) }}";
    var updateSongUrl = "{{ route('set_songs.update', ['setSong' => new \App\SetSong]) }}";
    var transposeSongUrl = "{{ route('set_songs.transpose', ['setSong' => new \App\SetSong]) }}";
    var csrfToken = "{{ csrf_token() }}";
    
    app = new Vue({ 
        el: '#manage-set',
        data: {
            set: initialSet,
            selected: null,
            editSongUrl: editSongUrl
        },
        components: {
            draggable
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
            },
            usingOriginal: function () {
              return this.currentSong ? !this.currentSong.song_lyrics : false;
            },
            usingEdited: function () {
              return !this.usingOriginal;
            }
        },
        methods: {
            fetchSongs: function () {
                var app = this;
                this.$http.get(fetchSetUrl).then(function (Response) {
                  this.set = Response.body.set;
                }.bind(this));
            },
            reorderSongs: function () {
              this.$http.post(orderSongsUrl, {'songs': this.set.set_songs});
            },
            onEnd: function (evt) {
                this.reorderSongs();
            },
            selectSong: function (index) {
                this.selected = index;
                $("#song-lyrics").trigger('autoresize');
            },
            addSong: function (e) {
                var song_id = e.target.value;
                var data = {
                  '_token': csrfToken,
                  'set_id': initialSet.id,
                  'song_id': song_id
                };
                this.$http.post(addSongUrl, data).then(function (Response) {
                  this.fetchSongs();
                }.bind(this));
            },
            removeSong: function (setSong) {
                this.$http.delete(removeSongUrl + "/" + setSong.id).then(function (Response) {
                  this.fetchSongs();
                }.bind(this));
            },
            updateSong: function (setSong, field, value) {
                var app = this;
                var data = {
                  '_token': csrfToken
                };
                data[field] = value;
                this.$http.post(updateSongUrl + "/" + setSong.id, data).then(function (Response) {
                  this.fetchSongs();
                }.bind(this));
            },
            updateSongLyrics: function (e) {
                this.updateSong(this.currentSong, 'song_lyrics', e.target.value);
            },
            transposeSongLyrics: function (key) {
                var data = {
                  'key': key
                };
                this.$http.post(transposeSongUrl + "/" + this.currentSong.id, data).then(function (Response) {
                  this.fetchSongs();
                }.bind(this));
            }
        }
    });
</script>
@endsection