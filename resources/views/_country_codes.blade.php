
<select name="country_code">

@foreach(config('country_codes') as $code => $name)
    <option value="{{ $code }}" <?php if (!empty($selectedCountry) && $selectedCountry == $code) echo "selected"; ?>>{{ $name }}</option>
@endforeach

</select>