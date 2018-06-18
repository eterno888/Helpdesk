<tr>
        <td>
                <input type="checkbox" name="selected[{{$ticket->id}}]" meta:index="{{$ticket->id}}" class="hidden selector">
                <span class="label ticket-status-{{ $ticket->statusName() }}">{{ str_limit(__('ticket.' . $ticket->statusName()), 1, '') }}</span>&nbsp;
                @if( $ticket->isEscalated() ) @icon(flag) @endif
                @if(!auth()->user()->admin and !auth()->user()->assistant)
                        <a href="{{route('requester.tickets.show',$ticket->public_token)}}">{{  str_limit($ticket->title, 40) }}</a>
                @else
                <a href="{{ route('tickets.show', $ticket) }}"> {{  str_limit($ticket->title, 40) }}</a>
                        @endif
        </td>
        <td> {{ nameOrDash( $ticket->requester )    }}</td>
        <td> {{ nameOrDash( $ticket->team )         }}</td>
        <td> {{ nameOrDash( $ticket->user )         }}</td>
        <td class="hide-mobile"> {{ $ticket->created_at->diffForHumans()}}</td>
        <td class="hide-mobile"> {{ $ticket->updated_at->diffForHumans()}}</td>
</tr>