<?php

namespace App\Http\Controllers;

use App\Team;
use http\Env\Request;

class TeamMembershipController extends Controller
{
    public function index($token)
    {
        $team = Team::findByToken($token);

        return view('teams.join', ['team' => $team]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'team_id'  => $team_id,
            'password' => 'confirmed|min:5',
        ]);

        $token = $request;
        $team = Team::findByToken($token);
        if (! $team->members->contains(auth()->user())) {
            $team->members()->attach(auth()->user());
        }

        return redirect()->route('tickets.index');
    }
}
