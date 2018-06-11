<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class News extends BaseModel
{
    use Notifiable;

    public function display($news)
    {
        collect($tickets)->map(function ($ticket) {
            return is_numeric($ticket) ? Ticket::find($ticket) : $ticket;
        })->reject(function ($ticket) {
            return $ticket->id == $this->id || $ticket->status > Ticket::STATUS_SOLVED;
        })->each(function ($ticket) use ($user) {
            $ticket->addNote($user, "Объединена с #{$this->id}");
            $ticket->updateStatus(Ticket::STATUS_MERGED);
            $this->mergedTickets()->attach($ticket);
        });
    }

}