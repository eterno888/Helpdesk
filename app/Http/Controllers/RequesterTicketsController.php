<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Rating;

class RequesterTicketsController extends Controller
{
    public function show($public_token)
    {
        $ticket = Ticket::findWithPublicToken($public_token);

        return view('requester.tickets.show', ['ticket' => $ticket]);
    }

    public function rating(Ticket $ticket)
    {
        $user = auth()->user();

        Rating::updateOrCreate([
            'requester_id' => $user->id,
            'ticket_id' => $ticket->id,
            'rating' => request('rating')
        ]);

        return back();
    }
}
