<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // perché sennò errore CORS anche se gestito centralmente
        header('Access-Control-Allow-Origin', '*');

        //explode($separator, $prodotti, $limit = PHP_INT_MAX): array

        $orders = Orders::all();

        $totalOrders = [];
        foreach ($orders as $order) {

            $xpld = explode('||', $order['prodotti']);

            // $ordersExploded = [];
            $ordinitotalidellamorte = [];
            $totals = 0;
            foreach ($xpld as $x) {
                $xpld2 = explode('_', $x);
                $ordinitotalidellamorte[] = [
                    'name' => $xpld2[1],
                    'quantity' => $xpld2[2],
                    'price' => $xpld2[3],
                ];

                $totals += $xpld2[2] * $xpld2[3]; 
            }

            $totalOrders[] = [
                'created_at' => date('Y-m-d', strtotime($order['created_at'])),
                'orders' => $ordinitotalidellamorte,
                'totals' => $totals,
            ];
        }

        return $totalOrders;
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
     * 
     */
    public function store(Request $request)
    {

        // echo print_r($request->all(), true);

        $val = array();
        foreach ($request->all() as $order) {
            $val[] = $order['id_product'] . '_' . $order['name'] . '_' . $order['quantity'] . '_' . $order['price'];
            Cart::destroy($order['id_cart']);
        }

        $productsToString = join('||', $val);

        // echo $productsToString;

        return Orders::create(['prodotti' => $productsToString]);

        // return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Orders::find($id);
        $order->update($request->all());
        return $order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Orders::destroy($id);
    }
}
