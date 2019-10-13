<?php
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//MIDDLEWARE
Route::get('/manajer', function(){
    return view('back.dashboard-manajer');
})->middleware('manajer')->name('manajer');
Route::get('/', function () {
    return view('auth.login');
})->name('/')->middleware('guest');
Route::get('/admin', function () {
    return view('back.dashboard');
})->name('admin')->middleware('admin');
Route::get('/finance', function () {
    return view('back.dashboard-finance');
})->middleware('finance')->name('finance');
Route::get('/gudang', function () {
    return view('back.dashboard-gudang');
})->middleware('gudang')->name('gudang');
Route::get('/bagsetting', function () {
    return view('back.dashboard-setting');
})->middleware('setting')->name('setting');
Route::get('/supervisor', function () {
    return view('back.dashboard-supervisor');
})->middleware('supervisor')->name('supervisor');
Route::get('/adminsystem', function(){
    return view('back.dashboard-adminsys');
})->middleware('adminsystem')->name('adminsystem');
Route::get('/direktur', function(){
    return view('back.dashboard-direktur');
})->middleware('direktur')->name('direktur');
//Gudang
Route::group(['middleware' => ['gudang', 'auth']], function () {
    //Gudang-Resource
    Route::resource('bahanbaku', 'BahanbakuController')->except(['show']);
    Route::resource('jenisbahan', 'JenisbahanController')->except(['show']);
    Route::resource('ukuranbahan', 'UkuranbahanController')->except(['show']);
    Route::resource('monitoringbb', 'MonitoringBBController')->except(['show']);
    Route::get('/monitoringbahan', 'MonitoringController@view');
    Route::resource('monitoring', 'MonitoringController')->except(['show']);
    Route::get('/monitoring/{id}/create', 'MonitoringController@buat')->name('monitoring.buat');
    Route::post('/monitoring/store/{id}', 'MonitoringController@simpan')->name('monitoring.simpan');
    Route::get('/gudangs', 'AdminController@indexGudang')->name('index.gudang');
    //Gudang-DataTables
    Route::get('/bahanbakus', 'BahanbakuController@dataTable')->name('bahanbaku.dt');
    Route::get('/m_bahanbaku', 'MonitoringBBController@dataTable')->name('monitoringbb.dt');
    Route::get('/jenis_bahan', 'JenisbahanController@dataTable')->name('jenisbahan.dt');
    Route::get('/ukuran_bahan', 'UkuranbahanController@dataTable')->name('ukuranbahan.dt');
    Route::get('/dtmbb', 'MonitoringController@dataTable')->name('monitoring.dt');
    //Gudang-Select2
    Route::get('/bb', 'BahanbakuController@select2')->name('jenis.select2');
    Route::get('/jb', 'UkuranbahanController@select2')->name('bahan.select2');

    //new
    Route::resource('pembelian', 'PermintaanPembelianController')->except(['show']);
    Route::get('pembelian/create', 'PermintaanPembelianController@create')->name('pembelian.create');
    Route::get('pembelian/createWith', 'PermintaanPembelianController@createWith')->name('pembelian.create.with');
    Route::get('pembelian/addItem', 'PermintaanPembelianController@addItem')->name('pembelian.add.item');
    Route::post('pembelian/totalItem', 'PermintaanPembelianController@totalItem')->name('pembelian.total.item');
    Route::get('pembelian/autocomplete', 'PermintaanPembelianController@autocomplete')->name('pembelian.autocomplete');
    Route::post('pembelian/simpanTemp', 'PermintaanPembelianController@simpanTemp')->name('pembelian.save.detail');
    Route::get('/pembelian/dt', 'PermintaanPembelianController@dataTable')->name('pembelian.dt');
    Route::get('/pembelian/dtTemp', 'PermintaanPembelianController@dataTableTemp')->name('pembelian.dtTemp');
    Route::post('/pembelianDetail', 'PermintaanPembelianController@dataTableDetail')->name('pembelian.dtDetail');
    Route::post('/pembelianDelete', 'PermintaanPembelianController@delete')->name('pembelian.delete');
    Route::post('/pembelianUpdateTemp', 'PermintaanPembelianController@updateTemp')->name('pembelian.updateTemp');
    Route::get('/produksis/isiOtomatis', 'ProduksiController@isiOtomatis')->name('produksi.isiOtomatis');
    Route::get('/select2ukuran', 'PermintaanPembelianController@selectukuran')->name('ppbb.select2');
    Route::get('/ps', 'ProdukController@selectSatuan')->name('produkukuran.selectSatuan');
    Route::resource('api/pembeliantemp', 'PembelianTempApiController');

});
//Admin
Route::group(['middleware' => ['admin', 'auth']], function () {
    Route::resource('order', 'OrderController')->except(['show']);
    Route::resource('product', 'ProdukController')->except(['show']);
    Route::resource('api/produk', 'ProdukApiController');
    Route::get('produk/{id}/addharga', 'ProdukController@addHarga')->name('product.addHarga');
    Route::post('produk/harga/{id}', 'ProdukController@Harga')->name('product.harga');
    Route::get('produk/addHarga', 'ProdukController@addHargaManual')->name('produk.add.harga');
    Route::post('produk/simpanTemp', 'ProdukController@simpanTemp')->name('produk.save.harga');
    Route::get('pengambilan/faktur/{id}', 'PengambilanController@faktur')->name('pengambilan.faktur');
    Route::get('/faktur', function () {
        return view('back.order.faktur');
    })->name('faktur');
    Route::get('/admin/monitoringbahan', function () {
        return view('back.admin.monitoringbahan');
    })->name('monitoringbahan');
    Route::get('/pricelist', function () {
        return view('back.admin.pricelist');
    })->name('pricelist');
    Route::get('/admins', 'AdminController@indexAdmin')->name('index.admin');
    // Route::resource('api/produksi', 'ProduksiApiController');
    Route::resource('api/produktemp', 'ProdukTempApiController');
    Route::resource('pengambilan', 'PengambilanController')->except(['show']);
    Route::get('/admin/produksi/hasil', 'ProduksiController@HasilProduksi')->name('produksi.hasil');
    Route::resource('produksi', 'ProduksiController')->except(['show']);
    Route::get('produk/autocomplete', 'ProdukController@autocomplete')->name('produk.autocomplete');
    //Admin-DT
    Route::get('/produkk', 'ProdukController@dataTable')->name('produk.dt');
    Route::get('/orders', 'OrderController@dataTable')->name('order.dt');
    Route::get('/adminbahan', 'AdminController@dataTable')->name('adminbahan.dt');
    Route::get('/pricelistdt', 'AdminController@dataTablePriceList')->name('pricelist.dt');
    Route::get('/pricelistdt2', 'AdminController@dataTablePriceList2')->name('pricelist2.dt');
    Route::post('/ordersDetail', 'OrderController@dtDetail')->name('order.dtDetail');
    Route::post('/ordersDetailPayment', 'OrderController@dtDetailPayment')->name('order.dtDetailPayment');
    Route::post('/pricelistdetail', 'AdminController@dataTableDetail')->name('pricelist.dtDetail');
    Route::post('/pricelistdetail2', 'AdminController@dataTableDetail2')->name('pricelist2.dtDetail');
    Route::get('/dtpengambilan', 'PengambilanController@dtpengambilan')->name('pengambilan.dt');
    Route::post('/produksis', 'ProduksiController@dataTable')->name('produksi.dt');
    //Admin-Select2
    Route::get('/pb', 'ProdukController@select2')->name('produkbahan.select2');
    Route::get('/oi', 'OrderController@select2')->name('orderid.select2');
    Route::get('/listorder', 'OrderController@list')->name('order.list');
    Route::get('/selectukuran', 'ProdukController@selectukuran')->name('produkukuran.select2');
    Route::get('/laporan-pricelist', 'AdminController@lappricelist')->name('laporan.pricelist');
});
Route::get('/logout', 'AuthController@logout')->name('logout');
Route::post('/login', 'AuthController@login')->name('login')->middleware('guest');
Route::get('/register', 'AuthController@getRegister')->name('register')->middleware('guest');
Route::post('/register', 'AuthController@register')->name('register');

