@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Заявки ( {{ $tickets->count() }} )</h3>
    </div>

    <div class="m4">
        <a class="button" href="{{ route("tickets.choice") }}"> @icon(plus) {{ __('ticket.newTicket') }}</a>
    </div>

    <div class="float-right mt-5 mr4">
        <input id="searcher" placeholder="{{__('ticket.search')}}" class="ml2">
        <div class="inline ml-4">@icon(search)</div>
    </div>

    <div id="results"></div>
    <div id="all">
        @paginator($tickets)
        @include('tickets.indexTable')
        @paginator($tickets)
    </div>
@endsection

