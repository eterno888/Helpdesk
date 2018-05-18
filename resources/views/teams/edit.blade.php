@extends('layouts.app')
@section('content')
    <div class="description">
        <div class="breadcrumb">
            <a href="{{ url()->previous() }}">Отделы</a>
        </div>
    </div>

    <div class="description actions comment mb4">
        <div class="float-left ml4 mt-2  circle">@gravatar($team->email, 90)</div>
        <h3 class="ml4 float-left"> {{ $team->name }}</h3>
    </div>

    <div class="clear-both"></div>

    <div class="description mt4">
        {{ Form::open(["url" => route('teams.update',$team), "method" => "PUT"]) }}
        <table class="maxw600">
            <tr><td>{{ __("team.name") }}: </td><td class="w60"><input class="w100" name="name"  value="{{$team->name}}" ></td></tr>
            <tr><td>{{ __("team.email") }}:</td><td class="w60"><input class="w100" name="email" value="{{$team->email}}"></td></tr>
            <tr><td>{{ __("team.phone") }}:</td><td class="w60"><input class="w100" name="phone" value="{{$team->phone}}"></td></tr>
            <tr><td><button class="ph4 uppercase">@busy {{ __('ticket.update') }}</button></td>
                <td><button class="ph4 uppercase">@busy {{ __('team.remove') }}</button></td></tr>
        </table>
        {{ Form::close() }}
    </div>
@endsection
