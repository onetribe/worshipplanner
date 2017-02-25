@extends('layouts.app')

@section('menu_items')
    <li>
        <a class="waves-effect waves-light tooltipped" 
           data-position="bottom" 
           data-delay="50" 
           data-tooltip="{{ __('songs.back') }}" 
           href="{{ route('songs.index') }}"><i class="material-icons">skip_previous</i></a>
    </li>
    <li>
        <a class="waves-effect waves-light tooltipped" 
           data-position="bottom" 
           data-delay="50" 
           data-tooltip="{{ __('common.edit') }}" 
           href="{{ route('songs.edit', ['song' => $song]) }}"><i class="material-icons">edit</i></a>
    </li>
@endsection

@section('content')
    

    <div class="section" id="view-song">

      <div class="row">
        <div class="col s12 m7">
          <div class="card">
            <div class="card-content" style="overflow:auto;">
              <h1>{{ $song->full_title }}</h1>
              <div class="row">
                <wpsong :song="song" 
                    :showing-chords="showingChords" 
                    :showing-sections="showingSections" 
                    :showing-comments="showingComments"
                    :showing-columns="showingColumns"
                ></wpsong>
                
              </div>
              <div class="row">
                @if($song->copyrights)
                  <p class="grey-text">
                    {{ __('songs.copyrights') }}: {{ $song->copyrights }}
                  </p>
                @endif
              </div>
            </div>
          </div>
        </div>


        <div class="col s12 m5">
          <div class="card">
            <div class="card-content" v-cloak>
              <div class="chip tooltipped right" v-if="song.default_key"
                  data-position="bottom" 
                  data-delay="50" 
                  data-tooltip="{{ __('songs.key') }}" >@{{ song.default_key }}</div> 
                <div class="chip tooltipped right" v-if="song.default_time_signature"
                  data-position="bottom" 
                  data-delay="50" 
                  data-tooltip="{{ __('songs.time_signature') }}" >@{{ song.default_time_signature }}</div> 
                <div class="chip tooltipped right" v-if="song.default_tempo"
                  data-position="bottom" 
                  data-delay="50" 
                  data-tooltip="{{ __('songs.tempo') }}" >@{{ song.default_tempo }}</div>

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
              @if($song->youtube)
              <p>
                <h5>{{ __('songs.youtube') }}</h5>
                  <a href="{{ $song->youtube }}" target="_blank">{{ $song->youtube }}</a>
              </p>
              @endif
              @if($song->ccli)
              <p>
                <h5>{{ __('songs.ccli_number') }}</h5>
                  {{ $song->ccli }}
              </p>
              @endif
            </div>
          </div>
        </div>

      </div>

    </div>
    </form>

@endsection


@section('scripts')
<script type="text/javascript">
var song = {!! $song->toJson() !!};

app = new Vue({ 
    el: '#view-song',
    data: {
        song: song,
        showingChords: true,
        showingSections: true,
        showingComments: true,
        showingColumns: false
    },
    components: {
      wpsong
    }
});
</script>
@endsection
