
<select name="default_time_signature">
     <option value="" disabled >{{ __('songs.choose_time_signature') }}</option>
     @foreach(config('songs.time_signatures') as $time_signature)
          <?php
          if (!empty($selectedTimeSignature) && $time_signature == $selectedTimeSignature) {
               $selected = true;
          } elseif ($loop->first) {
               $selected = true;
          } else {
               $selected = false;
          }
          ?>
          <option value="{{ $time_signature }}" @if ($selected) selected @endif>{{ $time_signature }}</option>
     @endforeach
</select>