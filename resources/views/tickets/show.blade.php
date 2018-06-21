@extends('layouts.app')
@section('content')
    <div class="description comment">
        <div class="breadcrumb">
            <a href="{{ route('tickets.index') }}">{{ trans_choice('ticket.ticket', 2) }}</a>
        </div>
        <h3>#{{ $ticket->id }}. {{ $ticket->title }} </h3>
        @busy <span
                class="label ticket-status-{{ $ticket->statusName() }}">{{ __("ticket." . $ticket->statusName() ) }}</span>
        &nbsp;
        <span class="date">{{  $ticket->created_at->diffForHumans() }} · {{  $ticket->requester->name }}
            · {{$ticket->requester->phone}} · {{$ticket->requester->cabinet}}</span>

        @include('components.ticket.actions')
        <br>
        @include('components.ticket.merged')
    </div>


    @if( $ticket->canBeEdited() )
        @include('components.assignActions', ["endpoint" => "tickets", "object" => $ticket])
        <div class="comment new-comment">
            {{ Form::open(["url" => route("comments.store", $ticket) , "files" => true, "id" => "comment-form"]) }}
            <textarea name="body"></textarea>
            {{ Form::hidden('new_status', $ticket->status, ["id" => "new_status"]) }}
            @if($ticket->isEscalated() )
                <button class="mt1 uppercase ph3"> @icon(comment) {{ __('ticket.note') }} </button>
            @else
                <div class="mb1">
                    {{ __('ticket.note') }}: {{ Form::checkbox('private') }}
                </div>
                <button class="mt1 uppercase ph3"> @icon(comment) {{ __('ticket.comment') }} </button>
                <span class="dropdown button caret-down"> @icon(caret-down) </span>
                <ul class="dropdown-container">
                    <li><a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_OPEN    }} )">
                            <div style="width:10px; height:10px"
                                 class="circle inline ticket-status-open mr1"></div> {{ __('ticket.commentAs') }}
                            <b>{{ __("ticket.open") }}   </b> </a></li>
                    <li><a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_PENDING }} )">
                            <div style="width:10px; height:10px"
                                 class="circle inline ticket-status-pending mr1"></div> {{ __('ticket.commentAs') }}
                            <b>{{ __("ticket.pending") }}</b> </a></li>
                    <li><a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_SOLVED  }} )">
                            <div style="width:10px; height:10px"
                                 class="circle inline ticket-status-solved mr1"></div> {{ __('ticket.commentAs') }}
                            <b>{{ __("ticket.solved") }} </b> </a></li>
                    <li><a class="pointer" onClick="setStatusAndSubmit( {{ App\Ticket::STATUS_CLOSED  }} )">
                            <div style="width:10px; height:10px"
                                 class="circle inline ticket-status-closed mr1"></div> {{ __('ticket.commentAs') }}
                            <b>{{ __("ticket.closed") }} </b> </a></li>
                </ul>
            @endif
            {{ Form::close() }}
        </div>
    @endif

    @include('components.ticketComments', ["comments" => $ticket->commentsAndNotesAndEvents()->sortBy('created_at')->reverse() ])
@endsection


@section('scripts')
    {{--}}@include('components.js.taggableInput', ["el" => "tags", "endpoint" => "tickets", "object" => $ticket])--}}
    <script>
        function setStatusAndSubmit(new_status) {
            $("#new_status").val(new_status);
            $("#comment-form").submit();
        }
    </script>
@endsection