<select id="authors" name="authors[]" multiple>
<option value="" disabled >{{ __('authors.choose') }}</option>
@foreach($authors as $author)
    <option value="{{ $author->id }}" @if(!empty($selectedAuthors) && $selectedAuthors->find($author)) selected @endif>{{ $author->name}}</option>
@endforeach

</select>