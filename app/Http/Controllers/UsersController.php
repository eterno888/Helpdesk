<?php

namespace App\Http\Controllers;

use App\Membership;
use App\User;
use App\Team;

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

    /*public function update(User $user)
    {
        $user->update([
            'name'              => request('name'),
        ]);

        return redirect()->route('user.index');
    }*/

    public function role(User $user)
    {
        $assistant = request('assistant');
        $admin = request('admin');
        $team_id = request('team_id');

        if ($assistant === null) $assistant = 0;
        if ($admin === null) $admin = 0;

        $user->update([
            'admin' => $admin,
            'assistant' => $assistant
        ]);

        if (($assistant == 1) and (!$team_id == null)) {

            Membership::firstOrCreate([
                'user_id' => $user->id,
                'team_id' => $team_id,
                'admin' => 0
            ]);
        }
            return redirect()->route('users.index');
        }
    }
