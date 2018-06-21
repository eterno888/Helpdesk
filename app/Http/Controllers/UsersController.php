<?php

namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with('teams')->paginate(25);

        return view('users.index', ['users' => $users]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }

    public function impersonate(User $user)
    {
        auth()->loginUsingId($user->id);

        return redirect()->route('tickets.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function membership(Request $request, $user)
    {
        $team_id = $request->get('team_id');
        /*$team = Team::findById($team_id);

           if (! $team->members->contains(auth()->user())) {
               $team->members()->attach(auth()->user());
           }*/

        Membership::create([
            'user_id'           => $user->id,
            'team_id'           => $team_id]);

        return redirect()->route('users.index');
    }

    /*public function update(User $user)
    {
        $user->update([
            'name'              => request('name'),
        ]);

        return redirect()->route('user.index');
    }*/
}
