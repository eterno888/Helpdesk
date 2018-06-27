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
        return back();
    }
}
