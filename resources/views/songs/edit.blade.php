@extends('layouts.app')

@section('menu_items')
    <li>
        <a class="waves-effect waves-light tooltipped" 
           data-position="bottom" 
           data-delay="50" 
           data-tooltip="{{ __('songs.back_view') }}" 
           href="{{ route('songs.view', ['song' => $song]) }}"><i class="material-icons">skip_previous</i></a>

        <a class="waves-effect waves-light tooltipped" 
           data-position="bottom" 
           data-delay="50" 
           data-tooltip="{{ __('common.delete') }}" 
           href="{{ route('songs.delete', ['song' => $song]) }}"><i class="material-icons">delete</i></a>
    </li>
@endsection

@section('content')
    <form role="form" method="POST" action="{{ route('songs.update', ['song' => $song]) }}">
    {{ method_field('PUT') }}
    {{ csrf_field() }}

    <div class="section">

      <div class="row">
        <div class="col s12 m6">
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="input-field col s12">
                  <textarea style="min-height:270px;" id="lyrics" name="lyrics" class="materialize-textarea song-lyrics-textarea">{{ $song->lyrics }}</textarea>
                  <label for="lyrics">Lyrics</label>
                </div>
                <div class="right">
                  <a class="waves-effect btn-flat" id="autoDetectBtn">Auto-detect lines</a>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col s12 m6">
          <div class="card">
            <div class="card-content">
              @include('songs._basic_form_fields', ['defaultTitle' => $song->title, 'defaultAlternativeTitle' => $song->alternative_title])
              <div class="row">
                <div class="input-field col s12">
                  @include('authors._select', ['selectedAuthors' => $song->authors])
                  <label for="authors">{{ __('authors.authors')}}</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s4">
                  <input type="number" step="1" id="ccli" name="ccli" type="text" class="validate" value="{{ $song->ccli}}">
                  <label for="ccli">{{ __('songs.ccli_number') }}</label>
                </div>
                <div class="input-field col s2">
                  @include('songs._key_select', ['selectedKey' => $song->default_key])
                  <label>{{ __('songs.key') }}</label>
                </div>
                <div class="input-field col s3">
                  @include('songs._time_signature_select', ['selectedTimeSignature' => $song->default_time_signature])
                  <label>{{ __('songs.time_signature') }}</label>
                </div>
                <div class="input-field col s2">
                  <input type="number" step="1" id="default_tempo" name="default_tempo" type="text" class="validate" value="{{ $song->default_tempo }}">
                  <label for="default_tempo">{{ __('songs.tempo') }}</label>
                </div>
              </div>

              <div class="row">
                <div class="input-field col s12">
                  <input id="youtube" name="youtube" type="text" class="validate" value="{{ $song->youtube }}">
                  <label for="youtube">{{ __('songs.youtube') }}</label>
                </div>
              </div>

              <div class="row">
                <div class="input-field col s12">
                  <input id="copyrights" name="copyrights" type="text" class="validate" value="{{ $song->copyrights }}">
                  <label for="copyrights">{{ __('songs.copyrights') }}</label>
                </div>
              </div>
              
              <input type="submit" class="btn btn-large right" value="{{__('form.save') }}"/>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>

      </div>

    </div>
    </form>

@endsection


@section('scripts')
<script type="text/javascript">

$(function(){
    var lineDetector = new LyricLineDetect();

    $("#autoDetectBtn").click(function () {
        $("#lyrics").val(lineDetector.convertText($("#lyrics").val(), true));
    });
});
</script>
@endsection
