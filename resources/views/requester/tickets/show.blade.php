@extends('layouts.app')
@section('content')
    <div class="description comment">
        <h3>{{ $ticket->title }}</h3>
        <span class="label ticket-status-{{ $ticket->statusName() }}">{{ __('ticket.' . $ticket->statusName()) }}</span>&nbsp;
        <span class="date">{{  $ticket->created_at->diffForHumans() }} · {{  $ticket->requester->name }}</span>
    </div>

    @if($ticket->status != App\Ticket::STATUS_CLOSED)
        <div class="comment new-comment">
            {{ Form::open(["url" => route("requester.comments.store",$ticket->public_token)]) }}
            <textarea name="body"></textarea>
            <br>
            @if($ticket->status == App\Ticket::STATUS_SOLVED)
                Открыть заново? {{ Form::checkbox('reopen') }}
            @else
                {{ __('ticket.isSolvedQuestion') }} {{ Form::checkbox('solved') }}
            @endif
            <br><br>
            <button class="uppercase ph3"> @busy @icon(comment) {{ __('ticket.comment') }}</button>
            {{ Form::close() }}
            @endif
            @if($ticket->status == App\Ticket::STATUS_SOLVED)
                <br>
                @if(!App\Rating::where('ticket_id', $ticket->id)->exists())
                    {{Form::open(["url" => route("ticket.rating", $ticket)])}}
                    Оцените работу исполнителя от 1 до 5:
                    {{Form::number('rating', null, ['min' =>1, 'max'=>5])}}
                    <button class="uppercase ph3"> @busy Оценить</button>
                    {{Form::close()}}
                @endif
        </div>
    @endif
    @include('components.ticketComments', ["comments" => $ticket->comments])
@endsection

