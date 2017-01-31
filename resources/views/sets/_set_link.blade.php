<?php
    $title = $set->title;

    if (! $title) {
            $userDateTime = $set->when ? app('date_helper')->userDateTime($set->when) : null;
            
            $includeYear = $userDateTime && $now->format("Y") == $userDateTime->format("Y");
            $title = $userDateTime ? $userDateTime->format("j F" . ($includeYear ? " Y" : "")) : "";
    }
?>
<a class="collection-item" href="{{ route('sets.view', ['set' => $set]) }}">{{ $title }}</a>