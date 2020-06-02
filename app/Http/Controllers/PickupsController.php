<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Pickups;
use DB;
use PDO;

class PickupsController extends Controller
{
    public function index() {

        $pickups = DB::table('pickups')
        ->leftJoin('app_users', 'app_users.id', '=', 'pickups.users_id')
        ->leftJoin('pickups_products', 'pickups.id', '=', 'pickups_products.pickups_id')
        ->select(DB::raw('COUNT(pickups_products.pickups_id) AS products'),'pickups.id', 'app_users.firstname', 'app_users.lastname', 'pickups.date_pickup', 'pickups.pickup_at', 'pickups.status', 'pickups.created_at')
        ->groupBy('pickups.id', 'app_users.firstname', 'app_users.lastname', 'pickups.date_pickup', 'pickups.pickup_at', 'pickups.status', 'pickups.created_at')
        ->orderBy('pickups.id', 'DESC')
        ->get();

        return view('pickups.index', ['pickups' => $pickups] );
    }
}
