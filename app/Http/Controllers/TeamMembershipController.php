<?php

namespace App\Http\Controllers;

use App\Membership;
use App\Team;
use App\User;
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

    public function destroy(User $user)
    {
        $membership = Membership::findByUserId($user->id);
        $membership->delete();

        return back();
    }
}
