@extends('layouts.app')

@section('menu_items')
    <li>
        <a class="waves-effect waves-light tooltipped" 
           data-position="bottom" 
           data-delay="50" 
           data-tooltip="{{ __('songs.back') }}" 
           href="{{ route('songs.index') }}"><i class="material-icons">skip_previous</i></a>
    </li>
@endsection

@section('content')
    

    <div class="section" id="view-song">

      <div class="row">
        <div class="col s12 m6">
          <div class="card">
            <div class="card-content">
              <div class="row">
                <wpsong :song="song" 
                    :showing-chords="showingChords" 
                    :showing-sections="showingSections" 
                    :showing-comments="showingComments"
                    :showing-columns="showingColumns"
                ></wpsong>
                
              </div>
            </div>
          </div>
        </div>


        <div class="col s12 m6">
          <div class="card">
            <div class="card-content">
              
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
