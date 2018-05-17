<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

class EncryptCookies extends BaseEncrypter
{
    /**
     * Имена файлов cookie, которые не должны быть зашифрованы.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
