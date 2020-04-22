<?php

namespace App\Http\Controllers;

use DB;
use PDO;
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

    function recursiveFormMenuList($name, $zipList, $values = array(), $extra=""){
        
        $str = "";
        foreach($zipList as $zip){
            $zipcode = $zip["zip"];
            $checked = ( in_array($zip, $values) ) ? "checked='checked'" : "";
            $str .= "<div class='control-group col-sm-2 checkbox text-center'><label class='checkbox-inline'><input $checked name='$name' value='$zipcode' type='checkbox' class='checkbox'/> $zipcode </label></div>";
            $pkCount = (is_array($zip['zip']) ? count($zip['zip']) : 0);
            if( $pkCount > 0){
                $str .= recursiveFormMenuList($name, $zip['zip'], $values);
            }
        }
        $str .= "";
        return $str;	
    }

    public function edit($id)
    {
       /*  echo url('/products'); exit; */
        $products = DB::table('products')
        ->select('products.id', 'products.description AS name', 'products.state_id', 'products.status', 'products.created_at')
        ->where([
            ['products.id', '=', $id]
        ])->get();

        $states = DB::table('states')->get();

        $zipcode = DB::table('products_zipcode')
        ->select('products_zipcode.zipcode AS zip')
        ->where([
            ['products_zipcode.product_id', '=', $id]
        ])->get();
        //transform the result in array
        $zipcodeArr = collect($zipcode)->map(function($x){ return (array) $x; })->toArray(); 


        $zipmaster = DB::table('zipcode')->select('zip')->where('cod_state', $products[0]->state_id)->get();
         //transform the result in array
        $zipmasterArr = collect($zipmaster)->map(function($y){ return (array) $y; })->toArray();
        
        //make the checkbox checked in view, if the zipcode from the table macthes with zipcodes saved in bank, to this product.
        $checkboxes = $this->recursiveFormMenuList('productzip[]', $zipmasterArr, $zipcodeArr, $extra="");

        return view('products.edit', ['products' => $products[0], 'states' => $states, 'checkboxes' => $checkboxes, 'productzip' => $zipcodeArr, 'allzips' => $zipmasterArr] ); 
    }

    public function update(Request $request, $id)
    { 
        
        $description = $request->get('description');
        $state_id = $request->get('state_id');
        $status = $request->get('status');
        $updated_at = now();

        $delete_zip = DB::delete("DELETE FROM products_zipcode WHERE product_id = '$id'");
        $update_product = DB::update("UPDATE products SET description =" . "'$description'" . ", state_id =" . "'$state_id'" . ", status =" . "'$status'" . ", updated_at =" . "'$updated_at' WHERE id='$id'");
        
        if ($request->get('productzip')) {
            foreach ($request->get('productzip') as $key => $zip) {
                $zipid = DB::table('products_zipcode')->insertGetId(
                    ['product_id' => $id,
                    'state_id' => $state_id,
                    'zipcode' => $zip,
                    'created_at' => now()]
                );
            }
            return redirect('/products')->with('success', 'Product updated!');
        } else {
            return redirect('/products')->with('success', 'Product updated!');
        }
    }

    public function destroy($id)
    {
        DB::delete(" DELETE FROM products_zipcode WHERE product_id=?",[$id]);
        DB::delete(" DELETE FROM products WHERE id=?",[$id]);
        return redirect('/products')->with('success', 'Product deleted!');
    }

    
}
