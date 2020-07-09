<?php

namespace App\Http\Controllers;

class PrivacyNoticeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = "Title";
        return view('privacynotice.index', ['data' => $data]);
    }
}
