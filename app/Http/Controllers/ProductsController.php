<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
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
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
    */
    public function index(Request $request)
    {
        $products = DB::table('products')
        ->leftJoin('states', 'products.state_id', '=', 'states.id')
        ->leftJoin('products_zipcode', 'products.id', '=', 'products_zipcode.product_id')
        ->select(DB::raw('COUNT(products_zipcode.product_id) AS zips'),'products.id', 'products.description AS name', 'states.description AS state', 'products.status', 'products.created_at')
        ->groupBy('products_zipcode.product_id', 'products.id', 'products.description', 'states.description', 'products.status', 'products.created_at')
        ->get();
        return view('products.index', ['products' => $products] );
    }

    public function create(Request $request)
    {
        $states = DB::table('states')->get();
        return view('products.form', ['states' => $states]);
    }

    public function store(Request $request)
    {

        $productId = DB::table('products')->insertGetId(
            ['description' => $request->get('description'),
            'state_id' => $request->get('state_id'),
            'status' => $request->get('status'),
            'created_at' => now()]
        );

        foreach ($request->get('productzip') as $key => $zip) {
            $zipid = DB::table('products_zipcode')->insertGetId(
                ['product_id' => $productId,
                'state_id' => $request->get('state_id'),
                'zipcode' => $zip,
                'created_at' => now()]
            );
        }
        
        return redirect('/products')->with('success', 'Product saved!');
    }

    public function zipcode(Request $request, $id) {
        $zipcode = DB::table('zipcode')->select('zip')->where('cod_state', $id)->get();
        
        $ziparr = [
            'success' => true,
            'result' => $zipcode
        ];
        
        $result = json_encode($ziparr);
        return $ziparr;
    }

    public function productzipcode(Request $request, $id) {
        $zipcode = DB::table('products_zipcode')->select('id', 'zipcode')->where('product_id', $id)->get();
        
        $ziparr = [
            'success' => true,
            'result' => $zipcode
        ];
        
        $result = json_encode($ziparr);
        return $ziparr;
    }

    public function edit($id)
    {
        $products = DB::table('products')
        ->select('products.id', 'products.description AS name', 'products.state_id', 'products.status', 'products.created_at')
        ->where([
            ['products.id', '=', $id]
        ])->get();

        $states = DB::table('states')->get();

        $zipcode = DB::table('products_zipcode')
        ->select('products_zipcode.id', 'products_zipcode.product_id', 'products_zipcode.state_id', 'products_zipcode.zipcode', 'products_zipcode.created_at')
        ->where([
            ['products_zipcode.product_id', '=', $id]
        ])->get();

        $zipmaster = DB::table('zipcode')->select('zip')->where('cod_state', $products[0]->state_id)->get();

       /*  print_r($zipmaster);exit; */
        return view('products.edit', ['products' => $products[0], 'states' => $states, 'zipcodes'=>$zipcode, 'zipmaster'=>$zipmaster] ); 
    }
}
