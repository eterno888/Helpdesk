<?php

namespace App\Http\Controllers;

use App\Repositories\TicketsRepository;

class UsersSearchController extends Controller
{
    public function index(TicketsRepository $repository, $text)
    {
        return view('tickets.indexTable', ['tickets' => $repository->search($text)->latest()->get()]);
    }
}
