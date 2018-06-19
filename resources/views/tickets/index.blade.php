@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Заявки ( {{ $tickets->count() }} )</h3>
    </div>

    <div class="m4">
        <a class="button" href="{{ route("tickets.choice") }}"> @icon(plus) {{ __('ticket.newTicket') }}</a>
        @if(auth()->user()->admin or auth()->user()->assistant)
            <a class="button secondary" id="mergeButton" onclick="onMergePressed()"> {{ __('ticket.merge') }}</a>
        @endif
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

@section('scripts')
    @include('components.js.merge')
    <script>
        $("#searcher").searcher('tickets/search/');
    </script>
@endsection
