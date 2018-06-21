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
        <table class="maxw600">
            <tr>
                <td colspan="2"> Назначить пользователя исполнителем</td>
            </tr>

            {{ Form::open(["url" => route('users.membership.store', $user)]) }}

            @php if (! isset($team)) $team = new App\Team; @endphp
            <tr>
                <td>{{ trans_choice('team.team',1) }}:</td>
                <td>{{ Form::select('team_id', createSelectArray( App\Team::all(), true), $team->id) }}</td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button class="uppercase ph3 ml1">@busy Назначить</button>
                </td>
            </tr>
            {{ Form::close() }}
        </table>
        {{ Form::close() }}
    </div>
@endsection