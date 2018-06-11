<?php

namespace App;

class TicketType extends BaseModel
{

    public static function findWithPublicToken($public_token)
    {
        return self::where('id', $public_token)->firstOrFail();
    }

    public static function findWithTitle($title)
    {
        return self::where('name', $title)->firstOrFail();
    }

}