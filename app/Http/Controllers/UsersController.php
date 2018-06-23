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

        if ($assistant === null) $assistant = 0;
        if ($admin === null) $admin = 0;

        $user->update([
            'admin'     => $admin,
            'assistant' => $assistant
        ]);

        return redirect()->route('users.index');
    }
}
