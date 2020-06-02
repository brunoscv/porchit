<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Pickups;
use App\Products;
use App\PickupsProducts;
use App\PickupsComments;
use DB;
use PDO;


class PickupsController extends BaseController
{
    protected $user;
    protected $token;
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        $this->token = JWTAuth::getToken();
    }
    public function index()
    {  
        $dataAll = array();
        $pickups = Pickups::all();

        //Get the extra information from logged user
        $payload = JWTAuth::setToken($this->token)->getPayload();

        $products = array();
        $data = array();
        foreach ($pickups as $key => $value) {
            $products = DB::table('pickups_products')
                            ->select('pickups_products.products_id','products.description')
                            ->join('products','products.id','=','pickups_products.products_id')
                            ->where(['pickups_products.pickups_id' => $value->id])
                        ->get();
            $data_aux = array(
                "id" => $value->id,
                "users_id" => $this->user->id,
                "latitude" => $value->latitude,
                "longitude" => $value->longitude,
                "date_pickup" => $value->date_pickup,
                "pickup_at" => $value->pickup_at,
                "comments" => PickupsComments::where(['pickups_id' => $value->id])->get(),
                "status" => $value->status,
                "createdAt" => $value->created_at,
            );
            
            $data2=array();
            foreach ($products as $key => $value2) {
                $data_aux2 = array(
                    "product_id" => $value2->products_id,
                    "description" => $value2->description,
                );
                array_push($data2, $data_aux2);
            }
            
            $data_aux['products'] = $data2;
            array_push($data, $data_aux);
        }
        return $this->sendResponse($data, 'List Pickups succesfully');
    }

    public function location(Request $request)
    {
        $input = $request->all();

        $dataAll = array();
        $pickups = Pickups::where(['latitude' => $input["latitude"], "longitude" => $input["longitude"]])->get();
    
        $products = array();
        $data = array();
        foreach ($pickups as $key => $value) {
            $products = DB::table('pickups_products')
                            ->select('pickups_products.products_id','products.description')
                            ->join('products','products.id','=','pickups_products.products_id')
                            ->where(['pickups_products.pickups_id' => $value->id])
                        ->get();
            $data_aux = array(
                "id" => $value->id,
                "users_id" => $this->user->id,
                "latitude" => $value->latitude,
                "longitude" => $value->longitude,
                "date_pickup" => $value->date_pickup,
                "pickup_at" => $value->pickup_at,
                "comments" => PickupsComments::where(['pickups_id' => $value->id])->get(),
                "status" => $value->status,
                "createdAt" => $value->created_at,
            );
            
            $data2=array();
            foreach ($products as $key => $value2) {
                $data_aux2 = array(
                    "product_id" => $value2->products_id,
                    "description" => $value2->description,
                );
                array_push($data2, $data_aux2);
            }

            $data_aux['products'] = $data2;
            array_push($data, $data_aux);
        }
        return $this->sendResponse($data, 'List Pickups succesfully');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $pickupId = DB::table('pickups')->insertGetId(
            [
                'users_id' => $this->user->id,
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
                'date_pickup' => $request->get('date_pickup'),
                'status' => 0,
                'created_at' => now()
            ]
        );

        foreach ($request->get('products') as $key => $product) {
            $pickupProductId = DB::table('pickups_products')->insertGetId(
                [
                    'pickups_id' => $pickupId,
                    'products_id' => $product["id"],
                    'status' => 1,
                    'created_at' => now()
                ]
            );
        }

        if($request->get('comments')) {
            $commentId = DB::table('pickups_comments')->insertGetId(
                [
                    'users_id' => $this->user->id,
                    'comments' => $request->get('comments'),
                    'pickups_id' => $pickupId,
                    'status' => 1,
                    'created_at' => now()
                ]
            );
        }

        return $this->sendResponse($input, 'Pickup Stored succesfully');
    }
}
