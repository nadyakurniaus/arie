<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MonitoringBB;
use App\bahan_baku;
use App\UkuranBahan;
use App\Monitoring;
use App\pembelian_temp;
use DataTables;
use PDF;

class MonitoringBBController extends Controller
{
    public function dataTable()
    {
        $mbb = bahan_baku::join('bahan_bakus','bahan_bakus.id','=','ukuran_bahans.id_bahanbaku');
        return DataTables::of($mbb)
        ->addIndexColumn()
        ->make();
    }
    public function index()
    {
        pembelian_temp::truncate();
        $count = bahan_baku::join('ukuran_bahans', 'bahan_bakus.id' , '=', 'ukuran_bahans.id_bahanbaku')
        ->join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id_bahanbaku','left')
        ->where('stok', '<=', 2)
        ->get();
        $counter = $count->count();
        return view('back.gudang.mbbindex')->with('counter', $counter);
    }
    public function edit($id)
    {
        $count = bahan_baku::join('ukuran_bahans', 'bahan_bakus.id' , '=', 'ukuran_bahans.id_bahanbaku')
        ->join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id_bahanbaku','left')
        ->where('stok', '<=', 2)
        ->get();
        $counter = $count->count();
        $bahan = bahan_baku::find($id);
        $ukuran = UkuranBahan::find($id);
        $route = 'monitoringbb.update';
        return view('back.gudang.mbbedit',compact('bahan','ukuran','route','counter'));

    }
    public function update(Request $request, $id)
    {
        $bahan = bahan_baku::find($id);
        $ukuran = UkuranBahan::find($id);
        $monitoring = new Monitoring;
        $monitoring->id_bahanbaku = $bahan->id;
        $monitoring->id_ukuran = $ukuran->id;
        $monitoring->minimum = $request->minimum;

        return view('back.gudang.mbbindex')->with('message','Berhasil Tersimpan!');

    }
     public function export_pdf()
  {
    // Fetch all customers from database
    $data = MonitoringBB::get(['id','nama','jenis','ukuran','stok','satuan','jumlah_m']);
    // Send data to the view using loadView function of PDF facade
    $pdf = PDF::loadView('check',['data' => $data]);
    // If you want to store the generated pdf to the server then you can use the store function
    //$pdf->save(storage_path().'_lap_bahanbaku.pdf');
    // Finally, you can download the file using download function
    return $pdf->download('bahanbaku.pdf');
  }
}

