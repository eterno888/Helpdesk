@extends('layouts.app')
@section('content')
    <div class="description">
        <a href="{{ url()->previous() }}">Отделы</a>
    </div>
    <div class="comment description actions mb4">
        <h3>Новый отдел</h3>
    </div>
    {{ Form::open(["url" => route('teams.store')]) }}
    <table class="w50">
        <tr><td>{{ __("team.name") }}: </td><td><input class="w100" name="name"></td></tr>
        <tr><td>{{ __("team.email") }}:</td><td><input class="w100" name="email"></td></tr>
        <tr><td>{{ __("team.phone") }}:</td><td><input class="w100" name="phone"></td></tr>
        <tr><td colspan="2"> <button class="ph4 uppercase"> @busy {{ __('team.new') }}</button></td></tr>
    </table>
    {{ Form::close() }}

@endsection
