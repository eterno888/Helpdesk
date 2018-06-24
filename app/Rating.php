<?php

namespace App;

class Rating extends BaseModel
{
    public static function findWithTicketId($ticket_id)
    {
        return self::where('ticket_id', $ticket_id);
    }

}