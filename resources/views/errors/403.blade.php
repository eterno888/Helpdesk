@extends('layouts.app')
@section('content')
    <div class="center w80 text-center mt5" style="margin-top:100px">
        {{--<img src="{{url("images/not_found.png")}}">--}}
        <h1>403</h1>
        <img src="{{url("images/locked_helpdesk.png")}}">
        <p>Простите, но вы не имеете доступ к этому ресурсу</p>
    </div>
@endsection