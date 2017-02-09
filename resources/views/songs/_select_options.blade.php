
  <option value="" disabled selected>{{ __('songs.select') }}</option>
  @foreach($songs as $song)
    <option value="{{ $song->id }}" @if(!empty($selectedSongId) && $selectedSongId == $song->id) selected @endif>
      <span class="title">{{ $song->full_title }}</span>
      <span class="grey-text text-lighten-1">{{ $song->author_list }}</span>
    </option>  
  @endforeach