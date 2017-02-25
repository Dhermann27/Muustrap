<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function roleStore(Request $request)
    {
        $error = "";
        foreach (\App\Role::all() as $role) {
            if ($request->input($role->id . "-camperid") != '') {
                $user = \App\Camper::find($request->input($role->id . "-camperid"));
                if($user->user()->first() !== null) {
                    $user->user()->first()->roles()->attach($role->id);
                } else {
                    $error .= $user->firstname . " " . $user->lastname . " has not yet regisetered on muusa.org.<br />";
                }
            }
        }

        return $this->roleIndex('Real artists ship.', $error);
    }

    public function roleIndex($success = null, $error = null)
    {
        return view('admin.roles', ['roles' => \App\Role::with('users.camper')->get(),
            'success' => $success, 'error' => $error]);
    }

}
