<?php

namespace App;

use App\User;

class Rating extends BaseModel
{
    public static function findWithTicketId($ticket_id)
    {
        return self::where('ticket_id', $ticket_id);
    }

    public function tickets()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public static function ratingToUser(User $user){

        return Rating::join('tickets', 'ratings.ticket_id', '=', 'tickets.id')
            ->join('users', 'users.id', '=', 'tickets.user_id')
            ->select('ratings.rating')->where('tickets.user_id', $user->id)
            ->avg('rating');
    }
}