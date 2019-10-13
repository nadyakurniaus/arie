<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use DataTables;
use App\bahan_baku;
use App\Monitoring;
use App\Produk;
use App\Harga;
use App\Produksi;
use App\Pembelian;
use App\Penjualan;
use DateTime;

use \Auth, \Input, \Session;

class DirekturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function pricelist()
    {
        return view('back.direktur.pricelist');
    }
    public function rekaporder()
    {
        return view('back.direktur.rekaporder');
    }
    public function produksi()
    {
        return view('back.direktur.produksi');
    }
    public function ppbb()
    {
        return view('back.direktur.ppbb');
    }
    public function dtPriceList()
    {
        $bb = Produk::join('hargas', 'hargas.id_produk', '=', 'produks.id')
            ->where('jenis_cetak', '=', 'Offset')->get();
        return DataTables::of($bb)
            ->addColumn('ukuran', function ($data) {
                return $data->ukuran->nama;
            })
            ->addColumn('bahan', function ($data) {
                return $data->ukuran->bahan->nama;
            })
            ->addIndexColumn()
            ->make();
    }
    public function dtPriceList2()
    {
        $bb = Produk::join('hargas', 'hargas.id_produk', '=', 'produks.id')
            ->where('jenis_cetak', '=', 'Digital Printing')->get();
        return DataTables::of($bb)
            ->addColumn('ukuran', function ($data) {
                return $data->ukuran->nama;
            })
            ->addColumn('bahan', function ($data) {
                return $data->ukuran->bahan->nama;
            })
            ->addIndexColumn()
            ->make();
    }
    public function dtProduksi(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $bb = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->where('produksis.jadwal_produksi', 'LIKE', '%' . $tanggal . '%')
            // ->where('produksis.jadwal_produksi', '!=', 'null')
            ->select(DB::raw('*,produksis.status as status_prod,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk'))->get();
        return DataTables::of($bb)
            // ->addColumn('nama_pelanggan', function ($data) {
            //     return $data->order->nama;
            // })
            ->addColumn('ukuran', function ($data) {
                return $data->ukuran->nama;
            })
            ->addColumn('satuan', function ($data) {
                return $data->ukuran->satuan;
            })
            ->addColumn('bahan', function ($data) {
                return $data->bahan_baku->nama;
            })
            ->addIndexColumn()
            ->make();
    }
    public function dtPPBB()
    {
        $bb = Pembelian::join('pembelian_details', 'pembelians.kode', '=', 'pembelian_details.kode_pembelian')
            ->join('bahan_bakus', 'bahan_bakus.id', '=', 'pembelian_details.id_bahanbaku')
            ->join('ukuran_bahans', 'ukuran_bahans.id', '=', 'pembelian_details.id_ukuran')
            ->select(DB::raw('*,pembelians.id as id_pembelian,bahan_bakus.nama as bahan,ukuran_bahans.nama as ukuran'))
            ->get();
        return DataTables::of($bb)
            ->addIndexColumn()
            ->make();
    }
    function getAllMonthsSPV()
    {

        $month_array = array();
        $posts_dates = Produksi::select(DB::raw("DISTINCT
        (select count(*) from produksis where MONTH(jadwal_produksi) = 1) AS '1',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 2) AS '2',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 3) AS '3',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 4) AS '4',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 5) AS '5',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 6) AS '6',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 7) AS '7',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 8) AS '8',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 9) AS '9',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 10) AS '10',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 11) AS '11',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 12) AS '12',
        (select count(*) from produksis) AS 'total'"))
        ->orderBy('created_at', 'ASC')->pluck('created_at')->get();
        $posts_dates = json_decode($posts_dates);

        if (!empty($posts_dates)) {
            foreach ($posts_dates as $unformatted_date) {
                $date = new DateTime($unformatted_date->date);
                $month_no = $date->format('m');
                $month_name = $date->format('M');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }

    function getAllMonths()
    {

        $month_array = array();
        $posts_dates = Produksi::orderBy('created_at', 'ASC')->pluck('created_at');
        $posts_dates = json_decode($posts_dates);

        if (!empty($posts_dates)) {
            foreach ($posts_dates as $unformatted_date) {
                $date = new DateTime($unformatted_date->date);
                $month_no = $date->format('m');
                $month_name = $date->format('M');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }
    function getMonthlyPostCount($month)
    {
        $monthly_post_count = Produksi::whereMonth('jadwal_produksi', $month)->get()->count();
        return $monthly_post_count;
    }

    function getMonthlyPostCountSPV()
    {
        $data = Produksi::select(DB::raw("DISTINCT
        (select count(*) from produksis where MONTH(jadwal_produksi) = 1) AS 'jan',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 2) AS 'feb',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 3) AS 'mar',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 4) AS 'apr',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 5) AS 'mei',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 6) AS 'jun',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 7) AS 'jul',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 8) AS 'aug',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 9) AS 'sep',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 10) AS 'oct',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 11) AS 'nov',
        (select count(*) from produksis where MONTH(jadwal_produksi) = 12) AS 'des',
        (select count(*) from produksis) AS 'total'"))->get();
        return $data;
    }
    function getMonthlyPostData()
    {

        $monthly_post_count_array = array();
        $month_array = $this->getAllMonths();
        // $month_number = substr($month_array, 1, 2);
        $testString = $month_array;

        // 56789

        $month_name_array = array();
        if (!empty($month_array)) {
            foreach ($month_array as $month_no => $month_name) {
                $monthly_post_count = $this->getMonthlyPostCount($month_no);
                array_push($monthly_post_count_array, $monthly_post_count);
                array_push($month_name_array, $month_name);
            }
        }
        $max_no = max($monthly_post_count_array);
        $max = round(($max_no + 10 / 2) / 10) * 10;
        $monthly_post_data_array = array(
            'months' => $month_name_array,
            'months_number' => $month_no,
            'post_count_data' => $monthly_post_count_array,
            'max' => $max
        );
        return $monthly_post_data_array;
    }

    function getAllMonthsOrder()
    {

        $month_array = array();
        $posts_dates = Penjualan::select(DB::raw("DISTINCT
        (select count(*) from penjualans where MONTH(created_at) = 1) AS '1',
        (select count(*) from penjualans where MONTH(created_at) = 2) AS '2',
        (select count(*) from penjualans where MONTH(created_at) = 3) AS '3',
        (select count(*) from penjualans where MONTH(created_at) = 4) AS '4',
        (select count(*) from penjualans where MONTH(created_at) = 5) AS '5',
        (select count(*) from penjualans where MONTH(created_at) = 6) AS '6',
        (select count(*) from penjualans where MONTH(created_at) = 7) AS '7',
        (select count(*) from penjualans where MONTH(created_at) = 8) AS '8',
        (select count(*) from penjualans where MONTH(created_at) = 9) AS '9',
        (select count(*) from penjualans where MONTH(created_at) = 10) AS '10',
        (select count(*) from penjualans where MONTH(created_at) = 11) AS '11',
        (select count(*) from penjualans where MONTH(created_at) = 12) AS '12',
        (select count(*) from penjualans) AS 'total'"))
        ->orderBy('created_at', 'ASC')->pluck('created_at')->get();
        $posts_dates = json_decode($posts_dates);

        if (!empty($posts_dates)) {
            foreach ($posts_dates as $unformatted_date) {
                $date = new DateTime($unformatted_date->date);
                $month_no = $date->format('m');
                $month_name = $date->format('M');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }
    function getMonthlyPostCountOrder()
    {
        $data = Penjualan::select(DB::raw("DISTINCT
        (select count(*) from penjualans where MONTH(tanggal_order) = 1) AS 'jan',
        (select count(*) from penjualans where MONTH(tanggal_order) = 2) AS 'feb',
        (select count(*) from penjualans where MONTH(tanggal_order) = 3) AS 'mar',
        (select count(*) from penjualans where MONTH(tanggal_order) = 4) AS 'apr',
        (select count(*) from penjualans where MONTH(tanggal_order) = 5) AS 'mei',
        (select count(*) from penjualans where MONTH(tanggal_order) = 6) AS 'jun',
        (select count(*) from penjualans where MONTH(tanggal_order) = 7) AS 'jul',
        (select count(*) from penjualans where MONTH(tanggal_order) = 8) AS 'aug',
        (select count(*) from penjualans where MONTH(tanggal_order) = 9) AS 'sep',
        (select count(*) from penjualans where MONTH(tanggal_order) = 10) AS 'oct',
        (select count(*) from penjualans where MONTH(tanggal_order) = 11) AS 'nov',
        (select count(*) from penjualans where MONTH(tanggal_order) = 12) AS 'des',
        (select count(*) from penjualans) AS 'total'"))->get();
        return $data;
    }
    function getAllMonthsPPBB()
    {

        $month_array = array();
        $posts_dates = Pembelian::select(DB::raw("DISTINCT
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 1) AS '1',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 2) AS '2',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 3) AS '3',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 4) AS '4',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 5) AS '5',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 6) AS '6',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 7) AS '7',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 8) AS '8',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 9) AS '9',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 10) AS '10',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 11) AS '11',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 12) AS '12',
        (select count(*) from pembelians) AS 'total'"))
        ->orderBy('created_at', 'ASC')->pluck('created_at')->get();
        $posts_dates = json_decode($posts_dates);

        if (!empty($posts_dates)) {
            foreach ($posts_dates as $unformatted_date) {
                $date = new DateTime($unformatted_date->date);
                $month_no = $date->format('m');
                $month_name = $date->format('M');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }
    function getMonthlyPostCountPPBB()
    {
        $data = Pembelian::select(DB::raw("DISTINCT
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 1) AS 'jan',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 2) AS 'feb',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 3) AS 'mar',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 4) AS 'apr',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 5) AS 'mei',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 6) AS 'jun',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 7) AS 'jul',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 8) AS 'aug',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 9) AS 'sep',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 10) AS 'oct',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 11) AS 'nov',
        (select count(*) from pembelians where MONTH(tanggal_permintaan) = 12) AS 'des',
        (select count(*) from pembelians) AS 'total'"))->get();
        return $data;
    }

    public function detail_chart(){
        return view ('back.direktur.detail-chart');
    }
    public function dtRekapOrder(){
        $tanggalawal = Input::get('from');
        $tanggalakhir = Input::get('to');
        $from = date('Y-m-d', strtotime($tanggalawal));
        $to = date('Y-m-d', strtotime($tanggalakhir));
        $bb = Penjualan::join('ordered_items','penjualans.id','=','ordered_items.id_order')
                        ->join('pembayarans','penjualans.id','=','pembayarans.id_order')
                        ->join('produks','ordered_items.id_produk','=','produks.id')
                        ->join('produksis','ordered_items.id','=','produksis.id_item')
                        ->select(DB::raw('*,produks.nama as nama_produk'))
                        ->between($from,$to);
        return DataTables::of($bb)
            ->addColumn('action', function ($data) {
                return '<td>
            <button data-id="' . $data->id . '" class="btn btn-xs btn-icon btn-warning btn-round"><i class="icon wb-search" aria-hidden="true"></i></button>
                    </td>
                    ';
            })
            ->addIndexColumn()
            ->make();
    }
}
