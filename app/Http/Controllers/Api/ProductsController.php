<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Products;
use App\ProductsZipcode;

class ProductsController extends BaseController
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
        
        //Get the extra information from logged user
        $payload = JWTAuth::setToken($this->token)->getPayload();
        //$zip = $payload["user"]->zipcode;
        $zip = "70001";
        //
        $zipcodes = ProductsZipcode::where('zipcode', $zip)->get();

        $data = array();
        $product = array();
        foreach ($zipcodes as $key => $value) {
            $product = Products::where('id', $value->products_id)->get();
            $data_aux = array(
                "id" => $value->id,
                "products_id" => $value->products_id,
                "state" => $value->state_id,
                // "product" => $product,
                "zipcode" => $value->zipcode,
                "createdAt" => $value->created_at,
            );

            $data_aux["product"] = array(
                "id" => $value->id,
                "description" => $product[0]->description,
                "state_id" => $product[0]->state_id,
                "status" => $product[0]->status,
                "created_at" => $product[0]->created_at,
                "updated_at" => $product[0]->updated_at,
            ); 

            array_push($data, $data_aux);
        }
        return $this->sendResponse($data, 'List products succesfully');
    }
}

// public function index()
    // {
    //     $dataAll = array();

    //     $products = Products::find(5);

    //     $data_products = array(
    //         "id" => $products->id,
    //         "description" => $products->description,
    //         "state" => $products->state_id,
    //         "status" => $products->status,
    //         "createdAt" => $products->createdAt,
    //     );
        
    //     $zipcodes = ProductsZipcode::where('products_id', $products->id)->get();
        
    //     $data_zipcodes = array();
    //     foreach ($zipcodes as $key => $zip) {
    //         $data_aux = [
    //             "id" => $zip->id,
    //             "products_id" => $zip->products_id,
    //             "state" => $zip->state_id,
    //             "zipcode" => $zip->zipcode,
    //             "createdAt" => $zip->created_at,
    //         ];
    //         array_push($data_zipcodes, $data_aux);
    //     }

    //     $data_products['zipcodes'] = $data_zipcodes;

    //     return $this->sendResponse($data_products, 'List products succesfully');
    //     //return response()->json(compact('data_products'));
    // }