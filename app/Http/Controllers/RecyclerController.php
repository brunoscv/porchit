<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppUsers;

class RecyclerController extends Controller
{
    public function index(AppUsers $model)
    {
        $app_users = AppUsers::all();
        return view('recycler.index', compact('app_users'));
    }
}
