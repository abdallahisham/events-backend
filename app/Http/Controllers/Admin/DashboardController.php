<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $eventsCount = Event::count();
        $featuredEventsCount = Event::featured()->count();
        $usersCount = User::count();
        $eventTypesCount = 12;
        return view('admin.dashboard', compact(
            'eventsCount',
            'featuredEventsCount',
            'usersCount',
            'eventTypesCount'
        ));
    }

    public function getChangePassword()
    {
        return view('admin.change_password');
    }

    public function postChangePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (Hash::check(request('old_password'), Auth::user()->password)) {
            Auth::user()->password = Hash::make(request('new_password'));
            Auth::user()->save();

            flash(__('general.Your password changed successfully'))->success();
        } else {
            flash(__('general.Old password is wrong'))->error();
        }
        return back();
    }
}
