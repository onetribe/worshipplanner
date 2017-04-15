<?php

namespace App\Mail;

use App\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTeamInvite extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var App\Team
     **/
    public $team;

    /**
     * @var App\Team
     **/
    public $invite_link;

    /**
     * Create a new message instance.
     *
     * @param App\Team $team
     * @param string $invite_link
     * @return void
     */
    public function __construct(Team $team, $invite_link)
    {
        $this->team = $team;
        $this->invite_link = $invite_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.team_invite')
            ->subject(trans('emails.team_invite_subject'))
            ->with([
                'team_name' => $this->team->title,
                'app_name' => trans('common.app_name'),
                'invite_link' => $this->invite_link,
            ]);
    }
}
