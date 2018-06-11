<tr>
        <td>
                <input type="checkbox" name="selected[{{$ticket->id}}]" meta:index="{{$ticket->id}}" class="hidden selector">
                <span class="label ticket-status-{{ $ticket->statusName() }}">{{ str_limit(__('ticket.' . $ticket->statusName()), 1, '') }}</span>&nbsp;
                @if( $ticket->isEscalated() ) @icon(flag) @endif
                <a href="{{ route('tickets.show', $ticket) }}"> {{  str_limit($ticket->title, 40) }}</a>
        </td>
        <td> {{ nameOrDash( $ticket->requester )    }}</td>
        <td> {{ nameOrDash( $ticket->team )         }}</td>
        <td> {{ nameOrDash( $ticket->user )         }}</td>
        <td class="hide-mobile"> {{ $ticket->created_at->diffForHumans()}}</td>
        <td class="hide-mobile"> {{ $ticket->updated_at->diffForHumans()}}</td>
</tr>