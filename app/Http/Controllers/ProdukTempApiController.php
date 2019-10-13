<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


use App\OrderTemp;
use App\Produk;
use App\Harga;
use \Auth, \Redirect, \Validator, \Input, \Session, \Response;

class ProdukTempApiController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return Response::json(OrderTemp::with('item')->get());
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
        $OrderTemp = new OrderTemp;
        $OrderTemp->id_produk = Input::get('id_produk');
        $OrderTemp->nama = Input::get('nama');
        $OrderTemp->jumlah = 1;
        $OrderTemp->harga = Input::get('harga');
        $OrderTemp->sisi_cetak = Input::get('sisi_cetak');
        $OrderTemp->save();
        return $OrderTemp;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
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
        $OrderTemp = OrderTemp::find($id);

        $getGrocere = Harga::limit(1)
        ->orderByRaw('quantity desc')
        ->where('quantity', '<=', Input::get('quantity'))
        ->where('id_produk', '=', Input::get('primary'))
        ->select(DB::raw("harga"))->get();

        $OrderTemp->jumlah = Input::get('quantity');
        $OrderTemp->harga = Str::substr($getGrocere,11,5);
        $OrderTemp->sisi_cetak = Input::get('sisi_cetak');
        $OrderTemp->save();
        // return $OrderTemp;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OrderTemp::destroy($id);
    }
}
