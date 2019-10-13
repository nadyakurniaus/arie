<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;

use Storage;
use DataTables;
use App\Design;
use App\Produksi;
use Image;
use App\ordered_item;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.bagsetting.index');
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
        $design = ordered_item::find($id);
        $kode_design = SettingController::autonumber();
        $bb = ordered_item::join('designs', 'ordered_items.id', '=', 'designs.id_ordered','left')
        ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
        ->join('produksis', 'ordered_items.id_order', '=', 'produksis.id')
        ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
        ->select(DB::raw('*,produksis.kode_produksi as kp,produks.nama as namaproduk'))
        ->where('ordered_items.id', '=', $id)
        ->first();
        $route = 'setting.update';
        return view ('back.bagsetting.update',compact('design','route','bb','kode_design'));
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
        $designnama = $request->design_old;
        if ($request->hasFile('design')){
            $designnama = $this->uploadDesign($request, $designnama);
        }
        $order = ordered_item::find($id);
        $order->proses = '1';
        $order->save();
        $designed = new Design;
        $designed->id_ordered = $order->id;
        $designed->design = $designnama;
        $designed->save();

        return redirect()->route('setting.index')
        ->with('message','Desain Order berhasil tersimpan!');

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

    public function dataTable()
    {
        $bb = ordered_item::join('designs', 'ordered_items.id', '=', 'designs.id_ordered','left')
        ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
        ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
        ->join('produksis', 'ordered_items.id_order', '=', 'produksis.id')
        ->select(DB::raw('*,ordered_items.id as idOrder,ordered_items.created_at as tanggal_orderan'))
        ->orderBy('tanggal_orderan', 'desc')
        ->get();
        return DataTables::of($bb)
        ->addColumn('action',function($data)
        {    if ($data->design == null) {


            return '
            <td>
            <a href="' . route('setting.edit', $data->idOrder) .'" class="btn btn-xs btn-icon btn-warning btn-round"><i class="icon wb-edit" aria-hidden="true"></i></a>
                    </td>
                    ';
                }else{
                    return '';
                }
                })
                ->addColumn('nama_pemesan',function($data){
                    return $data->penjualan->name;
                })
                ->addColumn('tanggal_order',function($data){
                    return $data->penjualan->tanggal_order;
                })
                ->addColumn('tanggal_selesai',function($data){
                    return $data->penjualan->tanggal_selesai;
                })
                ->addColumn('status',function($data){
                        if ($data->design == null) {
                            return 'Belum Diterima';
                        }else{
                            return 'Diterima';
                        }
                })
                ->addIndexColumn()
                ->make();
    }
    public function dataTableDashboard()
    {
        $bb = ordered_item::join('designs', 'ordered_items.id', '=', 'designs.id_ordered','left')
        ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
        ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
        ->join('produksis', 'ordered_items.id_order', '=', 'produksis.id')
        ->whereNull('design')
        ->select(DB::raw('*,ordered_items.id as idOrder,ordered_items.created_at as tanggal_orderan'))
        ->orderBy('tanggal_orderan', 'desc')
        ->get();
        return DataTables::of($bb)
        ->addColumn('action',function($data)
        {    if ($data->design == null) {


            return '
            <td>
            <a href="' . route('setting.edit', $data->idOrder) .'" class="btn btn-xs btn-icon btn-warning btn-round"><i class="icon wb-edit" aria-hidden="true"></i></a>
                    </td>
                    ';
                }else{
                    return '';
                }
                })
                ->addColumn('nama_pemesan',function($data){
                    return $data->penjualan->name;
                })
                ->addColumn('tanggal_order',function($data){
                    return $data->penjualan->tanggal_order;
                })
                ->addColumn('tanggal_selesai',function($data){
                    return $data->penjualan->tanggal_selesai;
                })
                ->addColumn('status',function($data){
                        if ($data->design == null) {
                            return 'Belum Diterima';
                        }else{
                            return 'Diterima';
                        }
                })
                ->addIndexColumn()
                ->make();
    }
    private function uploadDesign(Request $request, $design_old)
    {
        $design = $request->file('design');
        $ext  = $design->getClientOriginalExtension();
        if ($request->file('design')->isValid()) {
            $design_name   = date('Ymdhis') . "." . $ext;
            $image_resize = Image::make($design->getRealPath());
            $image_resize->resize(1024, 1024);
            $image_resize->save('storage/design/' . $design_name);
            if ($design_old != null) {
                $path_old = 'storage/design/' . $design_old;
                @unlink($path_old);
            }
            return $design_name;
        }
        return $design_old;
    }
    public function autonumber()
    {

        $count = Design::all()->count();
        if ( $count == 0){
            return 'DSG1';
        }else{
            $count = $count + 1;
            return 'DSG' . $count;
        }

    }
}
