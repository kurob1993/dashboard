<?php

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
Route::group(['middleware' => ['checkSession','checkMenu'] ],function(){
	Route::get('/', 'homeController@index');
	Route::get('/coba', 'homeController@coba');
	Route::get('/chart', 'homeController@chart');
	Route::get('/home_shippent/{produk}', 'homeController@shipprod');

	Route::get('/rkap', 'rkapController@index');
	Route::post('/upload', 'rkapController@upload');
	Route::post('/simpan_rkp', 'rkapController@save');

	/* Blcok untuk Grafik Operational */
	Route::get('/shipment', 'shipmentController@index');
	Route::get('/shipchart', 'shipmentController@shipchart');
	Route::get('/shipprod', 'shipmentController@shipprod');
	Route::get('/shipprodrange', 'shipmentController@shipprodrange');

	Route::get('/produksi', 'produksiController@index');
	Route::get('/proddaily', 'produksiController@proddaily');

	Route::get('/finance', 'financeController@index');
	Route::get('/findaily', 'financeController@findaily');
	//Route::get('/prodaccu', 'produksiController@prodaccu');

	// Blok menu Logistik
	Route::get('/prequest', 'prequestController@index');
	Route::get('/preqbln', 'prequestController@preqbln');

	Route::get('/porder', 'porderController@index');
	Route::get('/poeqbln', 'porderController@poeqbln');

	// logistik
	Route::get('/goodrc', 'goodrcController@index');

	//project
	Route::get('/on_going_project', 'projectongoController@index');
	Route::get('/project/{projectType}', 'projectongoController@pmo_project');
	Route::get('/projectChild/{project_id}', 'projectongoController@pmo_projectChild');
	Route::get('/project_chart/{project_id}', 'projectongoController@projectChart');
	Route::get('/budget_realization', 'budgetController@index');
	Route::get('/budget/{thn?}', 'budgetController@budget');

	//data master
	Route::get('/data_mes_sap', 'datamasterController@index');

	//daily_report
	Route::prefix('daily_report')->group(function () {
		Route::get('/', 'dailyReportController@index');
		Route::get('/show/{TANGGAL?}', 'dailyReportController@show');
		Route::get('/chart/kurs', 'dailyReportController@chartKurs');
		Route::get('/chart/saldobank/{tgl?}', 'dailyReportController@chartSaldoBank');
		Route::get('/chart/cash/{tgl?}', 'dailyReportController@chartCash');
		Route::get('/chart/hutang_lc/{tgl?}', 'dailyReportController@chartHutangLc');
		Route::get('/show/cash/{TANGGAL?}', 'dailyReportController@showCash');
		Route::get('/realisasi_foh/{tahun?}', 'realisasiFohController@index');
		Route::post('/realisasi_foh/show', 'realisasiFohController@show');
	});

	//detail produksi
	Route::prefix('last_prod')->group(function () {
	    Route::get('/', 'lastProdController@index');
		Route::get('/show/{plant?}', 'lastProdController@show');
		Route::get('/chart/{BEREICH?}/{ANLAGE?}', 'lastProdController@chart');
	});
	
	//Laporan PK
	Route::prefix('laporanpk')->group(function () {
	    Route::get('/', 'laporanPKController@index');
		Route::get('/show', 'laporanPKController@show');
		Route::get('/treegrid', 'laporanPKController@treegrid');
		Route::get('/treegridcc', 'laporanPKController@treeGridBaseOnCC');
		Route::get('/deskripsi', 'laporanPKController@deskripsi');
	});
	
	//Logistik
	Route::prefix('logistic')->group(function () {
		Route::get('/',function () {
			return redirect('/');
		});
		Route::get('/stock', 'stockController@index');
		Route::get('/show/{tanggal?}', 'stockController@show');
		Route::get('/detail/{tanggal?}/{description?}', 'stockController@detail');
	});

	//sdm
	Route::prefix('sdm')->group(function ()	{
		Route::get('/',function () {
			return redirect('/');
		});
		//organisasi
		Route::get('/organisasi', 'strukturOrganisasiController@index');
		Route::get('/organisasi/show', 'strukturOrganisasiController@show');
		
		//demografi
		Route::get('/demografi', 'demografiController@index');
		
		// input demografi
		Route::get('/input_data_sdm', 'inputDataSdmController@index');
		Route::post('/input_data_sdm/upload', 'inputDataSdmController@upload');
		Route::get('/input_data_sdm/berdasarkan/{data?}', 'inputDataSdmController@berdasarkan');

		//mhl
		Route::get('/mhl', 'mhlController@index');
		Route::get('/kpi', 'kpiController@index');
	});
	
	// User Access
	Route::prefix('user')->group(function () {
		Route::get('/', 'userController@index');
		Route::get('/get/{nik?}', 'userController@get');
		Route::get('/menu/{nik?}', 'userController@listMenu');
		Route::post('/show', 'userController@show');
		Route::post('/save', 'userController@save');
		Route::post('/update', 'userController@update');
		Route::post('/update_useraccess', 'userController@update_useraccess');
		Route::delete('/delete', 'userController@delete');

	});

	// rakordir
	Route::prefix('rakordir')->group(function () {
		//menu input rakordir
		Route::get('/', 'rakordirController@backdrop');
		Route::get('input_file', 'rakordirController@index');
		Route::get('form_input', 'rakordirController@formInput');
		Route::get('form_edit/{tanggal?}/{agenda?}', 'rakordirController@formEdit');
		Route::post('show_upload', 'rakordirController@showUpload');
		Route::post('upload', 'rakordirController@upload');
		Route::post('edit', 'rakordirController@edit');
		Route::get('hapus/{tanggal?}/{agenda?}', 'rakordirController@hapus');

		//menu materi rakordie
		Route::get('file/{tanggal?}/{backdrop?}', 'rakordirController@file');
		Route::post('show_materi/{tanggal?}', 'rakordirController@showMateri');
	});

	//invoice
	Route::prefix('invoice')->group(function () {
		Route::get('/', 'invoiceController@index');
		Route::get('show', 'invoiceController@show');
	});

	// new budget project
	Route::prefix('budget_project')->group(function () {
		Route::get('/', 'budgetProjectController@index');
		Route::post('show', 'budgetProjectController@show');
	});

});

