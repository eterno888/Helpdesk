<?php

namespace App\Http\Controllers;

use App\User;
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

        if (request('team')) {
            $tickets = $tickets->where('tickets.team_id', request('team'));
        }

        $tickets = $tickets->select('tickets.*')->latest('updated_at');

        return view('tickets.index', ['tickets' => $tickets->paginate(25, ['tickets.user_id'])]);
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        return view('tickets.show', ['ticket' => $ticket]);
    }

    public function create()
    {
        $user = auth()->user();

        return view('tickets.create', ['user' => $user]);
    }

    public function store()
    {
        $requester_id = auth()->user()->id;

        $this->validate(request(), [
            'title'     => 'required|min:3',
            'body'      => 'required',
            'team_id'   => 'nullable|exists:teams,id',
        ]);
        $ticket = Ticket::createAndNotify($requester_id, request('title'), request('body'), request('tags'));
        $ticket->updateStatus(request('status'));

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