//Finance
Route::group(['middleware' => ['finance', 'auth']], function () {
    Route::resource('pembayaran', 'PembayaranController')->except(['show']);
    Route::get('/pembayarann', 'PembayaranController@dataTable')->name('pembayaran.dt');

    Route::get('/pembayarandt', 'PembayaranController@dataTable')->name('pembayaran.dt');
    Route::get('/pembayarandt2', 'PembayaranController@dataTable2')->name('pembayaran.dt2');
    Route::post('/pembayarandtdetail', 'PembayaranController@dataTableDetail')->name('pembayaran.dtDetail');
    Route::post('/pembayarandtdetailpayment', 'PembayaranController@dataTableDetailPayment')->name('pembayaran.dtDetailPayment');
    Route::get('/faktur/{id}','PembayaranController@faktur')->name('pembayaran.faktur');
    Route::get('/finances', 'AdminController@indexFinance')->name('index.finance');
    Route::get('/dp-finance', 'AdminController@WidgetFinance')->name('widget.finance');
});

//Setting
Route::group(['middleware' => ['setting', 'auth']], function () {
    Route::resource('setting', 'SettingController')->except(['show']);
    Route::get('/dtsetting', 'SettingController@dataTable')->name('setting.dt');
    Route::get('/dtsettingdashboard', 'SettingController@dataTableDashboard')->name('setting.dtDashboard');
    Route::get('/settings', 'AdminController@indexSetting')->name('index.setting');
    Route::get('/widget-setting', 'AdminController@SettingWidget')->name('index.setting-dashboard');
});
//Supervisor
Route::group(['middleware' => ['supervisor', 'auth']], function () {
    Route::resource('produksi-spv', 'ProduksiController')->except(['show']);
    Route::get('/list-spv', 'ProduksiController@listview')->name('produksi.list');
    Route::get('/hasil-spv', 'ProduksiController@Hasil')->name('produksi.hasil-spv');
    Route::get('/jadwal-spv', 'ProduksiController@Jadwal')->name('produksi.jadwal-spv');
    Route::get('/finishing', 'ProduksiController@Finishing')->name('produksi.finishing');
    Route::post('/produksis-monitoring', 'ProduksiController@dtMonitoringSPV')->name('produksi.dtMonitoringSPV');
    Route::post('/produksis/isiOtomatisSPV', 'ProduksiController@isiOtomatis')->name('produksi.isiOtomatisSPV');
    Route::post('/jadwalProduksiSPV', 'ProduksiController@dtProduksiSPV')->name('produksi.dtProduksiSPV');
    Route::get('/getInfo', 'ProduksiController@getInfo')->name('produksi.getInfo');
    Route::post('/jadwalProduksiSPV2', 'ProduksiController@dtProduksiSPV2')->name('produksi.dtProduksiSPV2');
    Route::post('/jadwalProduksi/bahan', 'ProduksiController@dataTableBahan')->name('produksi.dtBahanSPV');
    Route::post('produksis/prosesProduksi', 'ProduksiController@prosesProduksi')->name('produksi.prosesProduksi');
    Route::post('produksis/prosesFinishing', 'ProduksiController@prosesFinishing')->name('produksi.prosesFinishing');
    Route::post('produksis/updateStatus', 'ProduksiController@updateStatus')->name('produksi.updateStatus');
    Route::post('produksis/tidakadastatus', 'ProduksiController@tidakAdaStatus')->name('produksi.tidakAdaStatus');
    Route::post('produksis/pending', 'ProduksiController@pending')->name('produksi.pending');
    Route::post('produksis/done', 'ProduksiController@done')->name('produksi.done');
    Route::post('produksis/simpanDetail', 'ProduksiController@simpanDetail')->name('produksi.simpanDetail');
    Route::post('produksis/detailInspecting', 'ProduksiController@detailInspecting')->name('produksi.detailInspecting');
    // Route::post('produksi/createSession', 'ProduksiController@createSession')->name('produksi.create.session');
    Route::post('/supervisor/dt', 'ProduksiController@dataTable')->name('supervisor.dt');
    Route::post('produksis/ubahJadwal', 'ProduksiController@ubahJadwal')->name('produksi.ubahJadwal');
    Route::post('produksi/createSession', 'ProduksiController@createSession')->name('produksi.create.session');
    Route::post('/jadwal/dtJadwal', 'ProduksiController@dataTableJadwal')->name('produksi.dtJadwal');
    Route::post('/jadwal/dtJadwal2', 'ProduksiController@dataTableJadwal2')->name('produksi.dtJadwal2');
    Route::post('/jadwal/bahan', 'ProduksiController@dataTableBahan')->name('produksi.dtBahan');
    Route::get('/jadwal', 'ProduksiController@JadwalProduksi')->name('produksi.jadwal');
    Route::get('/jadwal2', 'ProduksiController@JadwalProduksi2')->name('produksi.jadwal2');
    Route::get('/get-chart', 'DirekturController@getMonthlyPostCountSPV')->name('get-chart');
    Route::get('/detail-chart', 'ProduksiController@detail_chart')->name('detail-chart');
    Route::post('/dt-detail', 'ProduksiController@dtDetail')->name('produksi.dtDetail');
    Route::get('/supervisory', 'AdminController@indexSupervior')->name('index.supervisor');
    Route::get('/faktur-detail/{id}', 'ProduksiController@fakturOrder')->name('produk.fakturOrder');


});
//Supervisor
Route::group(['middleware' => ['manajer', 'auth']], function () {
    Route::resource('manajerr', 'ManajerController')->except(['show']);
    Route::get('/dt', 'ManajerController@dataTable')->name('manajer.dt');
    Route::get('/dt2', 'ManajerController@dataTable2')->name('manajer.dt2');
    Route::get('/list-permintaan', 'ManajerController@listview')->name('manajer.list');
    Route::get('/list-permintaan2', 'ManajerController@listview2')->name('manajer.list2');
    Route::post('/approve', 'ManajerController@approve')->name('manajer.approve');
    Route::get('/manajers', 'AdminController@indexManajer')->name('index.manajer');
});

