<?php

namespace App\Services;

use App\User;
use Carbon\Carbon;
use DateTimezone;
use Illuminate\Auth\AuthManager;

class DateHelper implements DateHelperInterface
{
    /**
     * @var App\User
     **/
    protected $user;

    /**
     * @var AuthManager $auth
     **/
    protected $auth;

    /**
     * @param AuthManager $auth
     * @return void
     **/
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;

        $this->user = $auth->user();
    }

    /**
     * Return the user's timezone
     *
     * @param App\User $user
     * @return \DateTimezone
     **/
    public function getUserTimezone(User $user = null)
    {
        return new DateTimezone($this->getUser()->timezone);
    }

    /**
     * Returns the user's datetime in their own timezone
     *
     * @param App\User $user
     * @return Carbon\Carbon
     **/
    public function userDateTimeNow(User $user = null)
    {
        return Carbon::now($this->getUserTimezone($user));
    }

    /**
     * Returns the user's datetime in their own timezone
     *
     * @param Carbon $dateTimeStr
     * @param App\User $user
     * @return Carbon\Carbon
     **/
    public function userDateTime(Carbon $dateTime, User $user = null)
    {
        $dt = $dateTime->copy();
        $dt->timezone = $this->getUserTimezone();

        return $dt;
    }

    /**
     * Gets a carbon date object from an input string
     *
     * @param string $str
     * @param string $format
     * @return Carbon\Carbon
     **/
    public function getFromInputString($str, $format = "j F, Y")
    {
        return Carbon::createFromFormat($format, $str, $this->getUserTimezone());
    }

    /**
     * Helper method to get the user if passed, or auth user
     *
     * @param App\User $user
     * @return App\User
     **/
    private function getUser(User $user = null)
    {
        return $user ?: $this->user;
    }

    /**
     * Takes a Carbon date object and converts to UTC timezone.
     *
     * @param Carbon\Carbon $dateTime
     * @return Carbon\Carbon
     **/
    public function toUTC(Carbon $dateTime)
    {
        $dateTime->timezone = 'UTC';

        return $dateTime;
    }
}
