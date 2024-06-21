<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = DB::connection('mysql')->table('products')->get();
        return response()->json($product, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        $dataproduct = [
            'name' => $request['name'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $product = DB::connection('mysql')->table('products')->insertGetId($dataproduct);

        $data = DB::connection('mysql')->table('products')->where('id', $product)->first();

        return response()->json(['success' => true, 'message' => 'product created successfully ' . $request->name, 'product' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = DB::connection('mysql')->table('products')->where('id', $id)->first();
        $responstrue = [
            'success' => true,
            'message' => 'product founded',
            'data' => $product
        ];

        $responsfalse = [
            'success' => false,
            'message' => 'product notfounded',
        ];
        if(is_null($product)){
            return response()->json($responsfalse, 404);
        } else {
            return response()->json($responstrue, 201);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        $product = DB::connection('mysql')->table('products')->where('id', $id)->first();

        $responsfalse = [
            'success' => false,
            'message' => 'product notfounded',
        ];
        if(is_null($product)){
            return response()->json($responsfalse, 404);
        } else {
            $dataproduct = [
                'name' => $request->input(['name']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            $product = DB::connection('mysql')->table('products')->update($dataproduct);
            $dataupdate = DB::connection('mysql')->table('products')->where('id', $id)->first();
            $responstrue = [
                'success' => true,
                'message' => 'product founded',
                'data' => $dataupdate
            ];
            return response()->json($responstrue, 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = DB::connection('mysql')->table('products')->where('id', $id)->first();
        $responstrue = [
            'success' => true,
            'message' => 'product success delete',
        ];

        $responsfalse = [
            'success' => false,
            'message' => 'product notfounded',
        ];
        if(is_null($product)){
            return response()->json($responsfalse, 404);
        } else {
            DB::connection('mysql')->table('products')->where('id', $id)->delete();
            return response()->json($responstrue, 201);
        }
    }
}
