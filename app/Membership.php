<?php

namespace App;

class Membership extends BaseModel
{
    public static function findByUserId($user_id, $team_id)
    {
        return self::where('user_id', $user_id)->where('team_id', $team_id);
    }
}
