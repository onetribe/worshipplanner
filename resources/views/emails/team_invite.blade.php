@extends('emails.layout')

@section('content')

{!! __('emails.team_invite', [
		'team_name' => $team_name, 
		'app_name' => $app_name, 
		'invite_link' => $invite_link
	]) 
!!}

@endsection