//AdminSys
Route::group(['middleware'=> ['adminsystem', 'auth']],function(){
    Route::get('/userdt', 'UserController@dataTable')->name('users.dt');
    Route::get('/user/updatestatus/{id}', 'UserController@updateStatus')->name('user.updatestatus');
    Route::get('/users', 'AdminController@indexAdminSys')->name('index.AdminSys');
});

//Cutting
Route::group(['middleware' => ['cutting', 'auth']],function(){
    Route::get('/cuttings', 'AdminController@indexCutting')->name('index.cutting');
    Route::get('/cuttings-widget', 'AdminController@WidgetCutting')->name('widget.cutting');
    Route::get('/cutting-proses', 'AdminController@prosesCutting')->name('proses.cutting');
    Route::post('cutting/simpanDetail', 'CuttingController@simpanDetail')->name('cutting.simpanDetail');
    Route::post('/jadwalProduksiCTG', 'CuttingController@dtProduksiCTG')->name('cutting.dtProduksiCTG');
    Route::post('/jadwalProduksiCTG2', 'CuttingController@dtProduksiCTG2')->name('cutting.dtProduksiCTG2');
    Route::get('/getInfoCTG', 'CuttingController@getInfo')->name('cutting.getInfo');
});

//Cutting
Route::group(['middleware' => ['printing', 'auth']],function(){
    Route::get('/printings', 'AdminController@indexPrinting')->name('index.printing');
    Route::get('/printings-widget', 'AdminController@WidgetPrinting')->name('widget.printing');
    Route::get('/printing-proses', 'AdminController@prosesPrinting')->name('proses.printing');
    Route::post('printing/simpanDetail', 'PrintingController@simpanDetail')->name('printing.simpanDetail');
    Route::post('/jadwalProduksiPTG', 'PrintingController@dtProduksiPTG')->name('printing.dtProduksiPTG');
    Route::post('/jadwalProduksiPTG2', 'PrintingController@dtProduksiPTG2')->name('printing.dtProduksiPTG2');
    Route::get('/getInfoPTG', 'PrintingController@getInfo')->name('printing.getInfo');
});
//Finishing
Route::group(['middleware' => ['finishing', 'auth']],function(){
    Route::get('/finishings', 'AdminController@indexFinishing')->name('index.finishing');
    Route::get('/finishings-widget', 'AdminController@WidgetFinishing')->name('widget.finishing');
    Route::get('/finishing-proses', 'AdminController@prosesFinishing')->name('proses.finishing');
    Route::post('finishing/simpanDetail', 'FinishingController@simpanDetail')->name('finishing.simpanDetail');
    Route::post('/jadwalProduksiFSG', 'FinishingController@dtProduksiFSG')->name('finishing.dtProduksiFSG');
    Route::post('/jadwalProduksiFSG2', 'FinishingController@dtProduksiFSG2')->name('finishing.dtProduksiFSG2');
    Route::get('/getInfoFSG', 'FinishingController@getInfo')->name('finishing.getInfo');
});

