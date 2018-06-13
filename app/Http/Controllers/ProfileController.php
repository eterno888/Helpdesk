<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => auth()->user()]);
    }

   public function update(Request $request)
    {
        $user = auth()->user();

        $f_json = 'http://api.ugrasu.ru/api.php?view=contacts';
        $json = file_get_contents("$f_json");
        $obj = json_decode($json,true);
        $searchEmail = $user->email;
        foreach ($obj as $item)
        {
            if($item['EMAIL'] == $searchEmail) {
                $user->update([
                    'name'          => $item['FIO'],
                    'locale'        => $request->get('locale'),
                    'cabinet'       => $item['KORP'],
                    'phone'         => $item['PHONE'],
                    'position'      => $item['DOL'],
                    'subdivision'   => $item['PATH'],
                    'lead'          => $request->get('lead'),
                ]);
            }
        }

        $user->settings()->updateOrCreate([], $request->only('tickets_signature') + $this->notificationSettings($request));

        return back();
    }

    public function password(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'old'      => 'old_password:'.$user->password,
            'password' => 'confirmed|min:5',
        ]);

        $user->update(['password' => bcrypt($request->get('password'))]);

        return back();
    }

    private function notificationSettings(Request $request)
    {
        return [
            'new_ticket_notification'      => $request->filled('new_ticket_notification'),
            'ticket_assigned_notification' => $request->filled('ticket_assigned_notification'),
            'ticket_updated_notification'  => $request->filled('ticket_updated_notification'),
            'new_lead_notification'        => $request->filled('new_lead_notification'),
            'lead_assigned_notification'   => $request->filled('lead_assigned_notification'),
            'daily_tasks_notification'     => $request->filled('daily_tasks_notification'),
        ];
    }
}
