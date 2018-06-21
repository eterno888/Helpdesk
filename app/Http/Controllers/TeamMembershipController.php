<?php

namespace App\Http\Controllers;

use App\Membership;
use App\Team;
use http\Env\Request;
use App\User;

class TeamMembershipController extends Controller
{
    public function index(User $user)
    {
        return view('users.membership', ['user' => $user]);
    }

    /*public function index($token)
    {
        $team = Team::findById($token);

        return view('teams.join', ['team' => $team]);
    }*/

    public function store(User $user)
    {
        dd(1);
        //$team_id = $request->get('team_id');
        //$team = Team::findById($team_id);

     /*   if (! $team->members->contains(auth()->user())) {
            $team->members()->attach(auth()->user());
        }*/

        Membership::create([
            'user_id'           => $user->id,
            'team_id'           => 1]);

        return redirect()->route('users.index');
    }
}