Route::group(['middleware'=> ['direktur', 'auth']],function(){
    //Route
    Route::get('/direktur/pricelist', 'DirekturController@pricelist')->name('direktur.pricelist');
    Route::get('/direktur/rekaporder', 'DirekturController@rekaporder')->name('direktur.rekaporder');
    Route::get('/direktur/produksi', 'DirekturController@produksi')->name('direktur.produksi');
    Route::get('/direktur/permintaanpbb', 'DirekturController@ppbb')->name('direktur.ppbb');
    //DT
    Route::get('/dtPriceList', 'DirekturController@dtPriceList')->name('direktur.dtPriceList');
    Route::get('/dtPriceList2', 'DirekturController@dtPriceList2')->name('direktur.dtPriceList2');
    Route::get('/dtRekapOrder', 'DirekturController@dtRekapOrder')->name('direktur.dtRekapOrder');
    Route::post('/dtProduksi', 'DirekturController@dtProduksi')->name('direktur.dtProduksi');
    Route::get('/dtPPBB', 'DirekturController@dtPPBB')->name('direktur.dtPPBB');
    Route::get('/get-post-chart-data', 'DirekturController@getMonthlyPostData')->name('get-post-chart-data');
    Route::get('/get-charts', 'DirekturController@getMonthlyPostCountSPV')->name('get-charts');
    Route::get('/get-charts-order', 'DirekturController@getMonthlyPostCountOrder')->name('get-charts-order');
    Route::get('/get-charts-PPBB', 'DirekturController@getMonthlyPostCountPPBB')->name('get-charts-PPBB');
    Route::get('/detail-charts', 'DirekturController@detail_chart')->name('detail-charts');
    Route::post('/dt-details', 'ProduksiController@dtDetail')->name('produksi.dtDetails');
    Route::get('/dt-rekaporder', 'DirekturController@dtRekapOrder')->name('dt.RekapOrder');
});
Route::get('/pricelist-direktur', 'AdminController@pricelist')->name('laporan.pricelistDirektur');

Route::resource('user', 'UserController')->except(['show']);
