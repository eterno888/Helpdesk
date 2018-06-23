@extends('layouts.app')
@section('content')
    <div class="description comment">
        <div class="breadcrumb">
            <a href="{{ url()->previous() }}">{{ trans_choice('ticket.ticket', 2) }}</a>
        </div>
    </div>

    <div class="m4">
        @foreach($ticketTypes as $ticketType)
            <a class="button" href="{{ route('tickets.create', $ticketType) }}"> {{ $ticketType->name }} </a> <br><br>
        @endforeach

        @include('components.news.show')
    </div>
@endsection