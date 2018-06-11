<div class="ticketEvent p1 mb1">
    <div class="date">
        {{--@icon(dot-circle-o)--}}
        {{ $event->author()->name }}
        ·
        {!! $event->body !!}
        ·
        {{ $event->created_at->diffForHumans() }}
    </div>
</div>