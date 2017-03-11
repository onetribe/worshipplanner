<?xml version="1.0" encoding="UTF-8"?>
<song>
  <title>{{ $song->full_title }}</title>
  <author>{{ $song->author_list }}</author>
  <copyright>{{ $song->copyrights }}</copyright>
  <hymn_number></hymn_number>
  <presentation></presentation>
  <ccli>{{ $song->ccli }}</ccli>
  <capo print="false"></capo>
  <key>{{ $song->default_key }}</key>
  <aka></aka>
  <key_line></key_line>
  <user1></user1>
  <user2></user2>
  <user3></user3>
  <theme></theme>
  <tempo>{{ $song->default_tempo }}</tempo>
  <time_sig>{{ $song->default_timesignature }}</time_sig>
  <lyrics>{{ $song->lyrics }}</lyrics>
</song>