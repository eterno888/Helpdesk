<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as BaseTrimmer;

class TrimStrings extends BaseTrimmer
{
    /**
     * Имена атрибутов, которые нельзя обрезать.
     *
     * @var array
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];
}
