<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Produk;
use App\UkuranBahan;
use App\bahan_baku;
use App\harga_temp;
use Session;
use Storage;
use DataTables;
use App\Harga;


class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.admin.produk.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = bahan_baku::all();
        $kodeproduk = ProdukController::autonumber();
        $bahan = bahan_baku::orderBy('id', 'desc')->get();
        $ukuran = UkuranBahan::orderBy('id', 'desc')->get();
        return view('back.admin.produk.create', compact('bahan','ukuran','kodeproduk','data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required',
            'id_ukuran' => 'required',
            'kebutuhan' => 'required|max:100',
            'jenis_cetak' => 'required'


        ];
        $messages = [
            'nama.required' => ':attribute tidak boleh kosong',
            'id_ukuran.required' => 'Ukuran bahan tidak boleh kosong',
            'kebutuhan.required' =>':attribute tidak boleh kosong',
            'kebutuhan.max' => 'maksimal karakter 100 digit',
            'jenis_cetak.required'=>'Jenis Cetak tidak boleh kosong'

        ];
        $request->validate($rules, $messages);

        $produk = new Produk;
        $produk->idProduk = $request->idProduk;
        $produk->nama = $request->nama;
        $produk->id_bahanbaku = $request->id_bahan;
        $produk->id_ukuran = $request->id_ukuran;
        $produk->kebutuhan = $request->kebutuhan;
        $produk->sisi_cetak = $request->sisi_cetak;
        $produk->jenis_cetak = $request->jenis_cetak;
        $produk->save();

        $harga = harga_temp::all();
        foreach ($harga as $value){
            $hargaData = new Harga;
            $hargaData->id_produk = $produk->id;
            $hargaData->sisi_cetak = $produk->sisi_cetak;
            $hargaData->quantity = $value->quantity;
            $hargaData->harga = $value->harga;

            $hargaData->save();
        }
        harga_temp::truncate();
        
        return redirect()->route('product.index')->with('message', 'Produk berhasil ditambahkan!');
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
       $produk = Produk::find($id);
       $route = 'product.update';
       return view('back.admin.produk.edit',compact('produk','route'));
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
        $rules = [
            'nama' => 'required',
            'id_ukuran' => 'required',
            'kebutuhan' => 'required|max:100',
            'jenis_cetak' => 'required'


        ];
        $messages = [
            'nama.required' => ':attribute tidak boleh kosong',
            'id_ukuran.required' => 'Ukuran bahan tidak boleh kosong',
            'kebutuhan.required' =>':attribute tidak boleh kosong',
            'kebutuhan.max' => 'maksimal karakter 100 digit',
            'jenis_cetak.required'=>'Jenis Cetak tidak boleh kosong'


        ];
        $request->validate($rules, $messages);
        $produk = Produk::find($id);
        $produk->nama = $request->nama;
        $produk->id_bahanbaku = $request->id_bahan;
        $produk->id_ukuran = $request->id_ukuran;
        $produk->kebutuhan = $request->kebutuhan;
        $produk->jenis_cetak = $request->jenis_cetak;
        $produk->sisi_cetak = $request->sisi_cetak;
        $produk->save();

        return redirect()->route('product.index')->with('message', 'Produk berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();
        return redirect()->route('product.index')->with('message', 'Produk berhasil Terhapus!');
    }
    public function dataTable()
    {
        $bb = Produk::all();
        return DataTables::of($bb)
            ->addColumn('action', function ($data) {
                return '<td>
            <a href="' . route('product.edit', $data->id) . '" class="btn btn-xs btn-icon btn-warning btn-round"><i class="icon wb-edit" aria-hidden="true"></i></a>
                    </td>
                    ';
            })
            ->addColumn('ukuran', function ($data) {
                return $data->ukuran->nama;
            })
            ->addColumn('bahan', function ($data) {
                return $data->ukuran->bahan->nama;
            })
            ->addIndexColumn()
            ->make();
    }
    public function autocomplete()
    {
        $query = request('query');

        $autocomplete = bahan_baku::autocomplete([
            'nama' => $query,
            'namaukuran' => $query,
        ]);
        $items = $autocomplete->get();
        return response()->json($items);
    }
    public function select2(Request $request)
    {

        return bahan_baku::where('nama', 'LIKE', '%' . request('q') . '%')->paginate(10);
    }
    public function selectukuran(Request $request)
    {
        return UkuranBahan::where('nama', 'LIKE', '%' . request('q') . '%')
            ->where('id_bahanbaku', '=', $request->id)->paginate(10);
    }

    public function selectSatuan(Request $request)
    {
        return UkuranBahan::where('nama', 'LIKE', '%' . $request->nama . '%')
            ->where('id_bahanbaku', '=', $request->id)
            ->paginate(10);
    }
    public function addHarga($id){
        $produk = Produk::find($id);
       $route = 'product.harga';
       return view('back.admin.produk.createharga',compact('produk','route'));
    }
    public function Harga(Request $request, $id){
        $rules = [
            'sisi_cetak' => 'required',
            'quantity' => 'required | numeric',
            'harga' => 'required|numeric',
        ];
        $messages = [
            'sisi_cetak.required' => ':Sisi Cetak tidak boleh kosong',
            'quantity.required' => 'Quantity tidak boleh kosong',
            'quantity.numeric' =>'Quantity harus berisikan angka',
            'harga.required' => 'Harga tidak boleh kosong',
            'harga.numeric'=>'Harga harus berisikan nominal'
        ];
        $request->validate($rules, $messages);
        $produk = Produk::find($id);
        $harga = new Harga;
        $harga->id_produk = $produk->id;
        $harga->sisi_cetak = $request->sisi_cetak;
        $harga->quantity = $request->quantity;
        $harga->harga = $request->harga;

        $harga->save();

        return redirect()->route('product.index')->with('message', 'Harga berhasil tersimpan!');

    }
    public function autonumber()
    {
        $count = Produk::all()->count();
        if ( $count == 0){
            return 'PRD-1';
        }else{
            $count = $count + 1;
            return 'PRD-' . $count;
        }
    }
    public function addHargaManual(Request $request)
    {
        $item_row = $request['item_row'];
        $html = view('back.admin.produk.harga', compact('item_row', 'taxes', 'currency'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'message' => 'null',
            'html'    => $html,
        ]);
    }
    public function simpanTemp(Request $request)
    {
        $harga = new harga_temp;
        $harga->quantity = $request->input('qty');
        $harga->harga = $request->input('harga');

        $harga->save();
    }

}
