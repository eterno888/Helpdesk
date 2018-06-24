<?php

namespace App\Http\Controllers;

use App\Rating;
use App\Ticket;
use App\User;


class StatisticsController extends Controller
{
    public function index()
    {
        $users = User::all();
        $ticket = Ticket::all();


        return view('reports.statistics', ['users' => $users], ['ticket' => $ticket]);
    }
}
