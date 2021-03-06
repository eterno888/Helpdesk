@extends('auth.layout')

@section('content')
    <div class="center text-center mt5" style="max-width:300px">
        <img src="{{url("images/handesk_full.png")}}" class="w80">
        <form class="form-horizontal" method="POST" action="{{ route('ldap_auth') }}">
            {{ csrf_field() }}

            <div class="m3">
                <input id="login" type="login" class="w80" name="login" value="{{ old('login') }}" required autofocus>
                @if ($errors->has('login'))
                    <br>
                    <span class="help-block">
                            <strong>{{ $errors->first('login') }}</strong>
                        </span>
                @endif
            </div>

            <div class="m3">
                <input id="password" type="password" class="w80" name="password" required>
                @if ($errors->has('password'))
                    <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                @endif
            </div>
            <div class="mh3 mb2">
                <button type="submit" class="uppercase ph5 w80">Войти</button>
            </div>
            <div class="mb3">
                <input type="checkbox" class="" name="remember" {{ old('remember') ? 'checked' : '' }}>
                Запомнить меня
            </div>

            <div>
                <a class="btn btn-link" href="{{ route('password.request') }}"> Забыли пароль? </a>
            </div>
        </form>
    </div>
@endsection