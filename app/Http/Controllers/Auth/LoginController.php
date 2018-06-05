<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Этот контроллер обрабатывает аутентификацию пользователей для приложения и
    | перенаправляя их на главный экран. Контроллер использует trait,
    | чтобы удобно предоставлять свои функции вашим приложениям.
    |
    */

    use AuthenticatesUsers;

    /**
     * Куда перенаправлять пользователей после входа в систему.
     *
     * @var string
     */
    protected $redirectTo = '/tickets';

    protected $ad = array( // глобальная настройка сервера AD сотрудников
    'server' => 'dc.ugrasu.ru', // адрес AD сервера сотрудников
    'port' => '389', // порт AD сервера сотрудников
    'domain' => 'ugrasu.ru', // доменное имя AD сервера сотрудников
    'domain_short' => 'ugrasu', // короткое доменное имя AD сервера сотрудников
    'search' => 'OU=Университет, DC=ugrasu, DC=ru');// запрос фамилии из домена сотрудников

    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function ldap_auth($login, $password, $ad){
        require("settings.php");

        $ldap = ldap_connect($ad['server'], $ad['port']);
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3); //Включаем LDAP протокол версии 3
        if ($ldap){
            $bind = @ldap_bind($ldap, $login, $password);
            if ($bind){
                return true;
            }
            else
                return false;
        }
        else
            return false;
    }
}
