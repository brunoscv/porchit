<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDO;
use App\AppUsers;

class DriversController extends Controller
{
    public function index() {

        $drivers = AppUsers::where(["device" => "drive"])->get();
        return view('drivers.index', ['drivers' => $drivers] );
    }

    public function activedriver(Request $request, $id) {

        $driver = AppUsers::find($id);

        if($driver["status"] == "1") {
            $update_driver = DB::update("UPDATE app_users SET status = '0' WHERE id='$id'");
        } else {
            $update_driver = DB::update("UPDATE app_users SET status = '1' WHERE id='$id'");
        }
       
        $active = [
            'success' => true
        ];
        
        $result = json_encode($active);
        return $active;
    }
}
