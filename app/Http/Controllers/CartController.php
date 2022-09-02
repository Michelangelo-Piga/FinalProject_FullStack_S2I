<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * * @param  int id_user
     */
    public function index(Request $request, $id_user)
    {
        $prodFromCarts = DB::select("
            select * from carts where id_user = " . $id_user . "
        ");
        // echo print_r($prodFromCarts, true);


        $productResults = [];
        foreach ($prodFromCarts as $k => $product) {

            // echo print_r($product->id_product, true);
            $prod = DB::select("select name, price from products where id = " . $product->id_product);


            // echo print_r($prod, true);

            $productResults[] = [
                "id_cart" => $product->id,
                "id_product" => $product->id_product,
                "name" => $prod[0]->name,
                "quantity" => $product->quantity,
                "price" => $prod[0]->price,
            ];
        }

        return $productResults;
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

        // echo 'ok';
        // echo print_r($request->all(),true);
        // return;

        // exit;

        // faccio in modo che se non ci sia già un carrello con l'id del prodotto lo crei altrimenti lo recupero e incremento di uno la quantità
        $usersCart = DB::select("select id, quantity from carts where id_user = " . $request->id_user . ' AND id_product = ' . $request->id_product);
        // echo print_r($usersCart,true);
        if (count($usersCart) > 0) {
            $cartFind = Cart::find($usersCart[0]->id);
            return $cartFind->update(['quantity' => $usersCart[0]->quantity + 1]);
        }

        // return;

        // se l'utente non ha carrelli, ne creo uno nuovo
        // if (count($usersCart) === 0) {
        // return Cart::create($request->all())->id; // ritorno id del nuovo carrello
        // }

        // se sono qui significa che ho recuperat l'ID del mio carrello già esistente e lo ritorno
        // return $usersCart[0]->id;

        return Cart::create($request->all()); // ritorno id del nuovo carrello
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
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
        // perché sennò errore CORS anche se gestito centralmente
        header('Access-Control-Allow-Origin', '*');


        // echo $id;
        // echo print_r($request->all());

        // echo print_r($request, true);

        $cartQuantity = Cart::find($id);

        // echo print_r($cartQuantity,true);
        // return;

        $cartQuantity->update($request->all());
        return $cartQuantity;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        return Cart::destroy($id);
    }
}
