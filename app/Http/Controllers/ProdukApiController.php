<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Produk;
use \Auth, \Redirect, \Validator, \Input, \Session, \Response;

class ProdukApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Response::json(Produk::with('bahan','ukuran')->get());
        return Response::json(Produk::join('hargas', 'hargas.id_produk', '=', 'Produks.id')
        ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
        ->join('ukuran_bahans', 'produks.id_ukuran', '=', 'ukuran_bahans.id')
        ->where('hargas.quantity', '=', '1')
        ->select(DB::raw("Produks.id,Produks.nama,hargas.harga,bahan_bakus.nama as bahan, hargas.sisi_cetak,ukuran_bahans.nama as ukuran"))->get());

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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
