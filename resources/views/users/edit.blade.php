@extends('layouts.app')
@section('content')
    <div class="description">
        <div class="breadcrumb">
            <a href="{{ url()->previous() }}">Сотрудники</a>
        </div>
    </div>

    <div class="description actions comment mb4">
        <div class="float-left ml4 mt-2  circle">@gravatar($user->name, 90)</div>
        <h3 class="ml4 float-left"> {{ $user->name }}</h3>
    </div>

    <div class="clear-both"></div>

    <div class="description mt4">
        {{ Form::open(["url" => route('users.update',$user), "method" => "PUT"]) }}
        <table class="maxw600">
            <tr>
                <td colspan="2"> Назначить пользователя исполнителем</td>
                {{ Form::open(["url" => route('membership.store'), "method" => "PUT"]) }}
                @include('components.assignTeamField')
                <button class="uppercase fs2 p3 mv3">@busy Назначить</button>
                {{ Form::close() }}
            </tr>
        </table>
        {{ Form::close() }}
    </div>
@endsection
