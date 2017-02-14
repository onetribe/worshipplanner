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
<div class="col s12 m4">
  <div class="card">
    <div class="card-content">
      <h5>@{{ set.title }}</h5>
      <div class="row">
        <ul class="collection col s12 sets-edit-collection">
          <li class="collection-item cursorPointer avatar" v-for="(setSong, index) in set.set_songs" v-on:click="selectSong(index)" >
              <i class="circle">@{{ setSong.either_key }}</i>
              <span class="title" >@{{ setSong.song.title }}</span><br/>
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
      </div>
    </div>
  </div>

@include('sets._description_card')

</div>

<div class="col s12 m8">
  <div class="card" v-show="selected != null">
    <div class="card-content">
      <div v-for="(setSong, index) in set.set_songs" v-show="selected == index">
        <h5><div class="chip">@{{ setSong.either_key }}</div> @{{ setSong.song.full_title }}</h5>
        <h6 class="grey-text " >@{{ setSong.song.author_list }}</h6>
        <div class="">
          <song :song="setSong" 
                :showing-chords="showingChords" 
                :showing-sections="showingSections" 
                :showing-comments="showingComments"
          ></song>
        </div>
      </div>
      
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
    
    app = new Vue({ 
        el: '#view-set',
        data: {
            set: initialSet,
            selected: null,
            showingChords: true,
            showingSections: true,
            showingComments: true
        },
        components: {
          song
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