<?xml version="1.0" encoding="UTF-8"?>
<set name="{{ $set->title }}">
  <slide_groups>
  @foreach($set->songs as $song)<slide_group name="{{ $song->full_title }}" type="song" presentation="" path=""/>@endforeach
</slide_groups>
</set>