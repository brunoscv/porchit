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

    public function productzipcode(Request $request, $id) {
        $products = DB::table('pickups_products')
                        ->leftJoin('products_zipcodes', 'pickups_products.products_id', '=', 'products_zipcodes.id')
                        ->leftJoin('products', 'products_zipcodes.products_id', '=', 'products.id')
                        ->select('products.description', 'products_zipcodes.zipcode')
                        ->where('pickups_id', $id)->get();
        
        $prodarr = [
            'success' => true,
            'result' => $products
        ];
        
        $result = json_encode($prodarr);
        return $prodarr;
    }
}
