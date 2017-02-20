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
              <td>@{{ song.full_title }}</td>
              <td>
                  <div class="chip" v-for="author in song.authors">@{{ author.name }}</div>
              </td>
              <td>@{{ song.default_key }}</td>
              @if($canManage)
              <td>
                  <a 
                     v-on:click="editSong(song.id)"
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
@include('songs._delete_modal')
@endsection

@section('scripts')
  <script type="text/javascript">
    var songs = {!! $songs->toJson() !!};
    var songEditUrl = "{{ route('songs.edit', ['song' => '']) }}";
    var songDeleteUrl = "{{ route('songs.delete', ['song' => '']) }}";

    app = new Vue({ 
        el: '#index-songs',
        data: {
            songs: songs,
            //filteredSongs: songs,
            searchText: "",
            songToDeleteId: null
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
          editSong: function (id) {
            window.location.href = songEditUrl + "/" + id;
          },
          deleteSong: function (id) {
            this.songToDeleteId = id;
            $("#delete-song-modal").modal('open');
           // window.location.href = songDeleteUrl + "/" + id;
          },
          confirmDelete: function () {
console.log(this.songToDeleteId);
            window.location.href = songDeleteUrl + "/" + this.songToDeleteId;
          }
        }
    });
</script>
@endsection
