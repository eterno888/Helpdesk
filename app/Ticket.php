<?php

namespace App;

use Carbon\Carbon;
use App\Authenticatable\Admin;
use App\Events\TicketCommented;
use App\Notifications\NewComment;
use App\Authenticatable\Assistant;
use App\Events\TicketStatusUpdated;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketEscalated;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends BaseModel
{
    use SoftDeletes, Taggable, Assignable, Subscribable;

    const STATUS_NEW     = 1;
    const STATUS_OPEN    = 2;
    const STATUS_PENDING = 3;
    const STATUS_SOLVED  = 4;
    const STATUS_CLOSED  = 5;
    const STATUS_MERGED  = 6;
    const STATUS_SPAM    = 7;

    const PRIORITY_LOW    = 1;
    const PRIORITY_NORMAL = 2;
    const PRIORITY_HIGH   = 3;

    public static function createAndNotify($requester_id, $title, $body)
    {

        $ticket_type_id = TicketType::findWithTitle($title)->id;
        if ($ticket_type_id === 1)
            $team_id = null;
        if ($ticket_type_id === 2)
            $team_id = 1;
        if ($ticket_type_id === 3)
            $team_id = 1;
        if ($ticket_type_id === 4)
            $team_id = 1;
        if ($ticket_type_id === 5)
            $team_id = 2;
        if ($ticket_type_id === 6)
            $team_id = 1;

        $ticket = Ticket::create([
            'requester_id'   => $requester_id,
            'title'          => $title,
            'body'           => $body,
            'public_token'   => str_random(24),
            'team_id'        => $team_id
        ]);

        return $ticket;
    }

    public function requester()
    {
        return $this->belongsTo(User::class);
    }

    public static function findWithPublicToken($public_token)
    {
        return self::where('public_token', $public_token)->firstOrFail();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function comments()
    {
        return $this->commentsAndNotes()->where('private', false);
    }

    public function commentsAndNotes()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function commentsAndNotesAndEvents()
    {
        return $this->commentsAndNotes->toBase()->merge($this->events);
    }

    public function events()
    {
        return $this->hasMany(TicketEvent::class)->latest();
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function mergedTickets()
    {
        return $this->belongsToMany(self::class, 'merged_tickets', 'ticket_id', 'merged_ticket_id');
    }

    /**
     * @param $user
     * @param $newStatus
     *
     * @return mixed
     */
    private function updateStatusFromComment($user, $newStatus)
    {
        $previousStatus = $this->status;
        if ($newStatus && $newStatus != $previousStatus) {
            $this->updateStatus($newStatus);
        } elseif (! $user && $this->status != static::STATUS_NEW) {
            $this->updateStatus(static::STATUS_OPEN);
        } else {
            $this->touch();
        }
        event(new TicketStatusUpdated($this, $user, $previousStatus));

        return $previousStatus;
    }

    private function associateUserIfNecessary($user)
    {
        if (! $this->user && $user) {
            $this->user()->associate($user)->save();
        }
    }

    protected function getAssignedNotification()
    {
        return new TicketAssigned($this);
    }

    public function addComment($user, $body, $newStatus = null)
    {
        if ($user && $this->isEscalated()) {
            return $this->addNote($user, $body);
        }
        $previousStatus = $this->updateStatusFromComment($user, $newStatus);
        $this->associateUserIfNecessary($user);
        if (! $body) {
            return;
        }

        $comment = $this->comments()->create([
            'body'       => $body,
            'user_id'    => $user ? $user->id : null,
            'new_status' => $newStatus ?: $this->status,
        ]);
        event(new TicketCommented($this, $comment, $previousStatus));

        return $comment;
    }

    public function addNote($user, $body)
    {
        if (! $body) {
            return;
        }
        else {
            $this->touch();
        }
        $comment = $this->comments()->create([
            'body'       => $body,
            'user_id'    => $user->id,
            'new_status' => $this->status,
            'private'    => true,
        ]);

        return $comment;
    }

    public function merge($user, $tickets)
    {
        collect($tickets)->map(function ($ticket) {
            return is_numeric($ticket) ? Ticket::find($ticket) : $ticket;
        })->reject(function ($ticket) {
            return $ticket->id == $this->id || $ticket->status > Ticket::STATUS_SOLVED;
        })->each(function ($ticket) use ($user) {
            $ticket->addNote($user, "Объединена с #{$this->id}");
            $ticket->updateStatus(Ticket::STATUS_MERGED);
            $this->mergedTickets()->attach($ticket);
        });
    }

    public function updateStatus($status)
    {
        $this->update(['status' => $status, 'updated_at' => Carbon::now()]);
        if ($this->statusName() === 'new'){
            $statusName = 'новая заявка';
        }
        if ($this->statusName() === 'pending'){
            $statusName = 'заявка ожидает';
        }
        else {
            $statusName = 'заявка решена';
        }
        TicketEvent::make($this, 'Статус обновлен: '.$statusName);
    }

    public function setLevel($level)
    {
        $this->update(['level' => $level]);
        if ($level == 1) {
            TicketEvent::make($this, 'Срочная заявка');
        }

        TicketEvent::make($this, 'Срочность снята');
    }

    public function isEscalated()
    {
        return $this->level == 1;
    }

    public function hasBeenReplied()
    {
        return $this->comments()->whereNotNull('user_id')->count() > 1;
    }

    public function scopeOpen($query)
    {
        return $query->where('status', '<', self::STATUS_SOLVED);
    }

    public function scopeSolved($query)
    {
        return $query->where('status', '>=', self::STATUS_SOLVED);
    }

    public function canBeEdited()
    {
        return ! in_array($this->status, [self::STATUS_CLOSED, self::STATUS_MERGED]);
    }

    public function statusName()
    {
        switch ($this->status) {
            case static::STATUS_NEW: return 'new';
            case static::STATUS_OPEN: return 'open';
            case static::STATUS_PENDING: return 'pending';
            case static::STATUS_SOLVED: return 'solved';
            case static::STATUS_CLOSED: return 'closed';
            case static::STATUS_MERGED: return 'merged';
            case static::STATUS_SPAM: return 'spam';
        }
    }

    public function getSubscribableEmail()
    {
        return $this->requester->email;
    }

    public function getSubscribableName()
    {
        return $this->requester->name;
    }
}