Route::get('/data_produk', 'homeController@data_produk');
//auth
// Route::get('/login', 'homeController@login');
Route::get('/logout', 'homeController@logout');

// Route::get('/signin/{nik?}', 'homeController@sigin');
Route::post('/signin', 'homeController@sigin');

//ambil data mes
// date format Y-m-d
Route::get('/getdatames/{tgl?}', 'datamasterController@getDataMes');

//ambil data shipment dari eis
// date format Y-m-d
Route::get('/getshipment/{tgl?}', 'datamasterController@getshipment');

//get data dari sap
Route::get('/getdatasap', 'datamasterController@getdatasap');
Route::get('/getdatasap/test', 'datamasterController@hutang_kmk');

//get data detail poduksi
Route::get('/get_last_prod', 'lastProdController@getData');

//get data struktur organisasi dari HCI
Route::get('/get_orgtxt', 'strukturOrganisasiController@getOrgTxt');
Route::get('/get_orgunit', 'strukturOrganisasiController@getOrgUnit');
Route::get('/get_struktur', 'strukturOrganisasiController@getStrkturDisp');

//get kurs
Route::get('/daily_report/getkurs', 'dailyReportController@getkurs');
Route::get('/daily_report/getTglKurs', 'dailyReportController@getTglKurs');
Route::get('/daily_report/showkurs', 'dailyReportController@showKurs');
Route::get('/test/cash', 'datamasterController@kalkulasi_cash');
Route::get('/test/lc', 'datamasterController@kalkulasi_hurangLC');
Route::get('/test/saldo_bank', 'datamasterController@kalkulasi_saldoBank');
Route::get('/transfer/{tgl?}', 'datamasterController@transfer');

//ambil data invoice
Route::get('invoice/getfiles', 'invoiceController@getFiles');

//ambil data budget
Route::get('budget_project/getfiles', 'budgetProjectController@getFiles');


Route::get('/debug', 'debugController@index');
Route::post('/debug/upload', 'debugController@upload');
