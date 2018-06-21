<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class Team extends BaseModel
{
    use Notifiable;

    public static function findById($team_id)
    {
        return self::where('team_id', $team_id)->firstOrFail();
    }

    public static function findByToken($token)
    {
        return self::where('token', $token)->firstOrFail();
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'memberships')->withPivot('admin');
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function openTickets()
    {
        return $this->tickets()->where('status', '<', Ticket::STATUS_SOLVED);
    }

    public function solvedTickets()
    {
        return $this->tickets()->where('status', '=', Ticket::STATUS_SOLVED);
    }

    public function closedTickets()
    {
        return $this->tickets()->where('status', '=', Ticket::STATUS_CLOSED);
    }

    public function routeNotificationForSlack($full = false)
    {
        if ($full) {
            return $this->slack_webhook_url;
        }
        if ($this->slack_webhook_url) {
            return explode('?', $this->slack_webhook_url)[0];
        }

        return null;
    }

    public static function membersByTeam()
    {
        return [__('team.none') => [null => '--']] + self::all()->mapWithKeys(function ($team) {
                return [$team->name => $team->members->pluck('name', 'id')->toArray()];
            })->toArray();
    }
}
