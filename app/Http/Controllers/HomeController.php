<?php

namespace App\Http\Controllers;

use App\Pickups;
use App\AppUsers;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $pickups = Pickups::count();
        $users = User::count();
        $recyclers = AppUsers::count();
        return view('dashboard', ['pickups' => $pickups, 'users' => $users,  'recyclers' => $recyclers]);
    }
}
