<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Этот контроллер обрабатывает аутентификацию пользователей и
    | перенаправляя их на главную страницу.
    |
    */

    use AuthenticatesUsers;

    /**
     * Куда перенаправлять пользователей после входа в систему.
     *
     * @var string
     */
    protected $redirectTo = '/tickets';

    protected $ad = array(                              // глобальная настройка сервера AD сотрудников
        'server' => 'dc.ugrasu.ru',                     // адрес AD сервера сотрудников
        'port' => '389',                                // порт AD сервера сотрудников
        'domain' => 'ugrasu.ru',                        // доменное имя AD сервера сотрудников
        'domain_short' => 'ugrasu',                     // короткое доменное имя AD сервера сотрудников
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

    //Функция настройки LDAP
    protected function ldap_auth($login, $password, $ad)
    {
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

    //Функция авторизации
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $responseLDAP = $this->ldap_auth($credentials['email'], $credentials['password'], $this->ad);

        if ($responseLDAP) {
            $user = User::where('email', $credentials['email'])->first();
            if (is_null($user)) {
                User::create([
                    'email' => $credentials['email'],
                    'password' => bcrypt($credentials['password']),
                    'locale' => 'ru',
                ]);
            }
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect('tickets');
            }
        } else {
            return redirect('login');
        }
    }
}
