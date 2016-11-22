<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('print', 'TransaksiController@test');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        if (Auth::user()->is('admin')) {
            session()->put('id', Auth::user()->id);
            session()->put('nama', Auth::user()->name);
            return redirect()->to(url('items'));
        } elseif (Auth::user()->is('waiters')) {
            session()->put('id', Auth::user()->id);
            session()->put('nama', Auth::user()->name);
            return redirect()->to(url('pilih'));
        } elseif (Auth::user()->is('cashier')) {
            session()->put('id', Auth::user()->id);
            session()->put('nama', Auth::user()->name);
            return redirect()->to(url('pilih'));
        }
    });

    Route::get('get/item', 'ItemsController@getItem');

    Route::get('poskasir/{table}', 'TransaksiController@kasir');
    Route::get('deliv', 'TransaksiController@delivery');
    Route::get('take', 'TransaksiController@take');
    Route::get('poswaiter/{table}', 'TransaksiController@waiters');
    Route::get('cart/{meja}/{harga}', 'TransaksiController@cart_total');
    Route::get('cart-min/{meja}/{harga}', 'TransaksiController@cart_min');
    Route::post('manager/code', 'TransaksiController@managerCode');

    Route::get('pilih', function () {
        return view('pos.pilih');
    });
    
    /*
    1 Transaksi
    - Cek no resi
     */

    Route::get('kasir/{id}', 'TableController@kasir');
    Route::get('waiter/{id}', 'TableController@waiter');
    Route::post('cancel',  'TransaksiController@cancel');
    Route::get('areawaiter', 'AreaController@waiter');
    Route::get('areakasir', 'AreaController@kasir');
    Route::get('cekNoResi/{no_resi}', 'TransactionsController@cekNoResi');
    /*
    1.1 Daftar Transaksi
     */
    Route::get('daftar-transaksi/{begin?}/{end?}', 'TransactionsController@daftarTransaksi');
    Route::put('update-transaksi/{id}', 'TransactionsController@updateTransaksi');
    Route::resource('transactions', 'TransactionsController');
    Route::get('search_accounts/{keyword}', 'AccountsController@searchAccounts');
    Route::get('detailTransaksi/{id}', 'TransactionsController@detailTransaksi');
    Route::get('transaksi-cari-kode/{code}', 'TransactionsController@searchByCode');
    Route::any('order', 'TransaksiController@order');
    Route::get('subtotal/{tran}', 'TransaksiController@subtotal');
    Route::put('bayar/{trans}', 'TransaksiController@bayar');
    Route::post('transaction/pay_deliv', 'TransaksiController@bayar_deliv');
    Route::post('transaction/pay_take', 'TransaksiController@bayar_take');
    Route::post('transaction/pay', 'TransaksiController@transactionPay');
    Route::get('transaction/detail/{id}', 'TransaksiController@detailTtrans');

    /*
    2 Stock
    - Barang
     */
    Route::resource('barang', 'BarangController');
    /*
    - Gudang
     */
    Route::get('gudang/createKeluar', 'GudangController@createKeluar');
    Route::resource('gudang', 'GudangController');
    Route::get('faktur', function () {
        return view('gudang.faktur');
    });
    /*
    - Tangki
     */
    Route::resource('tank', 'TankController');
    Route::get('transfer-tank', 'GudangController@transfer');
    Route::post('transfer-tank', 'GudangController@postTransfer');
    Route::get('uangJalan/{id}', 'TankController@uangJalan');
    Route::post('uangJalan/{id}', 'TankController@uangJalanStore');
    // Route::post('susut/{id}','GudangController@susut');
    Route::get('riwayatSusut/{id}', 'TankController@riwayatSusut');
    Route::get('susut', 'TankController@susut');
    Route::post('susut', 'TankController@susutPost');
    Route::delete('hapus-susust/{id}', 'TankController@susutDestroy');
    /*
    3 Akuntansi
    - Kas
     */
    Route::resource('bank', 'BankController');
    Route::resource('exportbank', 'BankController@exportBank');
    Route::get('transferDana', 'TransactionsController@transfer');
    Route::post('transferDana', 'TransactionsController@postTransfer');
    Route::get('indexKas', 'TransactionsController@indexKas');
    Route::get('indexKasTangki', 'TransactionsController@indexKasTangki');
    Route::get('penyesuaian-dana', 'TransactionsController@penyesuaianDana');
    Route::post('penyesuaian-dana', 'TransactionsController@penyesuaianDanaStore');
    /*
    - Daftar Giro
     */
    Route::get('daftarGiro', 'TransactionsController@indexGiro');
    Route::get('bilyetGiro/{id}', 'TransactionsController@bilyetGiro');
    Route::post('bilyetGiro/{id}', 'TransactionsController@storeBilyetGiro');
    /*
    - Hutang dan Piutang
     */
    Route::get('hutang', 'HutangPiutangController@indexHutang');
    Route::get('piutang', 'HutangPiutangController@indexPiutang');
    Route::get('show/{id}', 'HutangPiutangController@show');
    Route::get('pay/{id}', 'HutangPiutangController@pay');
    Route::get('payPiutang/{id}', 'HutangPiutangController@payPiutang');
    Route::post('bayarHutangPiutang/{id}', 'HutangPiutangController@bayarHutangPiutang');
    // Route::post('bayarHutang/{id}','HutangPiutangController@bayarHutang');
    // Route::post('bayarPiutang/{id}','HutangPiutangController@bayarPiutang');
    Route::get('detailHutang/{id}', 'HutangPiutangController@detailHutang');
    Route::post('cariHutangPiutang', 'HutangPiutangController@cariHutangPiutang');
    Route::get('daftarPiutangKaryawan', 'HutangPiutangController@daftarPiutangKaryawan');
    Route::get('listHutangPiutang/{id}', 'HutangPiutangController@listHutangPiutang');
    Route::get('cari-hutang-kode/{code}', 'HutangPiutangController@showByCode');
    Route::delete('hapus-bayar/{id}', 'HutangPiutangController@destroy');
    /*
    - Biaya
     */
    Route::get('biaya/{date?}', 'AccountsController@indexBiaya');
    Route::get('createBiaya', 'AccountsController@createBiaya');
    Route::post('biaya', 'AccountsController@postBiaya');
    Route::get('bayar', 'AccountsController@createDana');
    Route::post('bayar', 'AccountsController@postDana');
    Route::get('detailBiaya/{date}/{id}', 'AccountsController@detailBiaya');
    Route::get('biaya-edit/{id}', 'AccountsController@editBiaya');
    Route::put('biaya-edit/{id}', 'AccountsController@updateBiaya');
    Route::get('edit-detil-biaya/{id}', 'AccountsController@detilBiayaEdit');
    Route::put('edit-detil-biaya/{id}', 'AccountsController@detilBiayaUpdate');
    /*
    - Daftar Penjualan
     */
    Route::get('penjualan/{date?}', 'TransactionsController@penjualan');
    /*
    - Daftar Pembelian
     */
    Route::get('pembelian/{date?}', 'TransactionsController@pembelian');
    /*
    4 Karyawan
    - Data Karyawan
     */
    Route::resource('karyawan', 'KaryawanController');
    Route::get('kegiatan', 'KaryawanController@kegiatan');
    Route::get('absenKaryawan/{id}', 'KaryawanController@absenKaryawan');
    Route::post('absenKaryawanPost/{id}', 'KaryawanController@absenKaryawanPost');
    Route::get('aktif-karyawan/{id}', 'KaryawanController@aktifKaryawan');
    Route::get('non-aktif-karyawan/{id}', 'KaryawanController@nonAktifKaryawan');
    /*
    - Absensi Karyawan
     */
    Route::get('absenShow/{id}', 'KaryawanController@absenShow');
    Route::get('absenEdit/{id}', 'KaryawanController@absenEdit');
    Route::get('absenPilih', 'KaryawanController@absenPilih'); # <- Tambah absen
    Route::get('absensi', 'KaryawanController@absensi');
    Route::post('absensi', 'KaryawanController@absensiStore');
    Route::put('absensi/{id}', 'KaryawanController@absensiUpdate');
    Route::get('cekTanggalAbsen/{date}', 'KaryawanController@cekTanggalAbsen');
    /*
    - Sum Absen
     */
    Route::get('sumAbsen', 'KaryawanController@sumAbsen');
    Route::post('sumAbsen', 'KaryawanController@sumAbsenPost');
    Route::get('sum-absen-mingguan/{date?}', 'KaryawanController@sumAbsenMingguan');
    /*
    - Kasbon Karyawan
     */
    Route::get('kasbon', 'KaryawanController@kasbon');
    Route::post('kasbon', 'KaryawanController@kasbonStore');
    /*
    - Gaji
     */
    Route::get('slip/{id}', 'KaryawanController@slip');
    Route::get('slipGaji/{tipe?}/{date?}', 'KaryawanController@slipGaji');
    Route::get('gaji', 'KaryawanController@gaji');
    Route::get('gajiShow/{tipe?}/{date?}', 'KaryawanController@gajiShow');
    Route::post('hapus-gaji', 'KaryawanController@salaryDestroy');
    /*
    - Generate Gaji
     */
    Route::get('generate-gaji', 'KaryawanController@generateGaji');
    Route::post('generate-gaji', 'KaryawanController@rekapGajiStrore');
    /*
    5 Partner
     */
    Route::resource('partner', 'PartnerController');
    /*
    6 Tutup Buku
     */
    Route::get('tutupBuku', 'TransactionsController@tutupBuku');
    Route::post('tutupBuku', 'TransactionsController@tutupBukuPost');
    /*
    7 Export
     */
    Route::get('excelDetilBarang/{id}', 'BarangController@excelDetilBarang');
    Route::get('excelDetilTank/{id}', 'TankController@excelDetilTank');
    Route::get('excelIndexKas', 'TransactionsController@excelIndexKas');
    Route::get('excelIndexKasTangki', 'TransactionsController@excelIndexKasTangki');
    Route::get('excelDetilBank/{id}', 'BankController@excelDetilBank');
    Route::get('excelIndexGudang', 'GudangController@excelIndexGudang');
    Route::get('excelGajiShow/{date?}', 'KaryawanController@excelGajiShow');
    Route::get('excelIndexBank', 'BankController@excelIndexBank');
    Route::get('excelIndexBiaya', 'AccountsController@excelIndexBiaya');
    Route::get('excelDetilBiaya/{date}/{id}', 'AccountsController@excelDetilBiaya');
    Route::get('rawPenjualan', 'TransactionsController@rawPenjualan');
    Route::get('rawPembelian', 'TransactionsController@rawPembelian');
    Route::get('exportPenjualan/{date?}', 'TransactionsController@exportPenjualan');
    Route::get('exportPembelian/{date?}', 'TransactionsController@exportPembelian');
    Route::get('exportTrans', 'TransaksiController@exportExel');
    Route::get('exportTransMenu', 'TransaksiController@exportExelMenu');
    /*
    Other
     */
    Route::get('gantiPassword', 'UserController@gantiPassword');
    Route::post('gantiPassword', 'UserController@gantiPasswordPost');
    Route::resource('account', 'AccountController');

    /*
    - Category
    */
    Route::resource('category', 'CategoryItemsController');
    Route::resource('exportcategory', 'CategoryItemsController@exportCategory');
    /*
    - Items
    */
    Route::resource('items', 'ItemsController');
    Route::get('exportitems', 'ItemsController@exportItems');
    Route::get('items-by-cat/{id}', 'ItemsController@filter');

    /*
    Tables
     */
    Route::resource('table', 'TableController');
    Route::resource('exporttable', 'TableController@exportTable');

    /*
    Users
     */
    Route::resource('user', 'UserController');
    Route::get('exportuser', 'UserController@exportUser');

    Route::post('checkout', 'TransaksiController@checkout');

    Route::resource('area', 'AreaController');
    Route::resource('exportarea', 'AreaController@exportArea');
    // Route::resource('employee', 'EmployeeController');
    Route::get('r-income', 'TransaksiController@income');
    Route::get('filter-income/{begin?}/{end?}', 'TransaksiController@filterIncome');
    // Route::get('filter-rTrans/{begin?}/{end?}', 'TransaksiController@filterrTrans');
    // Route::get('filter-menu/{begin}/{end}', 'TransaksiController@filterMenu');
    Route::get('r-trans', 'TransaksiController@rTrans');
    Route::get('r-trans/{begin?}/{end?}', 'TransaksiController@filterTrans');    
    Route::get('r-menu', 'TransaksiController@rMenu');
    Route::get('r-menu/{begin}/{end}', 'TransaksiController@filterMenu');
    
    Route::resource('transaction', 'TransaksiController');
    Route::get('search_accounts/{keyword}', 'AccountController@searchAccounts');

    /*
    Menu
     */
    Route::resource('menu','MenuController');
    Route::resource('exportmenu','MenuController@exportMenu');
    Route::resource('member','EmployeeController');
    /*
    Hutang piutang
     */
    Route::get('piutang-karyawan', 'AccountController@piutangKaryawan');
    Route::get('piutang-karyawan-pos', 'AccountController@piutangKaryawanPOS');
    Route::get('pay-piutang-member/{id}','TransaksiController@showPayPiutang');
    Route::post('pay-piutang-member-post','TransaksiController@storePayPiutang');
    Route::get('pay-piutang-member-pos/{id}','TransaksiController@showPayPiutangPOS');
    Route::post('pay-piutang-member-post-pos','TransaksiController@storePayPiutangPOS');
    /*
     * Stock
     */
    Route::resource('stock','StockController');
    Route::get('exportstock','StockController@exportStock');
});
