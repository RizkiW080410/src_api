<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = DB::connection('mysql')->table('transactions')->get();
        return response()->json($transactions, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Optional, if you have a form to show
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
            'product_id' => 'required|integer',
            'qty' => 'required|integer'
        ]);

        $product = DB::connection('mysql')->table('products')->where('id', $request->input('product_id'))->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $qty = $request->input('qty');
        $total = $product->price * $qty;

        $transaction = [
            'product_id' => $request->input('product_id'),
            'total_transaction' => $total,
        ];

        $storeID = DB::connection('mysql')->table('transactions')->insertGetId($transaction);

        $data = DB::connection('mysql')->table('transactions')->where('id', $storeID)->first();

        return response()->json(['success' => true, 'message' => 'Transaction created successfully', 'transaction' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = DB::connection('mysql')->table('transactions')->where('id', $id)->first();

        if (is_null($transaction)) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaction found',
            'transaction' => $transaction
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        // Optional, if you have a form to show
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_id' => 'required|integer',
            'qty' => 'required|integer'
        ]);

        $product = DB::connection('mysql')->table('products')->where('id', $request->input('product_id'))->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $transaction = DB::connection('mysql')->table('transactions')->where('id', $id)->first();

        if (is_null($transaction)) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $qty = $request->input('qty');
        $total = $product->price * $qty;

        DB::connection('mysql')->table('transactions')->where('id', $id)->update([
            'product_id' => $request->input('product_id'),
            'total_transaction' => $total,
            'updated_at' => Carbon::now(),
        ]);

        $updatedTransaction = DB::connection('mysql')->table('transactions')->where('id', $id)->first();

        return response()->json(['success' => true, 'message' => 'Transaction updated successfully', 'transaction' => $updatedTransaction], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = DB::connection('mysql')->table('transactions')->where('id', $id)->first();

        if (is_null($transaction)) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        DB::connection('mysql')->table('transactions')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Transaction deleted successfully'], 200);
    }
}
