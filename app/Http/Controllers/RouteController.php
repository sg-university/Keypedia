<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RouteController extends Controller
{

    public function __construct()
    {
    }

    public static function view($routeName, $data)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role->name == 'customer')
                return view('customer.' . $routeName, $data);
            else if ($user->role->name == 'manager')
                return view('manager.' . $routeName, $data);
        }

        return view('guest.' . $routeName, $data);
    }

    public static function rolesMainRedirection()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role->name == 'customer')
                return redirect()->route('customer.home.index');
            else if ($user->role->name == 'manager')
                return redirect()->route('manager.home.index');
        }

        return redirect()->route('guest.home.index');
    }
}
