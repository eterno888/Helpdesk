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
        {{ Form::open(["url" => route('users.role', $user), "method" => "PUT"]) }}

        <p> Назначить пользователя исполнителем {{Form::checkbox('assistant', 1, $user->assistant)}}</p>
        <p>Отдела:
            @php if (! isset($team)) $team = new App\Team; @endphp
            {{ Form::select('team_id', createSelectArray( App\Team::all(), true), $team->id) }}</p>

        <p> Назначить пользователя администратором {{Form::checkbox('admin', 1, $user->admin)}}</p>

        <button class="uppercase ph3">@busy Назначить</button>
        {{ Form::close() }}
    </div>
@endsection
