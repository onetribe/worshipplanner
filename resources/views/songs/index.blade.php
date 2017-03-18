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
<div class="section" id="index-songs" v-cloak>
  <div class="row">
    <div class="col s12">
      <table class="striped">
        <thead>
          <tr>
              <th>
                <a class='dropdown-button' href='#' data-activates='songs_select_dropdown'>
                  <i class="material-icons select-all-checkbox">offline_pin</i>
                </a>
                <ul id='songs_select_dropdown' class='dropdown-content' style="min-width: 200px;">
                  <li><a href="#!" v-on:click="selectAll()">{{ __('common.select_all') }}</a></li>
                  <li><a href="#!" v-on:click="selectNone()">{{ __('common.select_none') }}</a></li>
                  <li class="divider"></li>
                  <li><a href="#!" v-on:click="exportOpenSong()">{{ __('common.export_opensong') }}</a></li>
                </ul>
              </th>
              <th data-field="search">
              <input type="search" name="search_song" placeholder="search" v-model="searchText" />

              </th>
              <th data-field="author">{{ __('authors.authors') }}</th>
              <th data-field="key">{{ __('songs.key') }}</th>
              @if($canManage)
              <th data-field="manage">{{ __('common.manage') }}</th>
              @endif
          </tr>
        </thead>
        <tbody>
            <tr v-for="song in filteredSongs">
              <td width="20">
                <input type="checkbox" class="filled-in" :id="'song_checkbox_'+song.id" v-model="selectedSongs[song.id]" />
                <label :for="'song_checkbox_'+song.id"></label>
              </td>
              <td><a class="cursorPointer" :href="songViewUrl.replace('songId', song.id)">@{{ song.full_title }}</a></td>
              <td>
                  <div class="chip" v-for="author in song.authors">@{{ author.name }}</div>
              </td>
              <td>@{{ song.default_key }}</td>
              @if($canManage)
              <td>
                  <a 
                     :href="this.songEditUrl.replace('songId', song.id)"
                     class="tooltipped cursorPointer"
                     data-position="bottom" 
                     data-delay="50" 
                     data-tooltip="{{ __('common.edit') }}" ><i class='material-icons'>edit</i></a>
                  &nbsp;
                  <a 
                     v-on:click="deleteSong(song.id)"
                     class="tooltipped cursorPointer"
                     data-position="bottom" 
                     data-delay="50" 
                     data-tooltip="{{ __('common.delete') }}" ><i class='material-icons'>delete</i></a>
              </td>
              @endif
            </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@include('songs._add_modal')

@endsection

@section('scripts')
  <script type="text/javascript">
    var songs = {!! $songs->toJson() !!};
    var songEditUrl = "{{ route('songs.edit', ['song' => 'songId']) }}";
    var songViewUrl = "{{ route('songs.view', ['song' => 'songId']) }}";
    var songDeleteUrl = "{{ route('songs.delete', ['song' => '']) }}";
    var exportOpenSongUrl = "{{ route('export.opensong.songs') }}";
    var delete_are_you_sure = "{{ __('songs.delete_are_you_sure') }}";

    var selectedSongs = {};
    for (var i = 0; i < songs.length; i++) {
      selectedSongs[songs[i].id] = false;
    }

    app = new Vue({ 
        el: '#index-songs',
        data: {
            songs: songs,
            selectedSongs: selectedSongs,
            searchText: "",
            songViewUrl: songViewUrl,
            exportOpenSongUrl: exportOpenSongUrl,
            delete_are_you_sure: delete_are_you_sure
        },
        computed: {
          filteredSongs: function () {
            return this.songs.filter(function (song) {
                  var searchStr = new RegExp(this.searchText.replace(" ", ".*"), "i");

                  var titleSearch = song.full_title.search(searchStr);
                  var authorSearch = song.author_list.search(searchStr);
                  var lyricSearch = song.lyrics.search(searchStr);
                  
                  return titleSearch >= 0 || authorSearch >= 0 || lyricSearch >= 0 ? true : false;
                }, this);
          }
        },
        methods: {
          deleteSong: function (id) {
            if (! window.confirm(this.delete_are_you_sure)) {
              return;
            }

            window.location.href = songDeleteUrl + "/" + id;
          },
          exportOpenSong: function () {
            var form = document.createElement("form");
            form.setAttribute("method", "POST");
            form.setAttribute("action", exportOpenSongUrl);
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "_token");
            hiddenField.setAttribute("value", Laravel.csrfToken);
            form.appendChild(hiddenField);
            
            var selectedSongIds = [];
            for (var i = 0; i < this.songs.length; i++) {
              if (this.selectedSongs[this.songs[i].id]) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", "song_ids[]");
                hiddenField.setAttribute("value", this.songs[i].id);
                form.appendChild(hiddenField);
                selectedSongIds.push(this.songs[i].id);
              }
            }
            if (selectedSongIds.length == 0) {
              return;
            }

            document.body.appendChild(form);
            form.submit();
            form.remove();
          },
          selectAll: function () {
            for (var i = 0; i < this.filteredSongs.length; i++) {
              this.selectedSongs[this.filteredSongs[i].id] = true;
            }
          },
          selectNone: function () {
            for (var i = 0; i < this.filteredSongs.length; i++) {
              this.selectedSongs[this.filteredSongs[i].id] = false;
            }
          }

        }
    });
</script>
@endsection
