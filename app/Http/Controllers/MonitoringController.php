<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use DataTables;
use App\Monitoring;
use App\bahan_baku;
use App\UkuranBahan;

class MonitoringController extends Controller
{

    public function view(){
        $count = bahan_baku::join('ukuran_bahans', 'bahan_bakus.id' , '=', 'ukuran_bahans.id_bahanbaku')
        ->join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id_bahanbaku','left')
        ->whereColumn('stok', '<=', 'minimum')
        ->get();
        $counter = $count->count();
        return view('back.gudang.mbbindex')->with('counter', $counter);

    }
    public function index(){
        $count = bahan_baku::join('ukuran_bahans', 'bahan_bakus.id' , '=', 'ukuran_bahans.id_bahanbaku')
        ->join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id_bahanbaku','left')
        ->whereColumn('stok', '<=', 'minimum')
        ->get();
        $counter = $count->count();
        return view('back.gudang.mbbindex')->with('counter', $counter);
    }
    public function buat($id){
        $count = bahan_baku::join('ukuran_bahans', 'bahan_bakus.id' , '=', 'ukuran_bahans.id_bahanbaku')
        ->join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id_bahanbaku','left')
        ->whereColumn('stok', '<=', 'minimum')
        ->get();
        $counter = $count->count();
        $bahan = bahan_baku::find($id);
        $ukuran = UkuranBahan::find($id);
        return view('back.gudang.mbbcreate',compact('bahan','ukuran','counter'));
    }
    public function edit($id)
    {
        $count = bahan_baku::join('ukuran_bahans', 'bahan_bakus.id' , '=', 'ukuran_bahans.id_bahanbaku')
        ->join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id_bahanbaku','left')
        ->where('stok', '<=', 'minimum')
        ->get();
        $counter = $count->count();
        $bahan = bahan_baku::find($id);
        $ukuran = UkuranBahan::find($id);
        $route = 'monitoring.update';
        return view('back.gudang.mbbedit',compact('bahan','ukuran','route','counter'));

    }
    public function update(Request $request, $id)
    {

        $bahan = bahan_baku::find($id);
        $ukuran = UkuranBahan::find($id);
        $monitoring = Monitoring::find($id);
        $monitoring->id_bahanbaku = $bahan->id;
        $monitoring->id_ukuran = $ukuran->id;
        $monitoring->minimum = $request->minimum;

        $monitoring->save();

        return redirect()->route('monitoring.index')->with('message','Stok minimum bahan baku berhasil diubah!');

    }
    public function dataTable(){
        $bb = bahan_baku::join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id','left')
        ->join('ukuran_bahans', 'bahan_bakus.id', '=', 'ukuran_bahans.id_bahanbaku')
        ->select(DB::raw('*,bahan_bakus.nama as bahanbaku,ukuran_bahans.nama as namaukuran'))->get();
        return DataTables::of($bb)
        ->addColumn('action',function($data)
        {   if ($data->minimum == null){
            return '<a href="' . route('monitoring.buat', $data->id) .'" class="btn btn-xs btn-icon btn-primary btn-round "><i class="icon wb-plus" aria-hidden="true"></i></a>';
        }else{
            return '<td class="text-xs-center">
            <a href="' . route('monitoring.edit', $data->id) .'" class="btn btn-xs btn-icon btn-warning btn-round "><i class="icon wb-edit" aria-hidden="true"></i></a>
                    </td>
                    ';
        }
                })

        ->addColumn('keterangan', function($data){

            if ($data->stok > $data->minimum){
                return '<td class="text-xs-center"><span class="tag tag-pill tag-success">Tersedia</span></td>';
            }elseif ($data->stok <= $data->minimum){
                return '<span class="tag tag-pill tag-danger">Restock</span>';
            }else{
                return '';
            }

        })  ->rawColumns(['keterangan','action'])
            ->addIndexColumn()
            ->make();
    }
    public function simpan(Request $request, $id)
    {

        $bahan = bahan_baku::find($id);
        $ukuran = UkuranBahan::find($id);
        $monitoring = new Monitoring;
        $monitoring->id_bahanbaku = $bahan->id;
        $monitoring->id_ukuran = $ukuran->id;
        $monitoring->minimum = $request->minimum;

        $monitoring->save();

        return redirect()->route('monitoring.index')->with('message','Stok minimum bahan baku berhasil ditambahkan!');

    }
}
