@extends('layouts.app')
@section('content')
    <div class="description comment">
        <div class="breadcrumb">
            <a href="{{ url()->previous() }}">{{ trans_choice('ticket.ticket', 2) }}</a>
        </div>
    </div>
    <div class="m4">
    <a class="button " href="{{ route("tickets.create") }}">@icon(plus) {{ __('ticket.newTicket') }}</a>
        <br>
        <br>
    <a class="button " href="{{ route("tickets.create") }}">@icon(plus) {{ __('ticket.newTicket') }}</a>
        <br>
        <br>
    <a class="button " href="{{ route("tickets.create") }}">@icon(plus) {{ __('ticket.newTicket') }}</a>
        <br>
        <br>
    <a class="button " href="{{ route("tickets.create") }}">@icon(plus) {{ __('ticket.newTicket') }}</a>
        <br>
        <br>
    <a class="button " href="{{ route("tickets.create") }}">@icon(plus) {{ __('ticket.newTicket') }}</a>
        <br>
        <br>
    <a class="button " href="{{ route("tickets.create") }}">@icon(plus) {{ __('ticket.newTicket') }}</a>
    </div>

@endsection