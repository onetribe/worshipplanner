<?php

namespace App\Services;

use App\User;
use Carbon\Carbon;

interface DateHelperInterface
{

    /**
     * Return the user's timezone
     *
     * @param App\User $user
     * @return \DateTimezone
     **/
    public function getUserTimezone(User $user = null);

    /**
     * Returns the user's datetime in their own timezone
     *
     * @param App\User $user
     * @return Carbon\Carbon
     **/
    public function userDateTimeNow(User $user = null);

    /**
     * Returns the user's datetime in their own timezone
     *
     * @param Carbon $dateTimeStr
     * @param App\User $user
     * @return Carbon\Carbon
     **/
    public function userDateTime(Carbon $dateTime, User $user = null);

    /**
     * Gets a carbon date object from an input string
     *
     * @param string $str
     * @param string $format
     * @return Carbon\Carbon
     **/
    public function getFromInputString($str, $format = "j F, Y");
    
    /**
     * Takes a Carbon date object and converts to UTC timezone.
     *
     * @param Carbon\Carbon $dateTime
     * @return Carbon\Carbon
     **/
    public function toUTC(Carbon $dateTime);

}
