<?php

namespace App\Http\Controllers;

class AuthLdapController extends Controller
{
    protected $ad = array(                   // глобальная настройка сервера AD сотрудников
        'server'       => 'dc.ugrasu.ru',    // адрес AD сервера сотрудников
        'port'         => '389',             // порт AD сервера сотрудников
        'domain'       => 'ugrasu.ru',       // доменное имя AD сервера сотрудников
        'domain_short' => 'ugrasu',          // короткое доменное имя AD сервера сотрудников
        'search'       => 'OU=Университет, DC=ugrasu, DC=ru');// запрос фамилии из домена сотрудников

    public function ldap_auth($login, $password, $ad)
    {
        require("settings.php");

        $ldap = ldap_connect($ad['server'], $ad['port']);
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3); //Включаем LDAP протокол версии 3
        if ($ldap) {
            $bind = @ldap_bind($ldap, $login, $password);
            if ($bind) {
                return true;
            } else
                return false;
        } else
            return false;
    }
}