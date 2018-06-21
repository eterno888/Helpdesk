<?php

namespace App\Http\Controllers;

use App\TicketType;
use App\News;
use Carbon\Carbon;
use App\Ticket;
use App\Repositories\TicketsRepository;

class TicketsController extends Controller
{
    public function index(TicketsRepository $repository)
    {

        Carbon::setLocale('ru');

        if (request('assigned')) {
            $tickets = $repository->assignedToMe();
        } elseif (request('unassigned')) {
            $tickets = $repository->unassigned();
        } elseif (request('recent')) {
            $tickets = $repository->recentlyUpdated();
        } elseif (request('solved')) {
            $tickets = $repository->solved();
        } elseif (request('closed')) {
            $tickets = $repository->closed();
        } elseif (request('escalated')) {
            $tickets = $repository->escalated();
        } else {
            $tickets = $repository->all();
        }

        if (request('sent')){
            $tickets = $repository->sentByMe();
        }

        if (request('team')) {
            $tickets = $tickets->where('tickets.team_id', request('team'));
        }

        $tickets = $tickets->select('tickets.*')->latest('updated_at');

        return view('tickets.index', ['tickets' => $tickets->paginate(25, ['tickets.user_id'])]);
    }

    public function show(Ticket $ticket)
    {
        Carbon::setLocale('ru');
        $this->authorize('view', $ticket);

        return view('tickets.show', ['ticket' => $ticket]);
    }

    public function create($public_token)
    {
        $ticketType = TicketType::findWithPublicToken($public_token);

        $user = auth()->user();

        return view('tickets.create', ['user' => $user], ['ticketType' => $ticketType]);
    }

    public function choice()
    {
        $news = News::all();
        $ticketTypes = TicketType::all();

        return view('tickets.choice', ['ticketTypes' => $ticketTypes, 'news' => $news]);
    }

    public function store()
    {
        $requester_id = auth()->user()->id;

        $this->validate(request(), [
            'title'     => 'required|min:3',
            'body'      => 'required',
            'team_id'   => 'nullable|exists:teams,id',
        ]);

        $glue = '; ';
        $body = implode($glue, request('body'));

        $ticket = Ticket::createAndNotify($requester_id, request('title'), $body, request('tags'));
        $ticket->updateStatus(Ticket::STATUS_NEW);

        if (request('team_id')) {
            $ticket->assignToTeam(request('team_id'));
        }

        return redirect()->route('tickets.index');
        //return redirect()->route('tickets.show', $ticket);
    }

    public function reopen(Ticket $ticket)
    {
        $ticket->updateStatus(Ticket::STATUS_OPEN);

        return back();
    }


}
