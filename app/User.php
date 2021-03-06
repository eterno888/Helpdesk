<?php

namespace App;

use Carbon\Carbon;
use App\Authenticatable\Admin;
use App\Authenticatable\Assistant;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string name
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = ['admin', 'assistant'];
    //protected $guarded = ['admin', 'assistant'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'requester_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class)->with('user', 'team');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'memberships')->withPivot('admin');
    }

    public function teamsTickets()
    {
        return Ticket::join('memberships', 'tickets.team_id', '=', 'memberships.team_id')
                       ->where('memberships.user_id', $this->id)->select('tickets.*');
        //return $this->belongsToMany(Ticket::class, "memberships", "team_id", "team_id");
        //return $this->hasManyThrough(Ticket::class, Membership::class,"user_id","team_id")->with('requester','user','team');
    }


    /**
     * @deprecated
     *
     * @param $notification
     */
    public static function notifyAdmins($notification)
    {
        Admin::notifyAll($notification);
    }

    /**
     * @deprecated
     *
     * @param $notification
     */
    public static function notifyAssistants($notification)
    {
        Assistant::notifyAll($notification);
    }

    public function getTeamsTicketsAttribute()
    {
        return $this->teamsTickets()->get();
    }

    public function delete()
    {
        $this->tickets()->update(['user_id' => null]);

        return parent::delete();
    }
}
