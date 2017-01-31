
<select name="default_key">
     <option value="" disabled >{{ __('songs.choose_key') }}</option>
     @foreach(config('songs.keys') as $key)
          <?php
          if (!empty($selectedKey) && $key == $selectedKey) {
               $selected = true;
          } elseif ($loop->first) {
               $selected = true;
          } else {
               $selected = false;
          }
          ?>
          <option value="{{ $key }}" @if ($selected) selected @endif>{{ $key }}</option>
     @endforeach
</select>