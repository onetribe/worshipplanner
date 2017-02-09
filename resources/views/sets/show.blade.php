@extends('layouts.app')

@section('menu_items')
    <li>
        <a class="waves-effect waves-light tooltipped" 
           data-position="bottom" 
           data-delay="50" 
           data-tooltip="{{ __('sets.delete') }}" 
           href="{{ route('sets.delete', ['set' => $set]) }}"><i class="material-icons">delete</i></a>
    </li>
@endsection

@section('content')
<div class="section" id="manage-set">


<div class="row">
<div class="col s12 m4">
  <div class="card">
    <div class="card-content">
      <h5>@{{ set.title }}</h5>
      <div class="row">
        <ul class="collection col s12">
            <draggable 
                :list="set.set_songs" 
                :options="{group:'songs'}" 
                element="li" 
                @end="onEnd"
            >
                <li class="collection-item " v-for="(setSong, index) in set.set_songs" v-on:click="selectSong(index)" >
                    <span class="secondary-content cursorPointer" ><i class="material-icons grey-text text-lighten-2 " v-on:click="removeSong(setSong)">delete</i></span>
                    <span class="title cursorPointer" >@{{ setSong.song.title }}</span><br/>
                    <span class="grey-text cursorPointer" >@{{ setSong.song.author_list }}</span>
                </li>
            </draggable>
        </ul>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <select id="songSelect" class="browser-default" v-on:change="addSong">
            @include('songs._select_options')
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="card ">
    <div class="card-content">
      <p><b>Description:</b> <br/><em>@{{ set.description}} </em></p>
      <p><b>Service:</b> <br/>
        @{{ set.service ? set.service.title : ""}}
      </p>
    </div>
  </div>

</div>

<div class="col s12 m8">
  <div class="card">
    <div class="card-content">
      <a class='btn-floating dropdown-button right waves-effect waves-light tooltipped' data-position="bottom"  data-tooltip="Transpose to key" href='#' data-activates='transposeDropdown'><i class="material-icons">trending_up</i></a>
      <ul id='transposeDropdown' class='dropdown-content'>
        <li><a href="#!">A</a></li>
        <li><a href="#!">Bb</a></li>
        <li><a href="#!">B</a></li>
        <li><a href="#!">C</a></li>
        <li><a href="#!">Db</a></li>
        <li><a href="#!">D</a></li>
        <li><a href="#!">Eb</a></li>
        <li><a href="#!">E</a></li>
        <li><a href="#!">F</a></li>
        <li><a href="#!">F#</a></li>
        <li><a href="#!">G</a></li>
        <li><a href="#!">Ab</a></li>
      </ul>
      
      <div v-for="(setSong, index) in set.set_songs" v-show="selected == index">
        <h5>@{{ setSong.song.full_title }}</h5>
        <textarea 
            :id="'song-lyrics-'+setSong.id" 
            class="materialize-textarea song-lyrics-textarea" 
            v-model="setSong.song_lyrics ? setSong.song_lyrics : setSong.song.lyrics"
            v-on:change="updateSongLyrics"
        ></textarea>
      </div>
      
    </div>
  </div>
</div>

</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    var initialSet = {!! $set->toJson() !!};
    var fetchSetUrl = "{{ route('sets.view', ['set' => $set]) }}";
    var orderSongsUrl = "{{ route('set_songs.order', ['set' => $set]) }}";
    var addSongUrl = "{{ route('set_songs.store') }}";
    var removeSongUrl = "{{ route('set_songs.delete', ['setSong' => new \App\SetSong]) }}";
    var updateSongUrl = "{{ route('set_songs.update', ['setSong' => new \App\SetSong]) }}";
    var csrfToken = "{{ csrf_token() }}";
    
    app = new Vue({ 
        el: '#manage-set',
        data: {
            set: initialSet,
            selected: null
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
            }
        },
        methods: {
            fetchSongs: function () {
                var app = this;
                $.get(fetchSetUrl, {}, null, 'json').done(function(data) {
                    app.set = data.set;
                });
            },
            reorderSongs: function () {
                $.post(
                    orderSongsUrl, 
                    {'_token': csrfToken, 'songs': this.set.set_songs},
                    null,
                    'json'
                ).done(function () {

                });
            },
            onEnd: function (evt) {
                this.reorderSongs();
            },
            selectSong: function (index) {
                this.selected = index;
                $("#song-lyrics").trigger('autoresize');
            },
            addSong: function (e) {
                var app = this;
                var song_id = e.target.value;
                var data = {
                  '_token': csrfToken,
                  'set_id': initialSet.id,
                  'song_id': song_id
                };
                $.post(
                    addSongUrl, 
                    data,
                    null,
                    'json'
                ).done(function () {
                    app.fetchSongs();
                });
            },
            removeSong: function (setSong) {
                var app = this;
                $.get(
                    removeSongUrl + "/" + setSong.id
                ).done(function () {
                    app.fetchSongs();
                });
            },
            updateSong: function (setSong, field, value) {
                var app = this;
                var data = {
                  '_token': csrfToken
                };
                data[field] = value;
                $.post(
                    updateSongUrl + "/" + setSong.id,
                    data,
                    null,
                    'json'
                ).done(function () {
                    app.fetchSongs();
                });
            },
            updateSongLyrics: function (e) {
                this.updateSong(this.currentSong, 'song_lyrics', e.target.value);
            }
        }
    });
</script>
@endsection